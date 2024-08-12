<head>
	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" /> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="OceanApps">
	<meta name="author" content="OceanApps">
	<meta name="keywords" content="OceanApps, Oceamerp">

	<link rel="preconnect" href="https://fonts.gstatic.com/">
	<link rel="shortcut icon" href="assets/img/icons/icon-48x48.png" />

	<link rel="canonical" href="index.html" />

	<title>OceanApps- ERP</title>

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
	<?php
	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
	$host = $_SERVER['SERVER_NAME'];
	$port = $_SERVER['SERVER_PORT'];
	
	// Exclude standard ports from URL
	if (($protocol === 'http://' && $port != 80) || ($protocol === 'https://' && $port != 443)) {
		$rootUrl = $protocol . $host . ':' . $port;
	} else {
		$rootUrl = $protocol . $host;
	}

	?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link class="js-stylesheet" href="<?php echo $rootUrl.'/oceanerp/assets/css/light.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $rootUrl.'/oceanerp/assets/css/bootstrap-datepicker.min.css';?>"> 
	<link rel="stylesheet" type="text/css" href="<?php echo $rootUrl.'/oceanerp/assets/css/mdp.css';?>">  	
	<link rel="stylesheet" type="text/css" href="<?php echo $rootUrl.'/oceanerp/assets/css/prettify.css';?>"> 
	<link rel="stylesheet" type="text/css" href="<?php echo $rootUrl.'/oceanerp/assets/css/jquery-ui.css';?>">  

	<style>
		body {
			opacity: 0;
		}
	</style>
	<!-- END SETTINGS -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120946860-10"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120946860-10', { 'anonymize_ip': true });
</script>
</head>
 
