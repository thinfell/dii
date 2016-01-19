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
