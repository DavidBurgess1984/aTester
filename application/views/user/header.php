<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" href="../../favicon.ico">-->

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo asset_url();?>vendors/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_url();?>vendors/datepicker/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo asset_url();?>/css/navbar-fixed-side.css" rel="stylesheet">
    <link href="<?php echo asset_url();?>/css/bs-style.css" rel="stylesheet">
    <link href="<?php echo asset_url();?>vendors/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
    <link href="<?php echo asset_url();?>/css/style_app.css" rel="stylesheet">
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">-->

    <!-- Custom styles for this template -->
    <!--<link href="starter-template.css" rel="stylesheet">-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
      <input id='user-data' type='hidden' data-user-id ='<?php echo $userID; ?>' data-user-email='<?php echo $userEmail; ?>' disabled='disabled' />

