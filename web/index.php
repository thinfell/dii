<?php

//*加载Discuz
require(__DIR__ . '/../../source/class/class_core.php');

//*运行Dii
require(__DIR__ . '/../class/dii_base.php');
$dii = new Dii();
$dii->run();
