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
		
		$modelName = Dii::useModel();
		define('CURSCRIPT', $modelName);
		require(__DIR__ . '/../models/'.$modelName.'.php');
		$model = new $modelName();

		$template = Dii::template();
		$submit = Dii::submit();

		if(submitcheck($submit,1)) {
			//进行数据处理
			return false;
		}
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
	
	public function actionRegister()
    {
		//极验验证码配置
		define("GEETEST","../extensions/gt-php-sdk-master/");
		
		$title = '注册 - hello dii';
		$keywords = '注册,hello dii';
		$description = '注册 hello dii';
		$template = Dii::template();
		$submit = Dii::submit();
		if(submitcheck($submit,1)) {
			//进行数据处理
			return false;
		}
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
}
