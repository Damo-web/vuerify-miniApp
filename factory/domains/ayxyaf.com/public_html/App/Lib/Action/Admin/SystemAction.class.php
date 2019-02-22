<?php
/**
 * 系统内容管理
 * Enter description here ...
 * @author Administrator
 *
 */
class SystemAction extends BaseAction {
    function __construct()
    {
    	parent::__construct('System','Config');
    }
    
    /**
     * 系统配置项管理
     * (non-PHPdoc)
     * @see BaseAction::index()
     */
	public function index()
    {
		
    	if($_POST)
    	{   
    		//z($_POST); 		
    		$result = $this->_model->where('`type`="file"')->select();
    		//z($result);
    		//有文件上传操作处理
    		foreach ($result as $key=>$value)
    		{
    			if($_FILES[$value['key']]['name'])
    			{
    				$img_name = $this->UploadFile($_FILES[$value['key']], 0, 1);
    				//z($img_name['0']['savename'], false);
    				$data['value'] = $img_name['0']['savename'];
					$this->_model->create();
	    			$id = $this->_model->where('`key`="'.$value['key'].'"')->save($data);
    			}
    		}
    		
    		$result = $this->_model->where('`type`!="file" and `group_id`!=0')->select();
    		foreach ($result as $key=>$value)
    		{
    			if(array_key_exists($value['key'], $_POST))
    			{
    			
		    		//修改模板配置文件
		    		if($value['key'] == 'current_theme')
		    		{
		    			import('ORG.Util.File');
		    			$file = new File();
		    			$file->writeConfig(ROOT."/App/Conf/Home/config.php", 'DEFAULT_THEME', $_POST[$value['key']]);
		    		}
		    		
	    			$data['value'] = $_POST[$value['key']];
	    			$this->_model->create();
		    		$id = $this->_model->where('`key`="'.$value['key'].'"')->save($data);
    			}
    		}
    		//die();
    		$url = __GROUP__.'/'.$this->_action_name.'/Index/t/'.$_GET['t'];
    		$this->success('更新成功',$url);
    		exit;
    	}
    	
    	
    	$group_id = $_REQUEST['t'];
    	if(!$group_id)
    	{
    		$group_id = 1;
    	}
    	$where = 'group_id = '.$group_id;
    	$data = $this->_model->where($where)->select();
    	//z($data);
    	
    	//特殊处理模板
    	$path='./App/Tpl/Home';
		$dirname=sdir($path);
		foreach($data as $key=>$value)
		{
			if($value['key'] == 'current_theme')
			{
				$data[$key]['type'] = 'select';
				$data[$key]['options'] = implode(',', $dirname);
			}
		}
		
    	//遍历模板目录
    	/*
		$theme=M('config')->where('`key`="current_theme"')->find();
		$this->assign('dirname',$dirname);
		$this->assign('theme',$theme);
    	*/
		
    	foreach($data as $key=>$value)
    	{
    		switch($value['type'])
    		{
    			case 'text':
    				$list[$key]['name']		= $value['name'];
                    $list[$key]['key']     = $value['key'];
    				if($value['options'] == 'number')
    				{
    					$list[$key]['input'] 	= "<input type='number' class='txt' min='1' id='".$value['key']."' name='".$value['key']."' size='35' value='".$value['value']."' />\r\n";
    				}else 
    				{
    					$list[$key]['input'] 	= "<input type='text' class='txt' id='".$value['key']."' name='".$value['key']."' size='35' value='".$value['value']."' />\r\n";
    				}
    				
    				break;
    			case 'textarea':
    				$list[$key]['name']		= $value['name'];
    				$list[$key]['input'] 	= "<textarea name='".$value['key']."' id='".$value['key']."' cols='88' rows='10' class='txt' >".$value['value']."</textarea>\r\n";
    				break;
    			case 'file':
    				$list[$key]['name']		= $value['name'];
    				$list[$key]['input'] 	= "<input type='file' name='".$value['key']."' class='txt'>\r\n";
    				if($value[value] != '')
    				{
    					$list[$key]['input'] .= '<a href="__ROOT__/'.C('UPLOAD_DIR').$value[value].'" target="_black">查看图片</a>';
    				}
    				break;
    			case 'checkbox':
    				$list[$key]['name']		= $value['name'];
    				$arr = explode(',', $value['options']);
    				foreach($arr as $k=>$val)
    				{
    					if($value['value'] == $key)
    					{
    						$list[$key]['input'] 	.= "<label><input type='checkbox' name='checkbox' value='".$key." checked '>$value </label>\r\n";	
    					}else
    					{
    						$list[$key]['input'] 	.= "<label><input type='checkbox' name='checkbox' value='".$key." '>$value </label>\r\n";
    					}
    				}
    				break;
    			case 'select':
    				$list[$key]['name']		= $value['name'];
    				$list[$key]['input'] 	= "<select name='$value[key]' >\r\n";
    				$arr = explode(',', $value['options']);
    				if($value['key'] == 'current_theme') //特殊处理选择模板
    				{
	    				foreach($arr as $k=>$val)
	    				{
	    					if($value['value'] == $val)
	    					{
	    						$list[$key]['input']	.= "<option value='$val' selected >$val</option>\r\n";
	    					}else
	    					{
	    						$list[$key]['input']	.= "<option value='$val'>$val</option>\r\n";
	    					}
	    				}
    				}else
    				{
	    				foreach($arr as $k=>$val)
	    				{
	    					if($value['value'] == $key)
	    					{
	    						$list[$key]['input']	.= "<option value='$k' selected >$val</option>\r\n";
	    					}else
	    					{
	    						$list[$key]['input']	.= "<option value='$k'>$val</option>\r\n";
	    					}
	    				}
    				}
    				$list[$key]['input'] .= "</select>";
    				break;
    			case 'radio':
    				$list[$key]['name']		= $value['name'];
    				$arr = explode(',', $value['options']);
    				foreach($arr as $k=>$val)
    				{
    					if($value['value'] == $k)
    					{
    						$list[$key]['input'] 	.= "<label><input type='radio' name='$value[key]' value='$k' checked > $val</label>\r\n";
    					}else
    					{
    						$list[$key]['input'] 	.= "<label><input type='radio' name='$value[key]' value='$k'> $val</label>\r\n";
    					}
    				}
    				break;
    		}
    	}
		
    	$this->assign('list', $list);
    	$this->assign("group",$group_id);
    	switch ($group_id)
    	{
    		
    		case '3':
    			$this->assign('Xpoint',	$this->config('baidu_map_x'));
    			$this->assign('Ypoint',	$this->config('baidu_map_y'));
    			$this->assign('linkman',$this->config('linkman'));
    			$this->assign('tel',	$this->config('tel'));
    			$this->assign('address',$this->config('address'));
				$this->assign('web_name',$this->config('web_name'));
    			$this->display('baidu_map');
    			break;
    		default:
    			$this->display();
    	}
    }
    
