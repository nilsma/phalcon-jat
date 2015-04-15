<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ assets.outputCss() }}
    {{ assets.outputJs() }}
	<title>Job Application Tracker</title>
	</head>
	<?php
	if($this->router->getControllerName() == "") {
	    $body_id = "index";
	} else {
	    $body_id = $this->router->getControllerName();
	}
	?>
	<body id="{{ body_id }}">
		{{ content() }}
	</body>
</html>