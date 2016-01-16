<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class UserController
{	
    public function actionLogin()
    {
		$title = '登录 - hello dii';
		$keywords = '登录,hello dii';
		$description = '登录 hello dii';
		$template = Dii::template();
		include Dii::view($template);
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
