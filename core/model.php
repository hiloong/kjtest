<?php

if(! defined('VERSION')) {
    die("非法引用改文件");
}

class Model {
    


    /**
     *  数据库初始化 
     */
    public function __construct() {
        global $sysfuns;
        global $config ;
        // 加载数据库配置文件
        $sysfuns->load_config('db');
        
        // 连接
        if( ! mysql_connect($config['db']['host'], $config['db']['user'], $config['db']['passwd'])) {
            die(mysql_error());
        } 

        // 选择数据库
        if( ! mysql_select_db($config['db']['dbname'])) {
            die(mysql_error());
        }
        
        // 选择编码
        mysql_query('set namse utf8');
        
    }
    
    /**
     *  数据查询
     */
    public function query($sql) {
        return mysql_query($sql);
    }
    

}