<?php 
class base_page extends package
{
	
	VAR $query;
	VAR $page_title;
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
		// generate if empty
		foreach($this->conf('urls') as $url => $page)
		{
			if(is_array($page))
			{				
				if(!file_exists($this->conf("pagesdir").$page['page']."/index.php"))
					$this->createpage($page);
			}
			else 
			{
				if(!file_exists($this->conf("pagesdir").$page."/index.php"))				
					$this->createpage($page);
			}
		}
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