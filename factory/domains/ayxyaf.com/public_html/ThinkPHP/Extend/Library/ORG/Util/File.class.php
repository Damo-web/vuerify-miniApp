<?php
/**
 * 文件操作类
 * Enter description here ...
 * @author Administrator
 *
 */
class File
{
	/**
	 * 建立文件夹
	 *
	 * @param string $aimUrl
	 * @return viod
	 */
	function createDir($aimUrl)
	{
		$aimUrl = str_replace ( '', '/', $aimUrl );
		$aimDir = '';
		$arr = explode ( '/', $aimUrl );
		foreach ( $arr as $str )
		{
			$aimDir .= $str . '/';
			if (! file_exists ( $aimDir ))
			{
				mkdir ( $aimDir );
			}
		}
	}
	/**
	 * 建立文件
	 *
	 * @param string $aimUrl 
	 * @param boolean $overWrite 该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function createFile($aimUrl, $overWrite = false)
	{
		if (file_exists ( $aimUrl ) && $overWrite == false)
		{
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true)
		{
			File::unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		File::createDir ( $aimDir );
		touch ( $aimUrl );
		return true;
	}
	
	/**
	 * 移动文件夹
	 *
	 * @param string $oldDir
	 * @param string $aimDir
	 * @param boolean $overWrite 该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function moveDir($oldDir, $aimDir, $overWrite = false)
	{
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir ))
		{
			return false;
		}
		if (! file_exists ( $aimDir ))
		{
			File::createDir ( $aimDir );
		}
		@$dirHandle = opendir ( $oldDir );
		if (! $dirHandle)
		{
			return false;
		}
		while ( false !== ($file = readdir ( $dirHandle )) )
		{
			if ($file == '.' || $file == '..')
			{
				continue;
			}
			if (! is_dir ( $oldDir . $file ))
			{
				File::moveFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else
			{
				File::moveDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $oldDir );
	}
	/**
	 * 移动文件
	 *
	 * @param string $fileUrl
	 * @param string $aimUrl
	 * @param boolean $overWrite 该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function moveFile($fileUrl, $aimUrl, $overWrite = false)
	{
		if (! file_exists ( $fileUrl ))
		{
			return false;
		}
		if (file_exists ( $aimUrl ) && $overWrite = false)
		{
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite = true)
		{
			File::unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		File::createDir ( $aimDir );
		rename ( $fileUrl, $aimUrl );
		return true;
	}
	/**
	 * 删除文件夹
	 *
	 * @param string $aimDir
	 * @return boolean
	 */
	function unlinkDir($aimDir)
	{
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		if (! is_dir ( $aimDir ))
		{
			return false;
		}
		$dirHandle = opendir ( $aimDir );
		while ( false !== ($file = readdir ( $dirHandle )) )
		{
			if ($file == '.' || $file == '..')
			{
				continue;
			}
			if (! is_dir ( $aimDir . $file ))
			{
				File::unlinkFile ( $aimDir . $file );
			} else
			{
				File::unlinkDir ( $aimDir . $file );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $aimDir );
	}
	/**
	 * 删除文件
	 *
	 * @param string $aimUrl
	 * @return boolean
	 */
	function unlinkFile($aimUrl)
	{
		if (file_exists ( $aimUrl ))
		{
			unlink ( $aimUrl );
			return true;
		} else
		{
			return false;
		}
	}
	/**
	 * 复制文件夹
	 *
	 * @param string $oldDir
	 * @param string $aimDir
	 * @param boolean $overWrite 该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function copyDir($oldDir, $aimDir, $overWrite = false)
	{
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir ))
		{
			return false;
		}
		if (! file_exists ( $aimDir ))
		{
			File::createDir ( $aimDir );
		}
		$dirHandle = opendir ( $oldDir );
		while ( false !== ($file = readdir ( $dirHandle )) )
		{
			if ($file == '.' || $file == '..')
			{
				continue;
			}
			if (! is_dir ( $oldDir . $file ))
			{
				File::copyFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else
			{
				File::copyDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		return closedir ( $dirHandle );
	}
	/**
	 * 复制文件
	 *
	 * @param string $fileUrl
	 * @param string $aimUrl
	 * @param boolean $overWrite 该参数控制是否覆盖原文件
	 * @return boolean
	 */
	function copyFile($fileUrl, $aimUrl, $overWrite = false)
	{
		if (! file_exists ( $fileUrl ))
		{
			return false;
		}
		if (file_exists ( $aimUrl ) && $overWrite == false)
		{
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true)
		{
			File::unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		File::createDir ( $aimDir );
		copy ( $fileUrl, $aimUrl );
		return true;
	}
	
	/**
	 * 显示目录下所有的文件
	 * Enter description here ...
	 * @param unknown_type $dir 目录名称
	 * @param unknown_type $recursion 是否递归查询其子目录
	 * @return array  返回的数据类型
	 */
	function listDir($dir, $recursion = false)
	{
		if (is_dir ( $dir ))
		{
			$dh = opendir ( $dir );
			if ($dh)
			{
				while ( ($file = readdir ( $dh )) !== false )
				{
					if ((is_dir ( $dir . "/" . $file )) && $file != "." && $file != "..")
					{
						//echo "<b><font color='red'>文件名：</font></b>", $file, "<br><hr>";
						$result[$file] = $dir.$file;
						if($recursion)
						{
							$this->listDir ( $dir . "/" . $file . "/",  $recursion);
						}
					} else
					{
						if ($file != "." && $file != "..")
						{
							//echo $file . "<br>";
							$result[$file] = $dir.$file;
						}
					}
				}
				closedir ( $dh );
			}
			return $result;
		}
		return false;
	}
	
	/**
	 * 写配置文件
	 * Enter description here ...
	 * @param unknown_type $file
	 * @param unknown_type $ini
	 * @param unknown_type $value
	 * @param unknown_type $type
	 */
	function writeConfig($file, $ini, $value)
	{
		$config = include($file);
		$config[$ini] = $value;
		$result  = "<?php \r\n";
		$result .= "return ";
		$result .= var_export($config, TRUE);
		$result .= ";\r\n?>\r\n";
		file_put_contents ( $file, $result);
	}
}
?> 