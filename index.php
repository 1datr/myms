<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/core/index.php';
$pm = new packman();
$pm->addpack('base.theme',Array('mode'=>'front'));
$res  = $pm->search_pack('base.html');
$res[0]->exe();

//print_r($pm->_PACKAGES);
?>