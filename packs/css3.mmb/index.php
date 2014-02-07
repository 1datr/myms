<?php 
/* theme manager */
class css3_mmb extends package
{
	VAR $theme;
	VAR $libdir;
	
	function base_html_oncss()
	{
		$this->libdir = $_SERVER['DOCUMENT_ROOT']."/lib/css3-mmb/";
		$hdir = dir($this->libdir."/css");
		while (false !== ($entry = $hdir->read())) {
			if(($entry!=".")&&($entry!=".."))
			{
				?>
						<link href='/lib/css3-mmb/css/<?php echo $entry; ?>' rel='stylesheet' type='text/css'>				
						<?php 
						
					}
				}
			}
			
		function base_html_onjs()
		{
			$this->libdir = $_SERVER['DOCUMENT_ROOT']."/lib/css3-mmb/";		
			$hdir = dir($this->libdir."/js");
			while (false !== ($entry = $hdir->read())) {
					if(($entry!=".")&&($entry!=".."))
					{
						?>
						<script type='text/javascript' src='/lib/css3-mmb/js/<?php echo $entry; ?>'></script>			
						<?php 
					}
			}
		}
	
}
?>