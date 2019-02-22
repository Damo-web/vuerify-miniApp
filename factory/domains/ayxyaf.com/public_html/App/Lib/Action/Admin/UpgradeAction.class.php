<?php
/**
 * 后台管理登陆管理
 * Enter description here ...
 * @author Administrator
 *
 */
class UpgradeAction extends CommonAction
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 自动升级
	 * Enter description here ...
	 */
	function auto()
	{
		if($this->config('switch_upgrade') == 1)
		{
			$file_upgrade = 'upgrade.zip';
			//执行升级操作
			if(isset($_REQUEST['t']) && $_REQUEST['t'] > 10)
			{
				$time = $_REQUEST['t'];
			}else 
			{
				$time = 120;
			}
			$version = $this->config('version');
			$upgrade_version = C('UPGRADE_SERVER').'upgrade.php?v='.$version;
			$fp = fopen($upgrade_version, "r");
			
			$upgrade_url = fread($fp, 1204);
			//下载最新的更新
			down_file($upgrade_url, $file_upgrade, $time);
			
			//释放更新文件
			import('ORG.Util.PclZip');
			$zip = new PclZip ( $file_upgrade );
			$zip->extract ( PCLZIP_OPT_PATH, ROOT );
			@unlink ( $file_upgrade );
			
			//执行sql更新
			$sql_upgrade = ROOT.'/upgrade.sql';
			if(is_file($sql_upgrade))
			{
				$fp = fopen($sql_upgrade,"r");
				$sql = fread($fp,filesize($sql_upgrade));
				fclose($fp);
				$Model = new Model();
				$Model->execute($sql);
				@unlink($sql_upgrade);
			}
		}else
		{
			die('0');//没有开启自动升级
		}
	}
}