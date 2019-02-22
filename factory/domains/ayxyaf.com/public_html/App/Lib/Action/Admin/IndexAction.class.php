<?php
/**
 * 后台管理框架首页
 * @author Administrator
 *
 */
class IndexAction extends BaseAction {

	public function __construct()
	{
		parent::__construct("Index", 'Config');
	}

    /**
     * 后台主框架
     */
	public function index()
	{
		
        $web_title   = C('WEB_TITLE');
        $web_version = C('WEB_VERSION');        
        $template    = __GROUP__."/Index/status";
        $user_id= $_SESSION['user_id'];

        $this->assign('title',$web_title);
		$this->assign('version',$web_version);
        $this->assign('template', $template);
        $this->assign('user_id', $user_id);
    	$this->display();
    }

    /**
     * 系统状态
     */
    public function status()
    {
        $rand = rand(0, 10);
        $_SESSION['codec'] = $rand;
    	$result = $this->_model->select();
    	foreach($result as $key=>$value)
    	{
    		$config[$value[key]] = $value[value];
    	}
    	$config['web_ip'] = get_client_ip();
    	$this->assign('config', $config);
	    $this->assign('codec', $_SESSION['codec']);
    	
    	$log=M('log');
    	$logs=$log->order('time desc')->limit('10')->select();
    	$this->assign('log',$logs);

    	$total['article'] 	= D("Article")->where('`pid` not in(0,6)')->count();
    	$total['jobs']		= D("Jobs")->count();
    	$total['order']		= D("Order")->count();
    	$total['apply']		= D("Apply")->count();
    	$total['goods']		= D("Goods")->count();
    	$total['message']	= D("Message")->count();
    	$this->assign('total', $total);
    	
        // 判断是否绑定QFTouch
        if (C('API_STATUS') == 'ok') {
            $qt = array('name' => 'QFTouch', 'id' => C('API_ID'));
            $this->assign('qt',$qt);
        }

    	$this->display();
    }    

    /**
     * 二维码生成
     * @return image 二维码
     */
    public function qrcode(){
        if (!isset($_GET['code']) || ($_GET['code'] != $_SESSION['codec'])) {
            header("location:_empty");
        }
        unset($_SESSION['codec']);

        Vendor('phpqrcode.qrlib');
        $data=trim($_GET['data']);
        $level='H';
        $size=trim($_GET['size'])?trim($_GET['size']):4;
        QRcode::png($data,false,$level,$size);
    }

    public function _empty(){
            $this->_404();
    }

}