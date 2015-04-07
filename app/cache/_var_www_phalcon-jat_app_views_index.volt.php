<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <?php echo $this->assets->outputCss(); ?>
    <?php echo $this->assets->outputJs(); ?>
	<title>Job Application Tracker</title>
	</head>
	<body id="<?php echo $this->router->getControllerName(); ?>">
		<?php echo $this->getContent(); ?>
	</body>
</html>