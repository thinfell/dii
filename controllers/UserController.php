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

class UserController
{	
    public function actionLogin()
    {
		global $_G;
		if($_G['uid']){
			dheader('location: index.php?r=site/index');
		}
		//极验验证码配置
		define("GEETEST","../extensions/gt-php-sdk-master/");
		
		$modelName = Dii::useModel();
		define('CURSCRIPT', $modelName);
		require(__DIR__ . '/../models/'.$modelName.'.php');
		$model = new $modelName();

		$template = Dii::template();
		$submit = Dii::submit();

		if(submitcheck($submit,1)) {
			$result = $model->login();
			if($result === true){
				//登陆成功
				dheader('location: ' . dreferer());
				return true;
			}
		}
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
	
	public function actionRegister()
    {
		global $_G;
		if($_G['uid']){
			dheader('location: index.php?r=site/index');
		}
		//极验验证码配置
		define("GEETEST","../extensions/gt-php-sdk-master/");
		
		$modelName = Dii::useModel();
		define('CURSCRIPT', $modelName);
		require(__DIR__ . '/../models/'.$modelName.'.php');
		$model = new $modelName();

		$template = Dii::template();
		$submit = Dii::submit();

		if(submitcheck($submit,1)) {
			$result = $model->register();
			if($result === true){
				//注册成功
				dheader('location: ' . dreferer());
				return true;
			}
		}
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
	
	public function actionLogout()
    {
		global $_G;
		if(!$_G['uid']){
			dheader('location: index.php?r=site/index');
		}
		if($_GET['formhash'] != $_G['formhash']) {
			exit('请求来路不明');
		}else{
			global $_G;
			require_once libfile('function/member');
			$ucsynlogout = $this->setting['allowsynlogin'] ? uc_user_synlogout() : '';

			clearcookies();
			$_G['groupid'] = $_G['member']['groupid'] = 7;
			$_G['uid'] = $_G['member']['uid'] = 0;
			$_G['username'] = $_G['member']['username'] = $_G['member']['password'] = '';
			$_G['setting']['styleid'] = $this->setting['styleid'];

			//退出登录成功
			dheader('location: ' . dreferer());
		}
		return true;
    }
}
