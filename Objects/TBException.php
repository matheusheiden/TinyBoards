<?php
/**
 * Created by PhpStorm.
 * User: Matheus
 * Date: 12/5/2015
 * Time: 12:16 PM
 */

namespace TinyBoard\Objects;


class TBException extends \Exception
{

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        echo "huhuasdhusad";
        new Log("Exception.log", $message . "\n" . $this->getTraceAsString(), Log::CATASTROPHE_FLAG);
        parent::__construct($message, $code, $previous);
    }
}