<?php
/**
 * 安装智美首页
 * Enter description here ...
 * @author Administrator
 *
 */
class IndexAction extends CommonAction {
	protected $url = '';
	function __construct()
	{
		parent::__construct();
		$this->url = C('INSTALL_SERVER');
		$this->assign('url', $this->url);
		$this->assign('root_dir', __ROOT__);
	}
	/**
	 * 环境检测
	 * Enter description here ...
	 */
	function Index()
	{
		$server['os'] 			= PHP_OS;
		$server['web'] 			= $_SERVER['SERVER_SOFTWARE'];
		$server['php'] 			= PHP_VERSION;
		$server['upload'] 		= get_cfg_var('upload_max_filesize');
		$server['dir'] 			= ROOT;
		//$server['hd'] 		= filesize($dir);echo 200-round($totaldisk/1024/1024,1);
		$dependency['mysql'] 	= (function_exists('mysql_connect') ? '支持&nbsp;&nbsp;<img src="'.$this->url.'img/ok.png" />' : '不支持&nbsp;&nbsp;<img src="'.$this->url.'img/error.png" />'); //mysql支持
		$dependency['gd'] 		= (gdversion() ? '支持&nbsp;&nbsp;<img src="'.$this->url.'img/ok.png" />' : '不支持&nbsp;&nbsp;<img src="'.$this->url.'img/error.png" />'); //GD库支持
	  	$result 				= apache_get_modules();
        $dependency['rewrite'] 	= (in_array('mod_rewrite', $result) ?  '支持&nbsp;&nbsp;<img src="'.$this->url.'img/ok.png" />' : '不支持&nbsp;&nbsp;<img src="'.$this->url.'img/error.png" />'); 
       
		$permission['Runtime'] 	= (TestWrite(ROOT.'/App/Runtime') ? '<div class="jiance2">可写&nbsp;&nbsp;<img src="'.$this->url.'img/ok.png" /></div><div class="jiance3">可写</div>': '<div class="jiance2">不可写&nbsp;&nbsp;<img src="'.$this->url.'img/error.png" /></div><div class="jiance3">可写</div>');
		$permission['tpl'] 		= (TestWrite(ROOT.'/App/Tpl') ? '<div class="jiance2">可写&nbsp;&nbsp;<img src="'.$this->url.'img/ok.png" /></div><div class="jiance3">可写</div>': '<div class="jiance2">不可写&nbsp;&nbsp;<img src="'.$this->url.'img/error.png" /></div><div class="jiance3">可写</div>');
		// $permission['m'] 		= (TestWrite(ROOT.'/m') ? '<div class="jiance2">可写&nbsp;&nbsp;<img src="'.$this->url.'img/ok.png" /></div><div class="jiance3">可写</div>': '<div class="jiance2">不可写&nbsp;&nbsp;<img src="'.$this->url.'img/error.png" /></div><div class="jiance3">可写</div>');

		$this->assign('server', 	$server);
		$this->assign('dependency', $dependency);
		$this->assign('permission', $permission);
		$this->display('check');
	}
	
