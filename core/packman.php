<?php 
/* Package manager */ 
class packman {
	
	VAR $_PACKAGES;
	VAR $_PACK_COUNTS;
	var $_PACK_FILES_LIST;
	
	function __construct()
	{
		$this->_PACKAGES = Array();
		$this->_PACK_COUNTS = Array();
		$this->_PACK_FILES_LIST = Array();
	}
	// add file to list of including scripts
	function add_pack_file($pfile)
	{
		if(!in_array($pfile, $this->_PACK_FILES_LIST))  
			$this->_PACK_FILES_LIST[]=$pfile;
	}
	// include all files required to work script
	function req_dependencies($packname)
	{
		if(class_exists(package::classname($packname))) return;
			
		$req = Array();
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/packs/$packname/req.php"))
		{
			include $_SERVER['DOCUMENT_ROOT']."/packs/$packname/req.php";
		}
		else return;
		foreach($req as $r)
		{
			$this->add_pack_file($r);
			require_once $_SERVER['DOCUMENT_ROOT']."/packs/$r/index.php";
			$this->req_dependencies($r);
		}
	}
	// load package 
	function load_pack($packname,$idx,$args=NULL)
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
		// require package classes dependencies
		$this->req_dependencies($packname);
		
		$pack_class_name = strtr($packname,".","_");
		$pack = new $pack_class_name(&$this,$idx,Array('conf'=>$conf,'args'=>$args));
		return $pack;
	}
	
	// Send message to all packages
	function send_mess($evsender,$evname,$params)
	{
		foreach($this->_PACKAGES as $idx => $P)
		{
			//echo $idx;			
			$this->_PACKAGES[$idx]->mess($evsender,$evname,$params);
			
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
		//		
		if($packaparams==NULL)
		{
			$obj = $this->load_pack($pack,$pack."_".($this->get_pack_count($pack)+1));
			$this->_PACKAGES[$pack."_".($this->get_pack_count($pack)+1)] = $obj;
			
			$this->_PACKAGES[$pack."_".($this->get_pack_count($pack)+1)]->load_req_packs();
			$this->_PACKAGES[$pack."_".($this->get_pack_count($pack)+1)]->OnConstruct();
		}
		else
		{
			$packidx = $pack."_".($this->get_pack_count($pack)+1);
			if(is_array($packaparams))	// if array
			{
				if(!empty($packaparams['name']))
					$packidx = $packaparams['name'];	// if name called
				unset($packaparams['name']);
			}
			
			$obj = $this->load_pack($pack,$packidx,$packaparams);
			$this->_PACKAGES[$packidx] = $obj;
			
			$this->_PACKAGES[$packidx]->load_req_packs();
			$this->_PACKAGES[$packidx]->OnConstruct();
		}
		// 
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
	
	function load_packs($packlist)
	{
		foreach($packlist as $idx => $p)
		{
			if(is_int($idx))
				$this->addpack($p);
			elseif(is_string($idx))
				$this->addpack($idx,$p);
			
		}
	}
	
	function serialize($filename)
	{
		$filename = $_SERVER['DOCUMENT_ROOT']."/ser/$filename";
		
		$files = get_included_files();
		/*foreach($files as $idx => $reqfile)
		{
			if(!preg_match(".+/packs/.+/index.php/Uis", $reqfile))
			{
				unset($files[$idx]);
			}
		}	*/	
		$code = "<?php 
				\$reqs = unserialize('".serialize($files)."');
				foreach(\$reqs as \$r) require_once \$r;
				\$this->_PACKAGES = unserialize('".serialize($this->_PACKAGES)."');
				\$this->_PACK_COUNTS  = unserialize('".serialize($this->_PACK_COUNTS)."');
				?>"; 
		file_put_contents($filename, $code);
	}
	
	function load($filename)
	{
		$filename = $_SERVER['DOCUMENT_ROOT']."/ser/$filename";
		if(!file_exists($filename)) return false;
		include $filename;
		
		return true;
	}
}
?>