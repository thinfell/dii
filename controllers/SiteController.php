<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class SiteController
{	
    public function actionIndex()
    {
		global $_G;
		$modelName = Dii::useModel();
		define('CURSCRIPT', $modelName);
		require(__DIR__ . '/../models/'.$modelName.'.php');
		$model = new $modelName();
		
		$template = Dii::template();
		
		include Dii::view('common:header');
		include Dii::view($template);
		include Dii::view('common:footer');
        return true;
    }
}
