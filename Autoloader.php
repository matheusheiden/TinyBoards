<?php
/**
 * Created by PhpStorm.
 * User: Matheus
 * Date: 1/27/2016
 * Time: 10:03 PM
 */

namespace TinyBoard;

class Autoloader
{
    /**
     * File extension as a string. Defaults to ".php".
     */
    protected static $fileExt = '.php';
    /**
     * The top level directory where recursion will begin. Defaults to the current
     * directory.
     */
    protected static $pathTop = __DIR__;
    /**
     * A placeholder to hold the file iterator so that directory traversal is only
     * performed once.
     */
    protected static $fileIterator = null;
    /**
     * Autoload function for registration with spl_autoload_register
     *
     * Looks recursively through project directory and loads class files based on
     * filename match.
     *
     * @param string $className
     */
    public static function loader($className)
    {
        if ( strpos($className, "TinyBoard") !== false){
            $className = substr($className, 10);
        }

        $file = self::$pathTop.DIRECTORY_SEPARATOR. str_replace("\\", DIRECTORY_SEPARATOR, $className).self::$fileExt;
        if (file_exists($file) && !class_exists($className)){
            include_once $file;
        }
        else {
            throw new \Exception("Error trying to autoload `$file` it doesn't exist");
        }

    }
    /**
     * Sets the $fileExt property
     *
     * @param string $fileExt The file extension used for class files.  Default is "php".
     */
    public static function setFileExt($fileExt)
    {
        static::$fileExt = $fileExt;
    }
    /**
     * Sets the $path property
     *
     * @param string $path The path representing the top level where recursion should
     *                     begin. Defaults to the current directory.
     */
    public static function setPath($path)
    {
        static::$pathTop = $path;
    }
}
Autoloader::setFileExt('.php');
spl_autoload_register('TinyBoard\Autoloader::loader');
