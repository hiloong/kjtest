<?php

/**
 *  初始化工作
 * 
 *  主要是定义常量 ， 目录的检查
 */

header("Content-type:text/html;charset=utf8");

/**
 *  定义版本号
 */
define('VERSION', '0.01');

/**
 *  存储配置信息
 */
$config = array();

/**
 *  用来保存 控制器名字、 方法 、 和 参数 ， 这个变量 再 core/app.php  被写入值
 */
$control = '';

/*
 *  简化目录分割符号
 */
if( !defined('DS')) {
    define('DS' , DIRECTORY_SEPARATOR); 
} else {
    // 提示DS
    die("DS is ready defined ") ;
}


/**
 * 自动加载类函数
 */
function __autoload($file) {
   // 核心优先
    $file = strtolower($file);
    
    if(file_exists(CORE_DIR . $file .'.php')) {
        require CORE_DIR .$file . '.php' ;
    } else if (file_exists(CONTROLLERS_DIR . $file . '.class.php')) {
        // 加载控制器
        
        require CONTROLLERS_DIR . $file . '.class.php';
    } else {
        debug_print_backtrace();
        die("加载了不存在的类 $file");
    }
}



/*
 *  定义网站文件根目录
 * 
 *  这是文件的根目录， 用于文件系统
 */
define('ROOT_DIR' , str_replace(array('/', '\\'), DS, dirname(dirname(__FILE__)).'/')) ;


/**
 *  定义网站的根地址
 * 
 *  这个是用于 url ， 网址的访问
 *  !!! 这里不支持https
 */
define('URL_BASE', 'http://' . $_SERVER['HTTP_HOST'] . dirname( dirname($_SERVER['PHP_SELF']) ). '/');


/**
 *  定义核心系统的路径
 */
define('CORE_DIR', ROOT_DIR . 'core/');



/**
 *  定义 app
 *  
 *  APP 目录可以被覆盖
 */

if(!defined ('APP_DIR')) {
   define('APP_DIR', ROOT_DIR . 'app' . DS); 
}

// 程序目录不存在就创建
if( ! is_dir(str_replace('', '', APP_DIR))) {
    if(!mkdir(str_replace('', '', APP_DIR))) {
        die("程序目录不存在");
    } else {
        echo "mkdir ";
    }
} 



// 这个加载不是必须的， 可以自动加载
require_once   CORE_DIR . 'sysfuns.php';  

$sysfuns = new SysFuns();
if( ! $sysfuns->check_app_path() &&  !$sysfuns->make_app_dir()) {
    die("程序文件夹不完整，自动创建失败，请检查文件读写权限");
}

/**
 *  定义程序(app)路径
 */
define('CONFIG_DIR' , APP_DIR . 'config' . DS);
define('CONTROLLERS_DIR', APP_DIR . 'controllers' . DS);
define('HELPER_DIR' , APP_DIR . 'helper' . DS );
define('MODEL_DIR' , APP_DIR . 'model' . DS);
define('VIEW_DIR', APP_DIR .'view'. DS);



/**
 *  默认控制器, 默认方法
 */
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_METHOD', 'index');
define('FGF' , '-');  // 用来决定分隔符是什么， 方法和参数， 参数和参数之间的分隔符


/**
 *  这些是可以自动加载的
require  CORE_DIR . 'app.php';
require  CORE_DIR . 'model.php';
require  CORE_DIR . 'control.php';
require  CORE_DIR . 'session.php';
 */

App::run();






