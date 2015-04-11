<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ assets.outputCss() }}
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    {{ assets.outputJs() }}
	<title>Job Application Tracker</title>
	</head>
	<body id="{{ router.getControllerName() }}">
		{{ content() }}
	</body>
</html>