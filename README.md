# 方便地获取目录内容
> 遍历如下目录结构获取文件和图片生成,如下HTML结构，用于解决前端程序员手动复制粘贴HTML结构

![目录结构](dir.png)

![生成代码](preview.png)

## 安装
```shell
composer require hdliyu/tools
```

## 用法

1. 复制本项目目录下的image.php和command.php到项目根目录
2. 打开命令行，执行命令，语法： `php command.php 目录路径 类型`,类型支持preview,text,html
3. 按要求输入正确参数生成文件
