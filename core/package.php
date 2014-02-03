<?php 
class package
{
	VAR $params;
	VAR $packman;
	VAR $packidx;
	function  __construct($pm,$params=NULL)
	{
		$this->packman = $pm;		
		$this->params = $params; 
		$this->OnConstruct();
	}	
	
	function mess($evsender,$evname,$params)
	{
		
		
	}
	
	function OnConstruct()
	{
		
	}
}
?>