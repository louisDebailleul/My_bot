<?php
class App{

    static $db = null;

    static function getDatabase(){
        if(!self::$db){
            self::$db = new Database('admin', 'admin', 'my_bot');
        }
        return self::$db;
    }
 }