<?php 
$conf  = Array(
		'pagesdir'=>$_SERVER['DOCUMENT_ROOT']."/pages/",
		'defaultdomen'=>'front',
		'urls'=> Array(
				'front'=>Array(
						''=>'main',
						'about'=>Array('page'=>'about','title'=>'About'),
						'news',	
						'users',		
					),	
				'admin'=>Array(
						''=>'main',					
					),
				),
		);
?>