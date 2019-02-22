<?php
/**
 * 后台管理登陆管理
 * Enter description here ...
 * @author Administrator
 *
 */
class LoginAction extends CommonAction
{
	/**
	 * 会员登陆
	 * Enter description here ...
	 */
	public function index()
	{
		//登录处理
		if($_POST)
		{
			//print_r($_POST);
			$user 	= $_POST['username'];
			$pwd 	= $_POST['password'];
			$verify = $_POST['verify'];
			if(md5(strtoupper($verify)) == $_SESSION['verify'])
			{
				$this->login($user, $pwd);
			}else
			{
				$this->error('验证码输入错误！');
			}
			exit;
		}
		$this->display();
	}

	/**
	 * 会员退出
	 * Enter description here ...
	 */
	public function logout()
	{
		session('username',null);
		session('left_menu', null);
		redirect(__GROUP__.'/Login',0);
	}

	/**
	 * 登录函数
	 * Enter description here ...
	 * @param unknown_type $user 用户名
	 * @param unknown_type $pwd 密码
	 */
	private function login($user, $pwd)
	{
		$user_info = M('User')->where(array('username'=>$user))->find();
		if($user_info != '')
		{
			if($user_info['password'] === $pwd)
			{
				//检测用户登录正确，设置登录状态
				session('username',$user_info['username']);
				session('user_id',$user_info['id']);
				session('left_menu','Public:menu');
				$this->log('用户登录');
				redirect(__GROUP__.'/Index',0);
			}else {
				//密码错误
				$this->error('您输入的密码不正确，请重新输入。', __GROUP__.'/Login');
			}
		}else
		{
			//没有该管理员
			$this->error('您输入的账号不正确，请重新输入。', __GROUP__.'/Login');
		}
	}

	/**
	 * 验证码图片
	 * Enter description here ...
	 */
	Public function verify()
	{
	    import('ORG.Util.Image');
	    Image::buildImageVerify(4,2,'png',50,30);
	}
}