	/**
	 * 网站 数据库配置
	 * Enter description here ...
	 */
	function config()
	{
		if($_POST)
		{
			header("Content-type:text/html;charset=utf-8");
			//读取基本配置
			$base_config = dirname(__FILE__)."/config.ini.php";
			//写入配置文件
			$config		 = ROOT."/App/Conf/config.php";
			$fp = fopen($base_config,"r");
    		$configStr = fread($fp,filesize($base_config));
    		
    		//数据库和DA配合使用.
    		
			if(is_file(ROOT.'/config.php'))
	    	{
	    		$db = include_once'config.php';
	    		$db_host 	= $db['db_host'];
	    		$db_name 	= $db['db_name'];
	    		$db_user 	= $db['db_user'];
	    		$db_pwd 	= $db['db_pwd'];
	    		$db_prefix 	= $db['db_prefix'];		
	    	}else
	    	{
	    		$db_host 	= $_POST['db_host'];
	    		$db_name 	= $_POST['db_name'];
	    		$db_user 	= $_POST['db_user'];
	    		$db_pwd 	= $_POST['db_pwd'];
	    		$db_prefix 	= $_POST['db_prefix'];	
	    	}
    		
    		$db_lang 	= 'utf8';
    		
    		//数据库配置替换
		    $configStr = str_replace("~dbhost~",$db_host,$configStr);
		    $configStr = str_replace("~dbname~",$db_name,$configStr);
		    $configStr = str_replace("~dbuser~",$db_user,$configStr);
		    $configStr = str_replace("~dbpwd~",$db_pwd,$configStr);
		    $configStr = str_replace("~dbprefix~",$db_prefix,$configStr);
		    
		    //修改成自己的数据库配置文件
			@chmod($config,0777);
		    $fp = fopen($config,"w") or die("<script>alert('写入配置失败，请检查'.$config.'目录是否可写入！');history.go(-1);</script>");
		    fwrite($fp,$configStr);
		    fclose($fp);
		    
    		//数据库连接
    		$conn = mysql_connect ( $db_host, $db_user, $db_pwd ) or die ( "数据库服务器或登录账号或者密码错误，无法连接数据库，请重新设定！" );
    		//mysql_query("CREATE DATABASE IF NOT EXISTS `".$db_name."`;",$conn);
    		mysql_query("set names 'utf8'");
    		mysql_select_db($db_name) or die("<script>alert('选择数据库失败，可能是你没权限，请预先创建一个数据库！');history.go(-1);</script>");
			//检测数据库版本
			$rs = mysql_query("SELECT VERSION();",$conn);
		    $row = mysql_fetch_array($rs);
		    $mysqlVersions = explode('.',trim($row[0]));
		    $mysqlVersion = $mysqlVersions[0].".".$mysqlVersions[1];
		    
			if($mysqlVersion >= 4.1)
		    {
		        $sql4tmp = "MyISAM DEFAULT CHARSET=".$db_lang;
		    }
		    
		    $query = '';
		    $fp = fopen(dirname(__FILE__).'/data.sql','r');
		    while(!feof($fp))
		    {
		        $line = rtrim(fgets($fp,1024));
		        if(preg_match("#;$#", $line))
		        {
		            $query .= $line."\n";
		            $query = str_replace('#@__',$db_prefix,$query);
		            if($mysqlVersion < 4.1)
		            {
		                $rs = mysql_query($query,$conn);
		            } else {
		                if(preg_match('#CREATE#i', $query))
		                {
		                	//z($query, false);
		                    $rs = mysql_query(preg_replace("#MyISAM#i",$sql4tmp,$query),$conn);
		                }
		                else
		                {
		                    $rs = mysql_query($query,$conn);
		                }
		            }
		            $query='';
		        } else if(!preg_match("#^(\/\/|--)#", $line))
		        {
		            $query .= $line;
		        }
		        
		    }
		    fclose($fp);
		    
		    //更新网站配置
		    $web_url 	= $_REQUEST['domain'];
		    $web_name 	= $_REQUEST['web_name']; 
		    $web_money 	= $_REQUEST['money'];
		    $icp_num 	= $_REQUEST['icp_num'];
		    
		    $query = "Update `{$db_prefix}config` set value='{$web_name}' where `key`='web_name';"; //网站名称
		    mysql_query($query,$conn);
		   
		    $query = "Update `{$db_prefix}config` set value='{$web_url}' where `key`='web_url';"; //网站URL
		    mysql_query($query,$conn);
		   
		    $query = "Update `{$db_prefix}config` set value='{$web_money}' where `key`='web_money';"; //网站金额
		    mysql_query($query,$conn);
		    
			$query = "Update `{$db_prefix}config` set value='{$icp_num}' where `key`='icp_num';";	//网站备案
		    mysql_query($query,$conn);
		    
		    //增加管理员帐号
		    $user 	= $_POST['user'];
		    $pwd	= $_POST['pwd']; 
			$query = "INSERT INTO `{$db_prefix}user` (`id`, `username`, `password`) VALUES	(NULL, '$user', '".$pwd."');";
		    mysql_query($query,$conn);
		    header('Location:'.__GROUP__.'/Index/select');
		    exit;			
		}

		$this->assign('local_server','http://'.$_SERVER['HTTP_HOST'] . __ROOT__);

		if(is_file(ROOT.'/config.php'))
    	{
    		$this->assign('config','1');		
    	}else
    	{
    		$this->assign('config','0');
    	}
		$this->display();
	}
	
