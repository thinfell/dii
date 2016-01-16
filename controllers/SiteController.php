<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class SiteController
{	
    public function actionIndex()
    {
		$description = '1';
		$keywords = '2';
		$title = '3';
		$template = Dii::template();
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
}
