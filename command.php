#!/usr/bin/env php
<?php
/**
 * 【用法】
 *  php command.php 路径 【preview|html|text】
 */
use Hdliyu\Tools\fetch\FetchFacade;

require "vendor/autoload.php";
$base = <<<base


base;

$item = <<<item

item;
$path = $argv[1]??'';
$type = $argv[2]??'';
try{
    if(empty($path)) throw new Exception('错误：请传入目录参数');
    if(empty($type)) throw new Exception('错误：请传入类型参数');
    if(!is_dir($path)) throw new Exception('目录不存在');
    if(!in_array($type,['preview','html','text'])) throw new Exception('错误：类型仅支持：preview html text');
    $action = $type == 'preview' ?'makePreview':($type=='html'?'makeHtml':'makeText');
    echo file_put_contents('~runtime.html',FetchFacade::path($path)->$action())?'【~runtime.html】生成成功':'生成失败';
}catch(Exception $e){
    echo $e->getMessage();
}

