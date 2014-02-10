<?php 
class base_page extends package
{
	
	VAR $query;
	VAR $page_title=NULL;
	VAR $currpage;
	VAR $domen = NULL;
	VAR $args;
	// 
	function OnConstruct()
	{
		// detect current page name and arguments
		if($this->domen == NULL)
			$this->domen = $this->conf('defaultdomen');
				
		
		$this->detect_page_and_args();
		
		
		/*
		if(!empty($urls[$this->domen][$this->query]))
		{
			if(is_array($urls[$this->domen][$this->query]))
			{
				$this->currpage = $urls[$this->domen][$this->query]['page'];
				$this->page_title = $urls[$this->domen][$this->query]['title'];
			}
			else 
				$this->currpage = $urls[$this->domen][$this->query];
		}
		else 
		{
			foreach($urls[$this->domen] as $url => $page)
			{
				if(is_array($urls[$this->domen][$this->query]))
				{
					$this->currpage = $urls[$this->domen][$this->query]['page'];
					$this->page_title = $urls[$this->domen][$this->query]['title'];
				}
				else 
					$this->currpage = $page;
				break;	
			}			
		}*/
		// walk all pages and generate page body if empty
		$confs = $this->conf('urls');
		foreach($confs[$this->domen] as $url => $page)
		{
			if(is_int($url))
			{
				if(!file_exists($this->conf("pagesdir").$this->domen."/".$page."/index.php"))
					$this->createpage($page);
			}
			else 
			{
				if(is_array($page))
				{
					if(!file_exists($this->conf("pagesdir").$this->domen."/".$page['page']."/index.php"))
						$this->createpage($page);
				}
				elseif(is_string($page))
				{
					if(!file_exists($this->conf("pagesdir").$this->domen."/".$page."/index.php"))
						$this->createpage($page);
				}
			}
		}
		
		// first start of page		
		if(file_exists($this->conf("pagesdir").$this->domen."/".$this->currpage."/onload.php"))
		{
			include $this->conf("pagesdir").$this->domen."/".$this->currpage."/onload.php";
		}
	}
	// Detect page and page arguments
	function detect_page_and_args()
	{		
		
		$urls = $this->conf('urls');
		$keylist = Array();
		foreach($urls[$this->domen] as $key => $val)
		{
			if((is_int($key))&&(is_string($val)))
				$keylist[] = $val;
			else 
				$keylist[] = $key;
		}
		
		rsort($keylist);
		
		$this->query = $_REQUEST['q'];
		$len = strlen($this->query);
		
		$this->currpage = NULL;
		if($len==0)
		{
			$this->currpage = '';
			
			$this->args = substr($this->query,$len+1,strlen($this->query)-$len);
			$this->args = explode('/', $this->args);
		}
		else 
		{
			foreach($keylist as $url)
			{
				//if(substr($url, 0, $len)==$this->query)
				if(substr($this->query, 0, $len)==$url)
				{
					if($this->currpage==NULL)
					{
						$this->currpage = $url;
						
						$this->args = substr($this->query,$len+1,strlen($this->query)-$len);
						$this->args = explode('/', $this->args); 
						
						break;
					}
				}
			}
		}
		$urls = $this->conf('urls');
		
		if(!empty($urls[$this->domen][$this->currpage]['title']))
		{
			$this->page_title = $urls[$this->domen][$this->currpage]['title'];
		}
		if($this->currpage=='')
		{
			$this->page_title = $urls[$this->domen][$this->currpage]['title'];
			$this->currpage = "main";
		}
		
		/*else
		{
			foreach($urls[$this->domen] as $url => $page)
			{
				if(is_array($urls[$this->domen][$this->currpage]))
				{
					$this->page_title = $urls[$this->domen][$this->query]['title'];
				}
				
			}
		}*/
	}
	
	//
	function settitle($title)
	{
		if($this->page_title=="")
			$this->page_title = $title;
	}
	
	function addpack($pack,$packaparams=NULL)
	{
		$this->packman->addpack($pack,$packaparams);
	}
	
	function base_html_ontitle()
	{
		echo $this->page_title;
	}
	
	function base_theme_oncontent()
	{
		
		include $this->conf("pagesdir").$this->domen."/".$this->currpage."/index.php";		
	}
	
	function createpage($page)
	{
		if(!file_exists($this->conf("pagesdir").$this->domen."/".$page))		
			mkdir($this->conf("pagesdir").$this->domen."/".$page);
		file_put_contents($this->conf("pagesdir").$this->domen."/".$page."/index.php","<?php ?>");
	}
}
?>