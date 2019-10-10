<?php
namespace Model\Robot;

use Model\Robot\Owner;
use Model\Robot\Platform;
get_class_file('model', 'Platform');
get_class_file('model', 'RobotOwner');

class Order {
    
    public $owner;
    public $platform;

    function __construct($data = null)
    {
        if(is_array($data)){
            $this->owner = new Owner($data['owner'] ?? null);
            $this->owner = new Platform($data['platform'] ?? null);
            unset($data['owner']);
            foreach($data as $var => $val){
                $this->{$var} = $val;
            }
        }
    }
    
}