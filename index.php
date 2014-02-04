<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/core/index.php';
$pm = new packman();
$base_packs = Array(
		'base.theme'=>Array('mode'=>'front'),
		'base.twitterbootstrap',
		'css3.mmb');

$pm->load_packs($base_packs);
		
$res  = $pm->search_pack('base.html');
$res[0]->exe();

//print_r($pm->_PACKAGES);
?>