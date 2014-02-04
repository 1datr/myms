<?php 
/* theme manager */
class base_theme extends package
{
	VAR $theme;
	
	function OnConstruct()
	{
		$mode = $this->arg('mode');
		$conf = $this->conf('themes');
		$this->theme = $conf[$mode];
	}
	
	function base_html_oncss()
	{
		$hdir = dir($_SERVER['DOCUMENT_ROOT']."/themes/".$this->theme."/css");
		while (false !== ($entry = $hdir->read())) {
			if(($entry!=".")&&($entry!=".."))
			{
				?>
				<link href='/themes/<?php echo $this->theme; ?>/css/<?php echo $entry; ?>' rel='stylesheet' type='text/css'>				
				<?php 
				
			}
		}
	}
	
	function base_html_onjs()
	{
		$hdir = dir($_SERVER['DOCUMENT_ROOT']."/themes/".$this->theme."/js");
		while (false !== ($entry = $hdir->read())) {
			if(($entry!=".")&&($entry!=".."))
			{
				?>
				<script type='text/javascript' src='/themes/<?php echo $this->theme; ?>/js/<?php echo $entry; ?>'></script>			
				<?php 
			}
		}
	}
	
	function base_html_onbody()
	{
		include $_SERVER['DOCUMENT_ROOT']."/themes/".$this->theme."/index.php";
	}
		
	
}
?>