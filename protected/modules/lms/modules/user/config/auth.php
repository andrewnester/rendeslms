<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'student' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'LMS Student',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'teacher' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'LMS Teacher',
        'children' => array(
            'student',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'teacher',
        ),
        'bizRule' => null,
        'data' => null
    ),
);
