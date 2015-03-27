<?php

if(! defined('VERSION')) {
    die("非法引用改文件");
}

class Test extends  Control {

    public function __construct() {
        parent::__construct();
    }
    
    public function test() {
        echo "控制器名字：" . __CLASS__ . '方法' . __METHOD__;
    }
    
    public function index() {
        echo "控制器名字：" . __CLASS__ . '方法' . __METHOD__;
    }
}