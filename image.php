<?php
$url = $_GET['url']??'';
empty($url) && die;
!file_exists($url) && die;
$mime = getimagesize($url)['mime'];
header("Content-Type:{$mime}");
$types = ['image/jpeg'=>'imagecreatefromjpeg','image/png'=>'imagecreatefrompng','image/gif'=>'imagecreatefromgif'];
$actions = ['image/jpeg'=>'imagejpeg','image/png'=>'imagepng','image/gif'=>'imagegif'];
$actions[$mime]($types[$mime]($url));
