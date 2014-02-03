<?php 
/* Package manager */ 
class packman {
	
	VAR $_PACKAGES;
	VAR $_PACK_COUNTS;
	
	function __construct()
	{
		$_PACKAGES = Array();
		$_PACK_COUNTS = Array();
	}
	// load package 
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
		// include package dependencies
		if(!empty($conf['reqpacks']))
		{
			foreach($conf['reqpacks'] as $packidx => $reqpack)
			{
				if(is_int($packidx))
				{
					if($this->get_pack_count($reqpack)==0)
						$this->addpack($reqpack);
				}
				elseif(is_string($packidx))
				{
					$this->addpack($packidx,$reqpack);
				}
			}
		}
		
		$pack_class_name = strtr($packname,".","_");
		$pack = new $pack_class_name(&$this,$conf);
		return $pack;
	}
	
	// Send message to all packages
	function send_mess($evsender,$evname,$params)
	{
		foreach($_PACKAGES as $idx => $P)
		{
			$_PACKAGES[$idx]->mess($evsender,$evname,$params);
			
		}
		
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
		
		if($packaparams==NULL)
		{
			$this->_PACKAGES[$pack."_".($this->get_pack_count($pack)+1)] = $obj;
			$this->_PACKAGES[$pack."_".($this->get_pack_count($pack)+1)]->packidx = $pack."_".($this->get_pack_count($pack)+1);
		}
		else
		{
			$this->_PACKAGES[$packaparams] = $obj;
			$this->_PACKAGES[$packaparams]->packidx = $packaparams;
		}
			
		if(!empty($this->_PACK_COUNTS[$pack]))
			$this->_PACK_COUNTS[$pack]++;
		else 
			$this->_PACK_COUNTS[$pack]=1;
							
	}
	// search packages in buffer
	function search_pack($ptrn)
	{
		if($ptrn[0]=='#')
		{
			$ptrn = substr($pname,1,strlen($ptrn)-1);
			$result = Array();
			foreach ($this->_PACKAGES as $pname => $p)
			{
				if($pname==$ptrn)
					$result[]=$p;
			}
			return $result;
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