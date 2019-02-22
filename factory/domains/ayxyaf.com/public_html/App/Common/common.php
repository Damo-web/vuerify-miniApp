<?php
/**
 * 公用函数库
 */

/* 调试快捷函数 */
function debug($var, $end = true)
{
	header ( "Content-type:text/html;charset=utf-8" );
        echo '<pre>';
	echo '<hr>';
	//var_dump($var);
	print_r ( $var );
	echo '<hr>';
	echo '</pre>';
	if ($end)
	{
		exit ();
	}
}

/* 调试快捷函数别名 */
function Z($var, $end = true)
{
	debug ( $var, $end );
}

/* 空模块处理 */
function __hack_module(){    
    A('Common')->_404();
}

/* 空操作处理 */
function __hack_action(){
    A('Common')->_404();
}


/* 提交过滤 */
if (get_magic_quotes_gpc ())
{
	function stripslashes_deep($value)
	{
		$value = is_array ( $value ) ? array_map ( 'stripslashes_deep', $value ) : stripslashes ( $value );
		return $value;
	}
	$_POST = array_map ( 'stripslashes_deep', $_POST );
	$_GET = array_map ( 'stripslashes_deep', $_GET );
	$_COOKIE = array_map ( 'stripslashes_deep', $_COOKIE );
}

/**
 * [http_transport description]
 * @param  [type] $url    [description]
 * @param  array  $params [description]
 * @param  string $method [description]
 * @return [type]         [description]
 */
function http_transport($url, $params = array(), $method = 'POST')
{
    $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url .'?'. http_build_query($params);
            break;
        case 'POST':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
    }       
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    curl_close($ch);
    if ($err > 0) {     
        // $this->error = $errmsg; 
        return false;
    }else {
        return $data;
    }
}

/**
 * 加密算法
 * @param  string $data 加密字符串
 * @param  string $key  密钥
 * @return string       
 */
function encrypt($data, $key)
{
    $key = md5($key);
    $x  = 0;
    $len = strlen($data);
    $l  = strlen($key);
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l) 
        {
         $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
}

?>