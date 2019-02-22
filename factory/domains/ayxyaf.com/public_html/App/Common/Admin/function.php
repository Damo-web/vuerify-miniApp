<?php
/**
 * 检测是否支持GD库
 * 支持GD库返回数组类型的数据
 * 不支持返回false
 */
function check_gd_info()
{
	if(function_exists("gd_info"))
	{
		return gd_info();
	} else 
	{
		return false;
	}
}

/**
 * js跳转
 * Enter description here ...
 * @param unknown_type $url
 */
function js_jump($url)
{
	$html = '<script>';	
	$html .= "window.parent.href='".$url."';";
	$html .= '</script>';
	die($html);
}


/**
 * 远程下载服务器安装包
 */
function down_file($url, $file = "", $timeout = 120)
{
	$file = empty ( $file ) ? pathinfo ( $url, PATHINFO_BASENAME ) : $file;
	$dir = pathinfo ( $file, PATHINFO_DIRNAME );
	! is_dir ( $dir ) && @mkdir ( $dir, 0755, true );
	$url = str_replace ( " ", "%20", $url );
	
	if (function_exists ( 'curl_init' ))
	{
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		$temp = curl_exec ( $ch );
		if (@file_put_contents ( $file, $temp ) && ! curl_error ( $ch ))
		{
			return $file;
		} else
		{
			return false;
		}
	} else
	{
		$opts = array ("http" => array ("method" => "GET", "header" => "", "timeout" => $timeout ) );
		$context = stream_context_create ( $opts );
		if (@copy ( $url, $file, $context ))
		{
			return $file;
		} else
		{
			return false;
		}
	}

}

/**
 * 遍历一层目录
 * Enter description here ...
 * @param unknown_type $url
 */	
function sdir($path){
	foreach(scandir($path) as $filename){
		$exclude=array('.','..','Uploads');
		if(!in_array($filename,$exclude)){
			$true_path=$path.'/'.$filename;
			if(is_dir($true_path)){
				$dirname[]=$filename;
			}
		}
	}
	return $dirname;
}

function jsonString($str)
{
	return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
}
function formatBytes($bytes) {
	if($bytes >= 1073741824) {
		$bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
	} elseif($bytes >= 1048576) {
		$bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
	} elseif($bytes >= 1024) {
		$bytes = round($bytes / 1024 * 100) / 100 . 'KB';
	} else {
		$bytes = $bytes . 'Bytes';
	}
	return $bytes;
}

