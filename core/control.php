<?php

if (!defined('VERSION')) {
    die("非法引用改文件");
}

/**
 *  这里进行访问控制
 */
class Control {

    public $sub_uri;

    /**
     *  模块的名字
     */
    public $controller;

    /**
     *  方法的名字
     */
    public $method;

    /**
     *  参数列表
     */
    public $args;

    public function __construct() {
        $sub_uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);  // 这里没有对 字符 ? 的， 因为下一句直接给删除了。
        $sub_uri = self::secure_character($sub_uri);
        $sub_uri = trim($sub_uri, '/-'); //  '/' 这个字符很特殊
        $this->sub_uri = $sub_uri;
        $this->parse();
    }

    /**
     *  对 $sub_uri 进行解析。
     * 
     *  解析的过程就是  对  $module, $method, $args 的赋值 的过程
     *  $sub_uri 可以有一下几种形式  , 这里有配置文件 里的 FGF 来决定
     *  第一： moduel_name/method_name/arg1/arg2/ ....
     *  第二： modelu_name/metho_name-arg1-arg2 ....
     */
    public function parse() {

        // 目的是把 $this->sub_uri 分割成两个部分， 一个是模块的名字， 一个是 方法和其他的参数
        $arr = explode('/', $this->sub_uri, 2);

        if ($arr === array("")) { // 说明什么也没有获得， 就使用默认的模块 和 方法
            $this->controller = DEFAULT_CONTROLLER;
            $this->method = DEFAULT_METHOD;
            $this->args = array();
        } else if (count($arr) === 1) { // 说明只有一个控制名字， 没有方法
            $this->controller = $arr[0];
            $this->method = DEFAULT_METHOD;
            $this->args = array();
        } else {

            $this->controller = $arr[0];
            $arr[1] = str_replace(array('/', '-'), FGF, $arr[1]);  // 规整url

            $arr = explode(FGF, $arr[1], 2);
            $this->method = $arr[0];

            if (isset($arr[1])) {
                $this->args = explode(FGF, $arr[1]);
            } else {
                $this->args = array();
            }
        }


//        var_dump($this->controller);
//        var_dump($this->method);
//        var_dump($this->args);
    }

    public static function get_instance() {
        
    }

    /**
     *  对一些特殊字符进行过滤
     * 
     *  这个处理方式是 如果不是安全字符， 直接过滤掉 
     *  目前假定 安全字符是  字母数字 和  /-=& (四个字符)
     */
    static public function secure_character($s) {
        $ans = '';
        $str = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM/-=&';
        for ($i = 0; $i < strlen($s); $i++) {
            if (strpos($str, $s[$i])) {
                $ans .= $s[$i];
            }
        }
        return $ans;
    }

}



