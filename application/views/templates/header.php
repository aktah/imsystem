<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>favicon.ico">

  <title>ระบบบริการจัดการเครื่องมือเพื่อใช้ในงานวิจัย</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url(); ?>assets/css/agency.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top mb-5" style="
background-color: rgba(0, 0, 0, 0.8);
background-repeat: no-repeat;
background-position: center center;
background-size: cover;" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">IM System</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      Menu
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($this->uri->segment(1) == '' && $this->uri->segment(2) == '') ? 'active' : ''; ?> js-scroll-trigger" href="<?php echo base_url();?>">หน้าแรก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($this->uri->segment(1) == 'service') ? 'active' : ''; ?> js-scroll-trigger" href="<?php echo base_url();?>service">บริการ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($this->uri->segment(1) == 'contact') ? 'active' : ''; ?> js-scroll-trigger" href="<?php echo base_url();?>contact">ติดต่อเรา</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="col-lg-12 row my-5">