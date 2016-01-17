<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class UserController
{	
    public function actionLogin()
    {
		//极验验证码配置
		define("GEETEST","../extensions/gt-php-sdk-master/");
		
		$title = '登录 - hello dii';
		$keywords = '登录,hello dii';
		$description = '登录 hello dii';
		$template = Dii::template();
		$submit = Dii::submit();
		if(submitcheck($submit,1)) {
			echo '1';
		}else{
			echo '2';
		}
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
	
	public function actionRegister()
    {
		$title = '注册 - hello dii';
		$keywords = '注册,hello dii';
		$description = '注册 hello dii';
		$template = Dii::template();
		include Dii::view($template);
        return true;
    }
}
