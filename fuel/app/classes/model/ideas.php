<?php

class Model_Ideas extends \Orm\Model
{ 
    protected static $_table_name = 'ideas';
    protected static $_properties = array(
        'id',
        'title',
        'description',
        'idea',
        'preview',
        'user_id',
        'created_at',
        'updated_at'
    );
    
}