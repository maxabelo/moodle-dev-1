<?php

// https://moodledev.io/docs/apis/subsystems/admin#settings-file-example
// aqui en los tipo Block y theme YA tenemos configurado el    $settings   y el admin tree
if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_testblock/showcourses',
                   get_string('showcourses', 'block_testblock'),
                   get_string('showcoursesdesc', 'block_testblock'),
                   0));
}