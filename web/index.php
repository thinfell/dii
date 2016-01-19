<?php

/**
 *      [Dii] (C)2016-2099 尹兴飞.
 *      This is NOT a freeware, Code released under the MIT License.
 *
 *      @author thinfell <thinfell@qq.com>
 */

//*加载Discuz
require(__DIR__ . '/../../source/class/class_core.php');

//*运行Dii
require(__DIR__ . '/../class/dii_base.php');
$dii = new Dii();
$dii->run();
