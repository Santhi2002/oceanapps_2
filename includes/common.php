<?php
include(__DIR__ . "/../config/db_config.php");
include(__DIR__ ."/db_handler.php");
include(__DIR__ ."/func_handler.php");
include(__DIR__ ."/wpr_handler.php");
include(__DIR__ ."/exam_handler.php");
include(__DIR__ ."/meta_handler.php");
require __DIR__ . '/../plugins/vendor/autoload.php';
$func_handler=new Func_Handler();
$exam_handler=new Exam_Handler();
$wpr_handler=new Wpr_Handler();
$meta_handler=new Meta_Handler();

 ?>
