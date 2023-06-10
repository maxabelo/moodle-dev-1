<?php 

public static function subscribe_to_announcement_forum($userid, $courseid, $subscribe): array
    {

        global $DB;

        $params = self::validate_parameters(self::subscribe_to_announcement_forum_parameters(), array(
            'userid' => $userid,
            'courseid' => $courseid,
            'subscribe' => $subscribe,
        ));

        $course = $DB->get_record('course', array('id' => $params['courseid']), '*', MUST_EXIST);
        $context = context_course::instance($course->id);

        $forum = $DB->get_record('forum', array('course' => $course->id, 'type' => 'news'), '*', MUST_EXIST);
        $cm = get_coursemodule_from_instance('forum', $forum->id, $course->id, false, MUST_EXIST);

        $forum->cmidnumber = $cm->id;
        $forum->modcontext = $context;

        $subscribed = \mod_forum\subscriptions::is_subscribed($params['userid'], $forum,'', $cm);
        $tracked = '';

        if ($subscribed && !$params['subscribe']) {
            \mod_forum\subscriptions::unsubscribe_user($params['userid'], $forum, $cm, $course);
            $tracked = 'trackremoved';
        } else if (!$subscribed && $params['subscribe']) {



            $sql = "SELECT * FROM {forum_subscriptions} f WHERE f.userid = :userid AND f.forum = :forumid";
            $forumdb = $DB->get_record_sql($sql, ['userid' => $userid, 'forumid' => $forum->id]);

            if (empty($forumdb)) {
                error_log(json_encode(['subscribed' => $subscribed, 'params' => $params]));
                \mod_forum\subscriptions::subscribe_user($params['userid'], $forum, $cm, $course);

                $tracked = self::trackForum($userid, $forum, $course);
            }



        }

        return [
            'userid' => $params['userid'],
            'courseid' => $params['courseid'],
            'subscribe' => $params['subscribe'],
            'tracking_status' => $tracked,
        ];
    }
