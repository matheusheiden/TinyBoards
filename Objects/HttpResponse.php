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

}