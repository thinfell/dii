<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class UserRegister
{
	public function metaName()
    {
        return [
            'title' => '注册 - hello dii',
            'keywords' => '注册,hello dii',
            'description' => '注册 hello dii',
        ];
    }
	
	public function rules()
    {
		//验证提交数据
		$validate_error =array();
		if(empty($_POST['email'])){
			$validate_error['email'] = '邮箱不能为空';
			return $validate_error;
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$validate_error['email'] = '邮箱格式不正确';
			return $validate_error;
		}
        return true;
    }
	
	public function register()
	{
		global $_G;
		
		//数据验证
		if($this->rules() !== true)return $this->rules();
		$validate_error =array();
		
		//极验验证码判断
		require_once GEETEST. 'lib/class.geetestlib.php';
		session_start();
		$GtSdk = new GeetestLib();
		if ($_SESSION['gtserver'] == 1) {
			$result = $GtSdk->validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
			if ($result == TRUE) {
				//验证通过
			}  else {
				$validate_error['captcha'] = '滑动验证失败, 请重新验证';
				return $validate_error;
			}
		}else{
			if ($GtSdk->get_answer($_POST['geetest_validate'])) {
				//验证通过
			}else{
				$validate_error['captcha'] = '滑动验证失败, 请重新验证';
				return $validate_error;
			}
		}
		//**end
		
		require_once libfile('function/member');				

		$input_email = $_POST['email'];
		$input_password = $_POST['password'];
		$input_rememberme = $_POST['rememberme'];
		
		$result = userlogin($input_email, $input_password, 0, 0, 'email', $_G['clientip']);

		if($result['status'] <= 0) {
			loginfailed($input_email);
			failedip();
			$validate_error['password'] = '邮箱与密码不匹配';
			return $validate_error;
		}else{
			setloginstatus($result['member'], $_GET['rememberme'] ? 2592000 : 0);//是否记住密码,自动登录
			if($_G['member']['lastip'] && $_G['member']['lastvisit']) {
				dsetcookie('lip', $_G['member']['lastip'].','.$_G['member']['lastvisit']);
			}
			C::t('common_member_status')->update($_G['uid'], array('lastip' => $_G['clientip'], 'port' => $_G['remoteport'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
			$ucsynlogin = $this->setting['allowsynlogin'] ? uc_user_synlogin($_G['uid']) : '';//是否Ucenter同步登录
			return true;
		}
	}
}