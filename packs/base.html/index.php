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
			$this->event("onmeta");
		?>
		<?php 
			$this->event("oncss");
		?>
		<?php 
			$this->event("onjs");
		?>
		<title><?php $this->event("ontitle"); ?></title>
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