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
		
        return true;
    }
	
	public function login()
	{
		global $_G;
		
		$validate_error =array();
		//数据验证
		$validate_error_rules = $this->rules();
		if($validate_error_rules !== true)return $validate_error_rules;
		
		require_once libfile('function/member');				

		$input_email = $_POST['email'];
		$input_password = $_POST['password'];
		$input_rememberme = $_POST['rememberme'];
		
		if(!($_G['member_loginperm'] = logincheck($input_email))) {
			$validate_error['password'] = '密码错误次数过多，请 15 分钟后重新登录';
			return $validate_error;
		}
		
		$result = userlogin($input_email, $input_password, 0, 0, 'email', $_G['clientip']);

		if($result['status'] <= 0) {
			
			$password = preg_replace("/^(.{".round(strlen($input_password) / 4)."})(.+?)(.{".round(strlen($input_password) / 6)."})$/s", "\\1***\\3", $input_password);
			$errorlog = dhtmlspecialchars(
				TIMESTAMP."\t".
				($result['ucresult']['username'] ? $result['ucresult']['username'] : $input_email)."\t".
				$password."\t".
				"Ques #".intval($_GET['questionid'])."\t".
				$_G['clientip']);
			writelog('illegallog', $errorlog);
			loginfailed($input_email);
			failedip();
			if($_G['member_loginperm'] > 1) {
				$loginperm = $_G['member_loginperm'] - 1;
				$validate_error['password'] = '密码错误，您还可以尝试 '.$loginperm.' 次';
				return $validate_error;
			} elseif($_G['member_loginperm'] == -1) {
				$validate_error['password'] = '抱歉，您输入的密码有误';
				return $validate_error;
			} else {
				$validate_error['password'] = '密码错误次数过多，请 15 分钟后重新登录';
				return $validate_error;
			}
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