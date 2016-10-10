<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo FORM_PROJECT_NAME; ?></title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      
      <!-- Form styles and scripts -->
      <link type="text/css" href="<?php echo FORM_PROJECT_URL; ?>/css/form.css" rel="stylesheet" />    

      
      <!-- reCAPTCHA -->
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    </head>
  <body>
      <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo FORM_PROJECT_URL; ?>"><?php echo FORM_PROJECT_NAME; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo FORM_PROJECT_URL; ?>">Home</a></li>
            <li><a href="<?php echo FORM_PROJECT_URL; ?>/#about">About</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
      
    <div id="page" class="container">
    <div class="row">
    <div class="col-md-12">
        
        <h1><php echo FORM_PROJECT_NAME; ?></h1>
        
   
    
        