<?php

class ConfigDB
{

    public static function getConfig(){
        switch ($_SERVER['SERVER_NAME']){
            default:
                $configDB = array(
                    'hostname' => 'localhost',
                    'usuario' => 'root',
                    'password' => '',
                    'bd' => 'tombola',
                    'puerto' => '3308'
                );
                break;
        }
        return $configDB;
    }

}
