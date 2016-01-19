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