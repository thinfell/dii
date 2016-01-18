<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class SiteIndex
{
	public function metaName()
    {
        return [
            'title' => '首页 - hello dii',
            'keywords' => '首页,hello dii',
            'description' => '首页 hello dii',
        ];
    }
}