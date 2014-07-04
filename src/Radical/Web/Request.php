<?php
/**
 * Created by PhpStorm.
 * User: splitice
 * Date: 5/29/14
 * Time: 9:26 AM
 */

namespace Radical\Web;


class Request {
    private static $request_id;
    static function request_id(){
        if(self::$request_id === null){
            self::$request_id = uniqid();
        }
        return self::$request_id;
    }
} 