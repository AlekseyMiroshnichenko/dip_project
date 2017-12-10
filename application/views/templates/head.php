<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title><?=$title;?></title>
		<script type="text/javascript" src="<?=base_url();?>app/js/jquery/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="<?=base_url();?>app/js/popper/popper.js"></script>
		<script type="text/javascript" src="<?=base_url();?>app/js/bootstrap/bootstrap.min.js"></script>
		<link rel="stylesheet" href="<?=base_url();?>app/css/bootstrap/bootstrap.min.css"></link>
		<link rel="stylesheet" href="<?=base_url();?>app/vendors/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=base_url();?>app/css/style.css"></link>
	</head>
	<body>
	<section class="body">
		<nav class="navbar navbar-expand-lg navbar-dark bg-faded bg-dark">
		  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <a class="navbar-brand" href="<?=base_url();?>">КНУТД</a>
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav general-nav-ul">
		      <li class="nav-item <?=($this->uri->segment(1)=='calculating')?"active":"";?>">
		        <a class="nav-link" href="<?=base_url();?>">Головна</span></a>
		      </li>
		     <!--  <li class="nav-item <?=($this->uri->segment(1)=='cacl_history')?"active":"";?>">
		        <a class="nav-link" href="#">Історія</a>
		      </li> -->
		      <li class="nav-item <?=($this->uri->segment(1)=='users')?"active":"";?>">
		        <a class="nav-link" href="<?=base_url();?>users">Співробітники</a>
		      </li>
		      <li class="nav-item float-right">
		        <a class="nav-link" href="<?=base_url();?>logout">Вихід</a>
		      </li>
		    </ul>
		  </div>
		</nav>
		<div class="content">