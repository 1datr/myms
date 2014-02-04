<?php 
class package
{
	VAR $params;
	VAR $packman;
	VAR $packidx;
	function  __construct(&$pm,$idx,$params=NULL)
	{
		$this->packman = $pm;		
		$this->params = $params; 
		$this->packidx = $idx;
		//$this->load_req_packs();
		$this->OnConstruct();
	}	
	
	function load_req_packs()
	{
		$reqfile = $_SERVER['DOCUMENT_ROOT']."/packs/".$this->packname()."/req.php";
		
		$req = Array();
		if(file_exists($reqfile))
			include $reqfile;			

		foreach($req as $idx => $p)
		{
			if(is_int($idx))
			{
				$arr = $this->packman->search_pack($p);
				if(count($arr)==0)
					$this->packman->addpack($p);
			}
			else
			{
				$this->packman->addpack($idx,$p);
			}
			
		}
	}
	
	static function req_packs()
	{
		return Array();
	}
	
	function event($evname,$params=NULL)
	{
		$this->packman->send_mess($this->packname(),$evname,$params);
		
	}
	
	function mess($evsender,$evname,$params)
	{
		
		$evsender = package::classname($evsender);		
		//echo $evsender;
		$methname = $evsender."_".$evname;

		if(method_exists($this, $methname))
			$this->$methname($params);
			
		
	}
	
	function packname($pack=NULL)
	{
		if($pack==NULL)
			return strtr(get_class($this),"_",".");
		else 
			return strtr($p,"_",".");
	}
	
	static function classname($pack)
	{
		
		return strtr($pack,".","_");
	}
	
	function OnConstruct()
	{
		
	}
	
	function arg($argname)
	{
		if(empty($this->params['args'][$argname])) return null;
		return $this->params['args'][$argname];
	}
	
	function conf($paramname)
	{
		if(empty($this->params['conf'][$paramname])) return null;
		return $this->params['conf'][$paramname];
	}
}
?>