    /**
     * 系统高级管理配置
     * Enter description here ...
     */
    public function advanced()
    {
    	//上传模板和数据库文件
    	if($_FILES)
    	{
    		//上传图片类
    		import('ORG.Net.UploadFile');
	    	$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = C('UPLOAD_SIZE');// 设置附件上传大小
			$upload->allowExts  = C('UPLOAD_TYPE');// 设置附件上传类型
			$upload->savePath =  'App/Tpl/Home/';// 设置附件上传目录
			
			$error = 0;
			//zip解压缩
			import('ORG.Util.PclZip');
			
    		if($_FILES['tpl']['size'] != 0)
    		{
	    		$info = $upload->uploadOne($_FILES['tpl']);
				if(!$info) {// 上传错误提示错误信息
					$this->error($upload->getErrorMsg());
				}else{// 上传成功 获取上传文件信息
					$file = ROOT."/".$upload->savePath.$info[0]['savename'];
					$zip = new PclZip ( $file );
					$zip->extract ( PCLZIP_OPT_PATH, ROOT."/".$upload->savePath );
					@unlink ( $file );
				}
    		}else {
    			$error += 1;
    		}
    		if($_FILES['sql']['size'] != 0)
    		{
    			$info = $upload->uploadOne($_FILES['sql']);
				if(!$info) {// 上传错误提示错误信息
					$this->error($upload->getErrorMsg());
				}else{// 上传成功 获取上传文件信息
					
					$file = ROOT."/".$upload->savePath.$info[0]['savename'];
					$zip = new PclZip ( $file );
					$zip->extract ( PCLZIP_OPT_PATH, ROOT."/".$upload->savePath );
					
					import("ORG.Util.File");
					$file = new File;
					
					$tpl_dir = ROOT."/".$upload->savePath; //模板目录
					$list_dir = $file->listDir($tpl_dir);
					foreach($list_dir as $key=>$value)
					{
						$s = substr($key, -3, 3);
						if($s == 'sql')
						{
							$sql_upgrade =  ROOT."/".$upload->savePath.$key;
						}
					}
					if(is_file($sql_upgrade))
					{
						/*
						$fp = fopen($sql_upgrade,"r");
						//$sql = fread($fp,filesize($sql_upgrade));
						while (!feof($fp)) {
						   $buffer = fgets($fp, 4096);
						   if(substr($buffer, 0, 2) != '--')
						   {
								$sql .= $buffer;
						   }
						  
						}
						fclose($fp);
						*/
						$db_lang 	= 'utf8';
						$sql4tmp = "MyISAM DEFAULT CHARSET=".$db_lang;
						$fp = fopen($sql_upgrade,"r");
						
						$_Model = new Model();
						 while(!feof($fp))
						{
							$line = rtrim(fgets($fp,1024));
							if(preg_match("#;$#", $line))
							{
								$query .= $line."\n";
								if($mysqlVersion < 4.1)
								{
									$rs = $_Model->query($query);
								} else {
									if(preg_match('#CREATE#i', $query))
									{
										//z($query, false);
										$rs = $_Model->query(preg_replace("#MyISAM#i",$sql4tmp,$query));
									}
									else
									{
										$rs = $_Model->query($query);
									}
								}
								$query='';
							} else if(!preg_match("#^(\/\/|--)#", $line))
							{
								$query .= $line;
							}
						}
						fclose($fp);
						@unlink($sql_upgrade);
					}
					
					@unlink ( $file );
				}
    		}else {
    			$error += 1;
    		}
    		if($error == '2')
    		{
    			$this->error('请先选择文件');
    		}else 
    		{
    			$this->success('更新成功!');
    		}
    		exit;
    		
    	}
    	$this->display();
    }
    
