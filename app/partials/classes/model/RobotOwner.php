<?php

namespace Model\Robot;

class Owner 
{

    function __construct($data = null)
    {
        if(is_array($data)){
            foreach($data as $var => $val){
                $this->{$var} = $val;
            }
        }
    }

    function set_new_variable($var, $val)
    {
        $this->{$var} = $val;
    }

}