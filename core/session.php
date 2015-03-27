<?php


if(! defined('VERSION')) {
    die("非法引用改文件");
}

/**
 *  用于保存一些重要的信息
 * 
 *  这里假设用不自己使用 $_SESSION 
 *  以为 变量 $this->data 就是对 $_SESSION 的一个引用，他们是完全一样。 修改其中的一个值，另一个值也会改变
 *  
 *  如果想防止 "污染全局 $_SESSION " 也就是说 这个类 不好用的的时候， 可以 
 *  $this->data = &$_SESSION["这里随便用个不长用的名字就可以了"]
 */

class Session {
    private $ip ;    // 用户的IP地址
    private $name;   // 用户的名字
    private $data;   // 用来存放数据 , 用户的数据都应该存在再 $data 中， $data 是一个数组
    
    public function __construct() {
        if( ! session_start()) {
            die("session 开启失败");
        }
        $this->ip = $this->get_ip();
        $this->data = &$_SESSION;
    }
    
    
    /**
     * 写入 $this->data  ! 这是个覆盖写 
     * 
     * @param type $k  键的名字
     * @param type $v  键的值
     */
    public function set($k , $v = '') {
        if(is_array($k)) {
            foreach ($k as $key => $val) {
                $this->data[$key] = $val;
            }
            return;
        }
        $this->data[$k] = $v;
    }
    
    /**
     * 获得值 $this->data 中的 键值
     * 
     * @param type $k -- 键的名字
     * @return boolean 
     */
    public function get($k) {
        if(isset($this->data[$k])) {
            return $this->data[$k];
        }
        return FALSE;
    }
    
    public function all_date() {
        return $this->data;
    }
    
    /**
     *  清空所有的 $this->data 的内容
     */
    public function clean() {
        $this->data = array();
    }
    
    /**
     *   设置$this->name  
     *  
     *   这个名字设定后不能修改， 如果想保存用户的名字可以放到 $data 中
     */
    public function set_name($name) {
        if( ! $this->name) {
            $this->name = $name;
        }
    }
    
    /**
     * @return 没有设置 $this->name 返回 false
     */
    public function get_name() {
        if(isset($this->name)) {
            return $this->name;
        }
        return FALSE;
    }
    
    
    /**
     * 获取字符串形式的ip地址
     * 
     * 返回值： 获得不到争取的ip地址， 返回127.0.0.1
     */
    public function get_ip() {
        if(getenv("HTTP_CLIENT_IP")) {
            return getenv("HTTP_CLIENT_IP");
        } else if ( getenv('HTTP_X_FORWARDED_FOR')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        } else if ( getenv("REMOTE_ADDR")) {
            return getenv("REMOTE_ADDR");
        } else {
            return '127.0.01';
        }
    }
}