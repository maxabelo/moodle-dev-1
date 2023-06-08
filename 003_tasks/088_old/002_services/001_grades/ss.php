<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * External functions and service definitions.
 *
 * @package    block_course_view
 * @copyright  2023 Michael Alejandro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_course_view;
global $CFG;
require_once($CFG->dirroot . "/blocks/course_view/lib.php");
require_once($CFG->dirroot . "/blocks/course_view/constants.php");
use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;
use invalid_parameter_exception;
use local_additional_web_service\external_unsubscribe_to_forum;
use local_additional_web_service\external_subscribe_to_announcement_forum;
/**
 * @Class external_notification
 * @author 2022 Michael Alejandro
 * @package additional_web_service
 */
class external_finalized_course extends external_api
{
    public const STATUS_APPROVED = "_APPROVED";
    public const STATUS_CHANGE_TO_REPROBATE = "_CHANGE_TO_REPROBATE";
    public const DEFAULT_STATE_RESPONSE = "course_status_has_not_changed";
    /**
     * Returns description of sent_notification_parameters() parameters
     * @return external_function_parameters
     */
    public static function finalized_course_parameters()
    {
        $approved = static::STATUS_APPROVED;
        $changeToReprobate = static::STATUS_CHANGE_TO_REPROBATE;
        // The external_function_parameters constructor expects an array of external_description.
        return new external_function_parameters(
            [
                'user' => new external_single_structure(
                    [
                        'idnumber' => new external_value(PARAM_TEXT, 'id number user')
                    ]
                ),
                'course' => new external_single_structure(
                    [
                        'idnumber' => new external_value(PARAM_TEXT, 'id number course')
                    ]
                ),
                'state' => new external_value(PARAM_TEXT, "course status in external system ({$approved},$changeToReprobate) "),
            ]
        );
    }
    /**
     * Returns description of sent_notification_returns() result value
     * @return external_single_structure
     */
    public static function finalized_course_returns()
    {
        return new external_single_structure(
            [
                'status' => new external_value(PARAM_TEXT, 'status course'),
            ]
        );
    }
    /**
     * @param $user
     * @param $course
     * @param $state
     * @return string[]
     * @throws \dml_exception
     * @throws \moodle_exception
     * @throws invalid_parameter_exception
     */
    public static function finalized_course($user, $course, $state)
    {
        $params = self::validate_parameters(self::finalized_course_parameters(),
            [
                'user' => $user,
                'course' => $course,
                'state' => $state
            ]);
        $user = get_user_by_id_number_or_fails($user['idnumber']);
        $course = get_course_by_id_number_or_fails($course['idnumber']);
        $modinfo = get_fast_modinfo($course, $user->id);
        $countModules = 0;
        $countModulesCompleted = 0;
        //setearemos el traking de los foros a not traking
        //obtenemos todos los foros que existen en el curso da igual si esta o no subscrito
        self::untrackForums($user,$course);
        foreach ($modinfo->cms as $cmid => $mod) {
            $module = $modinfo->get_cm($cmid);
            $completionRulesUnClean =  (array) \core_completion\cm_completion_details::get_instance($module, $user->id, true)->get_details();
            if (!$module->has_view() || !$module->get_user_visible() || is_module_forum_news($module) || count($completionRulesUnClean) == 0) continue;
            $countModules++;
            $isCompleted = \core_completion\cm_completion_details::get_instance($module, $user->id, true)->get_overall_completion();
            if (!$isCompleted) continue;
            $countModulesCompleted++;
        }
        $hasCourseCompleted = $countModulesCompleted == $countModules;
        if ($hasCourseCompleted && $state == static::STATUS_APPROVED) {
            create_or_update_state_course_user($user->id, $course->id, FINALIZED);
            //Se envía la solicitud de desuscripción a todos los foros del curso
            external_unsubscribe_to_forum::unsubscribe_to_forum($user, $course,FINALIZED);
            return ['status' => FINALIZED];
        }
        if ($state == static::STATUS_CHANGE_TO_REPROBATE) {
            create_or_update_state_course_user($user->id, $course->id, OPEN_STARTED);
            // Se le suscribe de manera automática al foro tipo news del curso
            external_subscribe_to_announcement_forum::subscribe_to_announcement_forum($user, $course,1);
            return ['status' => OPEN_STARTED];
        }
        return ['status' => static::DEFAULT_STATE_RESPONSE];
    }
    public static function untrackForums($user,$course){
        global $DB,$USER;
        $forums = $DB->get_records('forum', array('course'=>$course->id));
        foreach ($forums as $forum) {
//            if(!forum_tp_is_tracked($forum,$user->id)){
                if(forum_tp_stop_tracking($forum->id,$user->id)){
                    $cm = get_coursemodule_from_instance("forum", $forum->id, $course->id);
                    $eventparams = array(
                        'context' => \context_module::instance($cm->id),
                        'relateduserid' => $user->id,
                        'other' => array('forumid' => $forum->id)
                    );
                    $event = \mod_forum\event\readtracking_disabled::create($eventparams);
                    $event->trigger();
                }
//            }
        }
    }
}




// 

public static function untrackAllForums($user, $course)
{
	global $DB, $USER;
	$forums = $DB->get_records('forum', array('course' => $course->id));
	foreach ($forums as $forum) {
		if (!forum_tp_is_tracked($forum, $user->id)) {
			if (forum_tp_stop_tracking($forum->id, $user->id)) {
				$cm = get_coursemodule_from_instance("forum", $forum->id, $course->id);
				$eventparams = array(
					'context' => \context_module::instance($cm->id),
					'relateduserid' => $user->id,
					'other' => array('forumid' => $forum->id)
				);
				$event = \mod_forum\event\readtracking_disabled::create($eventparams);
				$event->trigger();
			}
		}
	}
}



public static function trackForum($userid, $forum, $course)
{
	if (forum_tp_start_tracking($forum->id, $userid->id)) {
		$cm = get_coursemodule_from_instance("forum", $forum->id, $course->id);
		$eventparams = array(
			'context' => \context_module::instance($cm->id),
			'relateduserid' => $userid->id,
			'other' => array('forumid' => $forum->id)
		);
		$event = \mod_forum\event\readtracking_enabled::create($eventparams);
		$event->trigger();
	}
}


