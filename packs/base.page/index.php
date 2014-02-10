<?php 
class base_page extends package
{
	
	VAR $query;
	VAR $page_title=NULL;
	VAR $currpage;
	// 
	function OnConstruct()
	{
		$this->query = $_REQUEST['q'];
		$urls = $this->conf('urls');
		if(!empty($urls[$this->query]))
		{
			if(is_array($urls[$this->query]))
			{
				$this->currpage = $urls[$this->query]['page'];
				$this->page_title = $urls[$this->query]['title'];
			}
			else 
				$this->currpage = $urls[$this->query];
		}
		else 
		{
			foreach($urls as $url => $page)
			{
				if(is_array($urls[$this->query]))
				{
					$this->currpage = $urls[$this->query]['page'];
					$this->page_title = $urls[$this->query]['title'];
				}
				else 
					$this->currpage = $page;
				break;	
			}			
		}
		// walk all pages and generate page body if empty
		$confs = $this->conf('urls');
		foreach($confs as $url => $page)
		{
			if(is_int($url))
			{
				if(!file_exists($this->conf("pagesdir").$page."/index.php"))
					$this->createpage($page);
			}
			else 
			{
				if(is_array($page))
				{
					if(!file_exists($this->conf("pagesdir").$page['page']."/index.php"))
						$this->createpage($page);
				}
				elseif(is_string($page))
				{
					if(!file_exists($this->conf("pagesdir").$page."/index.php"))
						$this->createpage($page);
				}
			}
		}
		
		// first start of page
		if(file_exists($this->conf("pagesdir").$page."/onload.php"))
		{
			include $this->conf("pagesdir").$page."/onload.php";
		}
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
		
		include $this->conf("pagesdir").$this->currpage."/index.php";		
	}
	
	function createpage($page)
	{
		mkdir($this->conf("pagesdir").$page);
		file_put_contents($this->conf("pagesdir").$page."/index.php","<?php ?>");
	}
}
?>