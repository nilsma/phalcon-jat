<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $this->assets->outputCss(); ?>
    <?php echo $this->assets->outputJs(); ?>
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-40419390-3', 'auto');
      ga('send', 'pageview');

    </script>
    <title>Job Application Tracker</title>
	</head>
	<?php
	if($this->router->getControllerName() == "") {
	    $body_id = "index";
	} else {
	    $body_id = $this->router->getControllerName();
	}
	?>
	<body id="<?php echo $body_id; ?>">
		<?php echo $this->getContent(); ?>
	</body>
</html>