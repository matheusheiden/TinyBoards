<?php
ini_set('display_errors', 1);
include_once ("TinyBoard.php");
use TinyBoard\TinyBoard;

/**
 * Start session and application
 */
TinyBoard::app();

/**
 *  Starts controllers actions
 */
TinyBoard::controllerStarter();

