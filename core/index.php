<?php 
/*
 * 
 * 			PACKAGE MANAGEMENT CORE FILE
 * 
 * */
require_once $_SERVER['DOCUMENT_ROOT'].'/core/package.php';

/* load the package */ 
class packman {
	
	VAR $_PACKAGES;
	VAR $_PACK_COUNTS;
	
	function __construct()
	{
		$_PACKAGES = Array();
		$_PACK_COUNTS = Array();
	}

	function load_pack($packname)
	{
		// require package file
		if(!file_exists($_SERVER['DOCUMENT_ROOT']."/packs/$packname/index.php"))
			return;
		require_once $_SERVER['DOCUMENT_ROOT']."/packs/$packname/index.php";
		$conf = Array();
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/packs/$packname/conf.php"))
		{
			require_once $_SERVER['DOCUMENT_ROOT']."/packs/$packname/conf.php";
		}
		$pack_class_name = strtr($packname,".","_");
		$pack = new $pack_class_name($conf);
		return $pack;
	}
	
	function get_pack_count($pack)
	{		
		if(empty($this->_PACK_COUNTS[$pack])) 
			return  0;
		return $this->_PACK_COUNTS[$pack];
	}
	
	/* Add new package to buffer */
	function addpack($pack,$packaparams=NULL)
	{
		$obj = $this->load_pack($pack);
		$this->_PACKAGES[$pack."_".($this->get_pack_count($pack)+1)] = $obj;
		if(!empty($this->_PACK_COUNTS[$pack]))
			$this->_PACK_COUNTS[$pack]++;
		else 
			$this->_PACK_COUNTS[$pack]=1;
		if($packaparams==NULL)
		{
			
			
		}
		else 
		{
			
		}
	}
	
	function search_pack($ptrn)
	{
		if($ptrn[0]=='#')
		{
			
		}
		else
		{
			$result = Array();
			foreach ($this->_PACKAGES as $pname => $p)
			{
				if(substr($pname,0,strlen($ptrn))==$ptrn)
					$result[]=$p;
			}
			return $result;
		}
	}
}
?>