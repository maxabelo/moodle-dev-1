<?php

require_once(__DIR__ . '/../../config.php');

require_login();

global $DB, $USER;

$selected_status   = optional_param('selected_status', null, PARAM_INT);    // Turn editing on and off

if ($selected_status == -1) {
    $sql  = "SELECT id, fullname,  idnumber FROM mdl_course WHERE id != ?";
    $records = $DB->get_records_sql($sql, array(1));
} else {
    $sql  = "SELECT id, fullname,  idnumber FROM mdl_course WHERE id !=? AND VISIBLE = ?";
    $records = $DB->get_records_sql($sql, array(1, $selected_status));
}

$table = "<table> <tbody>";
$table .= "<tr class='header'> 
    <th>" . get_string('srn', 'block_mycourselist') . "</th>
    <th>" . get_string('course_name', 'block_mycourselist') . "</th>
    <th>" . get_string('course_id', 'block_mycourselist') . "</th>
</tr>";

$counter = 1;
foreach ($records as $course) {
    $table .= "<tr> 
        <td>" . $counter++ . "</td>
        <td>" . $course->fullname . "</td>
        <td>" . $course->idnumber . "</td>
        </tr>";
}
$table .= "</tbody></table>";
echo $table;
die;
