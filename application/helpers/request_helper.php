<?php
class Request {

    public static function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest';
    }
}