<?php
use Hdliyu\Tools\fetch\FetchFacade;

require "vendor/autoload.php";
$base = <<<base


base;

$item = <<<item

item;
$path = $argv[1]??'';
$type = $argv[2]??'';
if(empty($path)) throw new Exception('缺少参数1：目录');
if(!is_dir($path)) throw new Exception('目录不存在');
if(empty($type)) throw new Exception('缺少参数2：类型，支持：【preview html text】');
if(!in_array($type,['preview','html','text'])) throw new Exception('参数2错误，仅支持：【preview html text】');
$action = $type == 'preview' ?'makePreview':($type=='html'?'makeHtml':'makeText');
echo file_put_contents('~runtime.html',FetchFacade::path($path)->$action())?'【~runtime.html】生成成功':'生成失败';
