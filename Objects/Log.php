<?php
/**
 * Created by PhpStorm.
 * User: Matheus
 * Date: 12/5/2015
 * Time: 1:15 PM
 */

namespace TinyBoard\Objects;


use TinyBoard\TinyBoard;

class Log
{
    /**
     *  Default logging path
     */
    const DEFAULT_PATH = 'var/log/';

    /**
     * Warning level
     */
    const WARNING_FLAG = 0;

    /**
     * Error level
     */
    const ERROR_FLAG = 1;

    /**
     * Catastrophe level
     */
    const CATASTROPHE_FLAG = 999;

    /**
     * Debug level
     */
    const DEBUG_FLAG = -1;

    /**
     * Log constructor.
     * @param $fileName
     * @param $data
     * @param int $level
     * @param $skipCheck
     */
    public function __construct($fileName, $data, $level = 0, $skipCheck = false)
    {
        if ($this->canLog() || $skipCheck) {
            $this->createPath()->saveLog($fileName, $this->getLogType($level) ." - ".date("Y-m-d H:i:s", time())." - ". $data);;
        }
    }

    /**
     * verifies if logging is enabled
     * @return boolean
     */
    private function canLog()
    {
        return (boolean)TinyBoard::getConfig('logging/enabled');
    }

    /**
     * Saves log
     * @param $fileName
     * @param $string
     * @return Log
     */
    private function saveLog($fileName, $string) : Log
    {
        try {
            file_put_contents(self::DEFAULT_PATH . $fileName, $string."\n", FILE_APPEND);
            return $this;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * creates log path if it doesn't exist
     * @return Log
     */
    private function createPath() : Log
    {
        try {
            if (!is_dir(self::DEFAULT_PATH)) {
                mkdir(self::DEFAULT_PATH, 777, true);
            }
            return $this;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Defines log type
     * @param $flag
     * @return string
     */
    private function getLogType($flag)
    {
        switch ($flag) {
            case self::DEBUG_FLAG:
                return "<DEBUG> ";
            case self::WARNING_FLAG:
                return "<WARNING> ";
            case self::ERROR_FLAG:
                return "<DEBUG> ";
            case self::CATASTROPHE_FLAG:
                return "<CATASTROPHE> ";
        }
        return "";
    }
}