    /**
     * 网站运行状态
     * Enter description here ...
     */
    public function status()
    {
    	
    }
    /**
     * 更新缓存
     * Enter description here ...
     */
    public function refresh()
    {
    	//$this->clearcache();
    	$this->del_install();
    }
    
    /**
     * 清除缓存操作
     * Enter description here ...
     */
    public function clearcache()
    {
    	import('ORG.Util.File');
    	$temp_dir = dirname(__FILE__).'/../../../'.C('TEMP_DIR');
    	session('left_menu', null);
    	
    	$this->del_install();
    	if(is_dir($temp_dir))
		{
			File::unlinkDir($temp_dir);
			$this->success('清除缓存成功！', __GROUP__."/Index/status");
		}else 
		{
			$this->error('清除缓存失败！');
		}
    }
    
    /**
     * 网站升级
     * Enter description here ...
     */
    public function upgrade()
    {
    	switch ($_REQUEST['t'])
    	{
    		case "view": //查看是否可以智能升级
    			die($this->config('switch_upgrade'));
    			break;
    		case "exec": //手动升级
    			break;
    		case "auto": //自动升级
    	}
    }
    
    /**
     * 清除安装包
     * Enter description here ...
     */
    private function del_install()
    {
    	$file_install 	= ROOT.'/install.php';
    	$dir_install 	= ROOT.'/App/Tpl/Install';
    	$tpl_install	= ROOT.'/App/Lib/Action/Install'; 
    	//z($file_install);
    	if(is_file($file_install))
    	{
    		//z('清除安装包');
    		import("ORG.Util.File");
			$file = new File;
			$file->unlinkFile($file_install);
			$file->unlinkDir($dir_install);
			$file->unlinkDir($tpl_install);
    	}
    }
}