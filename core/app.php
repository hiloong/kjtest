<?php

if(! defined('VERSION')) {
    die("非法引用改文件");
}

/**
 *  运行一个实例
 */

class App {
    static public function  run() {
        global $control;
        
        $control = new Control(); // 这里就获得了 控制器的名字， 方法  ， 和参数 ，这是是个全局变量

        $C = new $control->controller;
        $method = $control->method;
        $args = $control->args;

        // 通过  call_user_func_array 执行类， 并使用 参数
        call_user_func_array(array($C , $method) , $args);

    }

}