	/**
	 * 安装选项
	 * Enter description here ...
	 */
	function select()
	{
		if($_POST)
		{	//栏目选择
			// z($_POST);			
			$style = $_REQUEST['style'];
			
			//选择风格 清除其他风格模板
			import("ORG.Util.File");
			$file = new File;
			$tpl_dir = ROOT."/App/Tpl/Home/"; //模板目录
			$list_dir = $file->listDir($tpl_dir);
			$data = array('value'=>$style);
			
			D('config')->where("`key`='current_theme'")->save($data);
			//修改Home配置文件
			$base_config = ROOT."/App/Conf/Home/config.php";
			
			//z($base_config);
			$fp = fopen($base_config,"r");
			$configStr = fread($fp,filesize($base_config));
			$configStr = str_replace('Default', $style, $configStr);
			fclose($fp);
			
			@chmod($base_config,0777);
			$fp = fopen($base_config,"w");			
		    fwrite($fp,$configStr);
		    fclose($fp);
			
			foreach($list_dir as $key=>$value)
			{
				if ($style != $key && $key!= 'Uploads')
				{
					$file->unlinkDir($value);
				}
			}
			//QFTouch注册开户
			if ($_POST['qt_reg'] == '1') {
				header('Content-Type: text/html; charset=UTF-8');
				$url = 'http://www.qftouch.com/api.php?action=register';
				$_POST['qt']['sitename'] = M('config')->where(array('key'=>'web_name'))->getField('value');			
				$_POST['qt']['siteurl'] = 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__;			
				$_POST['qt']['signature'] = encrypt(strval(time()), 'qftouch');
				$ret = http_transport($url, $_POST['qt']);
				$qt = json_decode($ret);
				if ($qt->status == '1') {
					// 成功保存配置文件
					$api_config = ROOT."/App/Conf/api.php";
					$api = array(
						'API_URL' => 'http://www.qftouch.com/api.php',
						'M_URL' => 'http://' . $qt->M_URL,
						'API_ID' => $qt->API_ID,
						'API_SECRET' => $qt->API_SECRET,
						'API_VERSION' => '1.1',
						'API_STATUS' => 'ok',						
					);
					$configStr = "<?php\n return " . var_export($api, true) . ";";
					if(file_put_contents($api_config, $configStr)) {
	                    //首次同步数据  
	                    $api = A('Home/Api');
	                    $api->debug = true;                   
	                    $api->index('synchro');
	                }else{
	                	$href = "<script>alert('写入QFTouch配置文件失败，请完成安装后手动配置QFTouch接口');location.href='".__GROUP__."/Index/contact';</script>";
	                }				
				}else if($qt->status == '-1'){
					$href = "<script>alert('非法QFTouch注册');history.go(-1);</script>";
				}else if($qt->status == '2'){
					$href = "<script>alert('QFTouch自动绑定失败，请完成安装后手动绑定');location.href='".__GROUP__."/Index/contact';</script>";
				}else if($qt->status == '3'){
					$href = "<script>alert('网站模版不可用，请重新选择');history.go(-1);</script>";
				}else{	
					$href = "<script>alert('QFTouch开户失败，原因：账号/二级域名已存在');history.go(-1);</script>";
				}
			}
			//选择需要安装的扩展
			$column = array(
						'switch_introduction'	=> '1',
						'switch_news' 			=> '1',
						'switch_product'		=> '1',
						'switch_contactus'		=> '1',
						'switch_order'			=> '0',
						'switch_message'		=> '0',
						'switch_jobs'			=> '0',
					);
			
			foreach($_POST as $key=>$value)
			{
				if(array_key_exists($key, $column))
				{
					$column[$key] = $value;
				}
			}			
		   
			//公司简介
			$data = array('value'=>$column['switch_introduction']);
			D('config')->where("`key`='switch_introduction'")->save($data);
			
			//新闻中心
			$data = array('value'=>$column['switch_news']);
			D('config')->where("`key`='switch_news'")->save($data);
			
			//联系我们
			$data = array('value'=>$column['switch_contactus']);
			D('config')->where("`key`='switch_contactus'")->save($data);
			
			//在线订单
			$data = array('value'=>$column['switch_order']);
			D('config')->where("`key`='switch_order'")->save($data);
			
			//在线留言
			$data = array('value'=>$column['switch_message']);
			D('config')->where("`key`='switch_message'")->save($data);
			
			//人才招聘
			$data = array('value'=>$column['switch_jobs']);
			D('config')->where("`key`='switch_jobs'")->save($data);
			if ($href) {  // 错误提示
				echo $href;
				exit();
			}
			header('Location:'.__GROUP__.'/Index/contact');
		    exit;
			
		}
		$this->display();
	}
	
