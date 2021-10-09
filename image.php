<?php
$url = $_GET['url']??'';
empty($url) && die;
!file_exists($url) && die;
$mime = getimagesize($url)['mime'];
header("Content-Type:{$mime}");
$actions1 = ['image/jpeg'=>'imagecreatefromjpeg','image/png'=>'imagecreatefrompng'];
$actions2 = ['image/jpeg'=>'imagejpeg','image/png'=>'imagepng'];
$action1 = $actions1[$mime];
$action2 = $actions2[$mime];
$action2($action1($url));
