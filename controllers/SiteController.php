<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class SiteController
{	
    public function actionIndex()
    {
		$title = 'hello dii';
		$keywords = 'hello dii';
		$description = 'hello dii';
		$template = Dii::template();
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
}
