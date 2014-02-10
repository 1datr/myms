<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/core/index.php';
$pm = new packman();
if(!$pm->load("admin"))
{
	$base_packs = Array(
			'base.theme'=>Array('mode'=>'admin'),
			'base.twitterbootstrap',
			'css3.mmb');
	
	$pm->load_packs($base_packs);

	$pm->serialize("admin");
}
		
$res  = $pm->search_pack('base.html');
$res[0]->exe();

?>