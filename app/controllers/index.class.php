<?php

if(! defined('VERSION')) {
    die("非法引用改文件");
}

class Index extends Control {
    
    /**
     *  如果是 控制器 是 Index 那木， 默认的 方法也是 index 就一个构造函数了。 会自动执行， 
     *  所以防止执行， 用个  __construct()
     */
    public function __construct() {
        parent::__construct();
    }

    
    public function index() {
        global $sysfuns;
        $data = array(
            "name" => 'hiloong',
            "website" => 'http://www.hiloong.com'
        );
        $sysfuns->view('test' , $data, 'false');
      
    }
   
    
    
    public function index2() {
        global  $sysfuns;
        $sysfuns->load_model('blog');
        $blog = new Blog_model();
    }
}