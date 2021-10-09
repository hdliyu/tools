<?php
use Hdliyu\Tools\fetch\FetchFacade;

require "vendor/autoload.php";
$base = <<<base


base;

$item = <<<item

item;
if(!isset($argv[1])) throw new Exception('命令行缺少目录参数');
if(!is_dir($argv[1])) throw new Exception('目录不存在');
echo file_put_contents('~runtime.html',FetchFacade::path($argv[1])->makeHtml())?'【~runtime.html】生成成功':'生成失败';
