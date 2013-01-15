<?php

class Model_Messages extends \Orm\Model
{ 
    protected static $_table_name = 'messages';
    protected static $_properties = array(
        'id',
        'user_id',
        'user_name',
        'receiver_id',
        'receiver_name',
        'title',
        'message',
        'is_read' => array('default' => 0),
        'created_at'
    );
}