<?php

class Password
{
    public static function hash($password)
    {
       return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function check($password, $hash)
    {
        return password_verify($password, self::hash($hash));
    }

    public static function getInfo($hash)
    {
        return password_get_info($hash);
    }

}
