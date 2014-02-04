<?php 
class base_html extends package
{
	function exe()
	{
		$this->event("beforeprint");
		?>
<html>
	<head>
		<?php 
			$this->event("oncss");
		?>
		<?php 
			$this->event("onjs");
		?>
	</head>
	<body>
		<?php 
			$this->event("onbody");
		?>
	</body>
</html>		
		<?php
		$this->event("afterprint");
		
	}
	
}
?>