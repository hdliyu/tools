<?php
namespace Hdliyu\Tools\fetch;

/**
 * @method base($baseTemplate) 设置基础模板
 * @method item($itemTemplate) 设置循环模板
 * @method path($path) 设置目录
 * @method config($path,$baseTemplate,$itemTemplate) 同时设置上面三个选项
 * @method makeHtml() 返回带格式HTML
 * @method makeText() 返回不带格式HTML
 */
class FetchFacade{

    public static function getFacadeAccessor(){
      return Fetch::class;
    }

    public static function __callStatic($name, $arguments)
    {
      $class = self::getFacadeAccessor();
      return call_user_func_array([new $class,$name],$arguments);
    }
}
