<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class UserLogin
{
	public function metaName()
    {
        return [
            'title' => '登录 - hello dii',
            'keywords' => '登录,hello dii',
            'description' => '登录 hello dii',
        ];
    }
	
	public function rules()
    {
		//验证提交数据
        return true;
    }
	
	public function login()
	{
		global $_G;
		
		if($this->rules() === false)return false;
		
		//极验验证码判断
		require_once GEETEST. 'lib/class.geetestlib.php';
		session_start();
		$GtSdk = new GeetestLib();
		if ($_SESSION['gtserver'] == 1) {
			$result = $GtSdk->validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
			if ($result == TRUE) {
				//验证通过
			} else if ($result == FALSE) {
				return '-2';
			} else {
				return '-2';
			}
		}else{
			if ($GtSdk->get_answer($_POST['geetest_validate'])) {
				//验证通过
			}else{
				return '-2';
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
			return '-1';
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