<?php
ini_set('display_errors', 1);
include_once ("TinyBoard.php");
echo '<pre>';
\TinyBoard\TinyBoard::app();

$post = \TinyBoard\TinyBoard::getModel('\TinyBoard\Objects\Post')->load(1);
var_dump($post);

/*
$teste = new Renderer();
echo '<img src="data:image/png;base64,' . (string)$post->getImage(). '" />';
*/
