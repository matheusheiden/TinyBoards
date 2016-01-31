<?php
/**
 * Created by PhpStorm.
 * User: Matheus
 * Date: 12/11/2015
 * Time: 9:19 PM
 */

namespace TinyBoard\Objects;


class HttpResponse
{
    public function setHeader($data)
    {
        header($data);
    }


    public function setResponse($data)
    {

    }

    public function redirect($url){
        header("Location: $url");
    }

    public function set404() {
        $this->setHeader($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    }

}