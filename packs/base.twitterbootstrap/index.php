<?php 
/* theme manager */
class base_twitterbootstrap extends package
{
	VAR $theme;
	VAR $libdir;
		
	function base_html_oncss()
	{
		$this->libdir = $_SERVER['DOCUMENT_ROOT']."/lib/twitter_bootstrap/";
		$hdir = dir($this->libdir."/css");
		while (false !== ($entry = $hdir->read())) {
			if(($entry!=".")&&($entry!=".."))
			{
				?>
					<link href='/lib/twitter_bootstrap/css/<?php echo $entry; ?>' rel='stylesheet' type='text/css'>				
					<?php 
					
				}
			}
		}
		
	function base_html_onjs()
	{
		$this->libdir = $_SERVER['DOCUMENT_ROOT']."/lib/twitter_bootstrap/";		
		$hdir = dir($this->libdir."/js");
		while (false !== ($entry = $hdir->read())) {
				if(($entry!=".")&&($entry!=".."))
				{
					?>
					<script type='text/javascript' src='/lib/twitter_bootstrap/js/<?php echo $entry; ?>'></script>			
					<?php 
				}
		}
	}
	
	
}
?>