	/**
	 * 配置联系我们
	 * Enter description here ...
	 */
	function contact()
	{
		if($_POST)
		{
			//联系人
			$data = array('value'=>$_POST['linkman']);
			D('config')->where("`key`='linkman'")->save($data);
			
			//固定电话
			$data = array('value'=>$_POST['tel']);
			D('config')->where("`key`='tel'")->save($data);
			
			//手机
			$data = array('value'=>$_POST['mobile']);
			D('config')->where("`key`='mobile'")->save($data);
			
			//电子邮箱
			$data = array('value'=>$_POST['email']);
			D('config')->where("`key`='email'")->save($data);
			
			//公司地址
			$data = array('value'=>$_POST['address']);
			D('config')->where("`key`='address'")->save($data);
			
			//公司传真
			$data = array('value'=>$_POST['fax']);
			D('config')->where("`key`='fax'")->save($data);
			
			//$this->redirect(__GROUP__.'/Index/done');
			header('Location:'.__GROUP__.'/Index/done');
		}
		$this->display();
	}
	
	function done()
	{
		
		$this->assign('web_url', __ROOT__.'/');
		$this->assign('admin_url', __ROOT__.'/Admin');
		$this->display();
		
	}
	
	/**
	 * ajax提交数据
	 * Enter description here ...
	 */
	function ajax()
	{
		//z($_REQUEST);
		switch($_REQUEST['t'])
    	{
    		//数据库检测
    		case 'test_db':
    			$this->check_db();
    			break;
    		case 'web_info':
    			$this->check_web();
    			break;
		}
	}
	
	//数据库检测函数
	protected function check_db()
	{
		$db_host = $_REQUEST ['db_host'];
		$db_user = $_REQUEST ['db_user'];
		$db_pwd = $_REQUEST ['db_pwd'];
		$db_name = $_REQUEST ['db_name'];
		
		$conn = mysql_connect ( $db_host, $db_user, $db_pwd ) or die ( $this->ajaxReturn ( "数据库服务器或登录账号或者密码错误，无法连接数据库，请重新设定！", 'JSON', 0 ) );
		mysql_select_db ( $db_name ) or die ( $this->ajaxReturn ( "选择数据库失败，可能是你没权限，请填写正确的数据库名称！", 'JSON', 0 ) );
		
		if ($db_host && $db_user && $db_name)
		{
			die ( $this->ajaxReturn ( '验证成功', 'JSON', 0 ) );
		} else
		{
			die ( $this->ajaxReturn ( '验证失败,必填写不可以为空', 'JSON', 1 ) );
		}
	}


	
}

/**********************************************************************************
 * 安装时扩展函数
 * Enter description here ...
 */


/**
 * 检测GD库版本
 * Enter description here ...
 */
function gdversion()
{
	//没启用php.ini函数的情况下如果有GD默认视作2.0以上版本
	if (! function_exists ( 'phpinfo' ))
	{
		if (function_exists ( 'imagecreate' ))
			return '2.0';
		else
			return 0;
	} else
	{
		ob_start ();
		phpinfo ( 8 );
		$module_info = ob_get_contents ();
		ob_end_clean ();
		if (preg_match ( "/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info, $matches ))
		{
			$gdversion_h = $matches [1];  
		}else {  
			$gdversion_h = 0; 
		}
    	return $gdversion_h;
  }
}

/**
 * 检测文件夹目录是否可写
 * Enter description here ...
 * @param unknown_type $d
 */
function TestWrite($d)
{
	$tfile = '_wkt.txt';
	$d = preg_replace ( "#\/$#", '', $d );
	
	$fp = @fopen ( $d . '/' . $tfile, 'w' );
	if (! $fp)
		return false;
	else
	{
		fclose ( $fp );
		$rs = @unlink ( $d . '/' . $tfile );
		if ($rs)
			return true;
		else
			return false;
	}
}


