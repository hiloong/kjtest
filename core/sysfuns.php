<?php

if(! defined('VERSION')) {
    die("非法引用改文件");
}

/** 
 *  系统函数类
 * 
 */
class SysFuns {
    
    /**
     *  app_dir 
     * 
     *  是一个数组，里面保存的信息 程序目录 app 里应该存在的文件夹
     *  比如： config, model , view , helper 等目录
     */
    private $app_dir;
    
            
    /** 
     *  初始化变量
     */
    public function __construct() {
        $this->app_dir = array(
            'config',       // 程序目录中的配置目录
            'controllers',  // 控制器
            'model',        // 程序目录中的模型目录
            'view',         // 程序目录中的视图目录
            'helper'        // 程序目录中的帮助目录
        );
    }
            
    /**
     *  检测程序(app) 目录
     * 
     *  程序的正常运行，需要有 $this->app_dir  的目录都存在
     *  这个函数就是检测完整性
     */
    public function check_app_path() {
        foreach($this->app_dir as $v) {
           if(!is_dir( APP_DIR . $v)) {
               return FALSE;
           }
        }
        return TRUE;
    }
    
    /**
     *  设置app应该有的目录
     * 
     *  按照 $this->app_dir 的内容进行设置
     *  如果发生错误返回false
     */
    public function make_app_dir() {
        foreach($this->app_dir as $v ) {
            if(!is_dir( APP_DIR . $v)) {
                if( ! mkdir(APP_DIR . $v)) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
    
    
    /**
     *  用于加载用户的配置文件
     */
    public function load_config($file) {
        if(file_exists(CONFIG_DIR . $file . '.php')) {
            require_once CONFIG_DIR . $file . '.php ';
        } else {
            die("用户配置文件 " . CONFIG_DIR . $file . '.php' . "不存在");
        }
    }
    
    /**
     *  用于加载数据库模型
     */
    public function load_model($file) {
        if(file_exists(MODEL_DIR . $file . '.php')) {
            require_once MODEL_DIR . $file . '.php ';
        } else {
            die("用户模型文件 " . MODEL_DIR . $file . '.php' . "不存在");
        }
    }
    
    
    /**
     *  用来加载视图
     *  
     *  如果 $bool 是真的 ，就是直接返回而不是输出
     *  如果 $bool 是假的， 就直接输出
     */
    public function view($file , $data = array() ,$bool = FALSE) {
        global  $control;
        
        $real_file = VIEW_DIR . $control->controller . DS . $file .'.php';
        if(file_exists($real_file)) {
            ob_start();
            
            foreach($data as $k => $v) {
                ${$k} = $v;
            }
            
            require "$real_file";
            $content = ob_get_contents();
            ob_clean();
            
            if( ! $bool) {
                return $content;
            } else {
                echo $content;
            }
        }
        
    }
    
}