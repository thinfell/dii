<?php

/**
 *      [Dii] (C)2016-2099 尹兴飞.
 *      This is NOT a freeware, Code released under the MIT License.
 *
 *      @author thinfell <thinfell@qq.com>
 */

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
		if(empty($_POST['password'])){
			$validate_error['password'] = '密码不能为空';
			return $validate_error;
		}
		if(strlen($_POST['password']) < 6){
			$validate_error['password'] = '至少填写 6 个字符';
			return $validate_error;
		}
		if($_POST['password'] != addslashes($_POST['password'])){
			$validate_error['password'] = '抱歉，密码包含非法字符';
			return $validate_error;
		}
		if(empty($_POST['password_repeat'])){
			$validate_error['password_repeat'] = '请确认密码';
			return $validate_error;
		}
		if($_POST['password'] !== $_POST['password_repeat']){
			$validate_error['password_repeat'] = '两次输入的密码不一致';
			return $validate_error;
		}
		
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
		
		if(!$_POST['agreebbrule']){
			$validate_error['agreebbrule'] = '您必须同意服务条款后才能注册';
			return $validate_error;
		}
		//**end
		
        return true;
    }
	
	public function register()
	{
		global $_G;
		
		$validate_error =array();
		//数据验证
		$validate_error_rules = $this->rules();
		if($validate_error_rules !== true)return $validate_error_rules;
		
		$input_email = $_POST['email'];
		$input_password = $_POST['password'];
		$rand = rand(100,999);
		$newusername = 'u_'.$_G['timestamp'].$rand;
		//*注册数据提交
		
		loaducenter();

		$uid = uc_user_register(addslashes($newusername), $input_password, $input_email);
		if($uid <= 0) {
			if($uid == -4) {
				$validate_error['email'] = 'Email 地址无效';
				return $validate_error;
			} elseif($uid == -5) {
				$validate_error['email'] = 'Email 包含不可使用的邮箱域名';
				return $validate_error;
			} elseif($uid == -6) {
				$validate_error['email'] = '该 Email 地址已经被注册';
				return $validate_error;
			}elseif($uid == -1){
				$rand = rand(100,999);
				$newusername = 'u_'.$_G['timestamp'].$rand;
				$uid = uc_user_register(addslashes($newusername), $input_password, $input_email); 
				do {
					$rand = rand(100,999);
					$newusername = 'u_'.$_G['timestamp'].$rand;
					$uid = uc_user_register(addslashes($newusername), $input_password, $input_email); 
				} while ($uid == -1);
			}else{
				$validate_error['email'] = '未知错误';
				return $validate_error;
			}
		}

		loadcache('fields_register');
		$init_arr = explode(',', $_G['setting']['initcredits']);
		$password = md5(random(10));
		C::t('common_member')->insert($uid, $newusername, $password, $input_email, 'Manual Acting', 10, $init_arr, 0);
		
		//直接登录
		require_once libfile('function/member');
		$result = userlogin($input_email, $input_password, 0, 0, 'email', $_G['clientip']);
		setloginstatus($result['member'], 0);//是否记住密码,自动登录
		C::t('common_member_status')->update($_G['uid'], array('lastip' => $_G['clientip'], 'port' => $_G['remoteport'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
		$ucsynlogin = $this->setting['allowsynlogin'] ? uc_user_synlogin($_G['uid']) : '';//是否Ucenter同步登录
		
		return true;		
	}
}