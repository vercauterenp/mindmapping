<?php

class Model_Users extends \Orm\Model
{ 
    protected static $_table_name = 'users';
    protected static $_properties = array(
        'id',
        'username',
        'password',
        'email',
        'group',
        'last_login',
        'profile_fields',
        'forgot_password',
        'created_at',
        'updated_at'
    );
    protected static $_observers = array(
        'Orm\Observer_Created' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_Updated' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => false,
        ),
    );
}