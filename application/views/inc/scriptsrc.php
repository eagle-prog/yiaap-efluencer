<!DOCTYPE HTML>
<?php
$currLang = '';
if ($this->session->userdata('lang')) {
  $currLang = $this->session->userdata('lang');
}
$lang_pos = 'ltr';
if ($currLang == 'arabic') {
  $lang_pos = 'rtl';
}
?>
<html dir="<?php echo $lang_pos; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  if (isset($meta_tag)) {
    echo $meta_tag;
  } else {
    ?>
    <?php $siteTitle = $this->auto_model->getFeild('site_title', 'setting', 'id', 1); ?>

      <title>
        <?php echo !empty($siteTitle) ? $siteTitle : ''; ?>
      </title>
      <meta name="author" content="Originatesoft"/>
      <meta name="description" content="<?= SITE_DESC ?>"/>
      <meta name="keywords" content="<?= SITE_KEY ?>"/>
      <meta name="application-name" content="<?php echo !empty($siteTitle) ? $siteTitle : ''; ?>"/>
    <?php
  }
  ?>
    <!-- Favicons -->
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <!--<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">-->
    <!-- Bootstrap core CSS -->
  <?php if ($currLang == 'arabic') { ?>
      <link href="<?= CSS ?>bootstrap.rtl.css" rel="stylesheet" type="text/css">
  <?php } else { ?>
      <link href="<?= CSS ?>bootstrap.css" rel="stylesheet" type="text/css">
  <?php } ?>

    <!-- Fonts -->
    <link href="<?= CSS ?>fontawesome-all.min.css" rel="stylesheet">
    <link href="<?= CSS ?>material-design-iconic-font.css" rel="stylesheet">
    <!--[if lte IE 9]>
    <script src="js/html5shiv.js"></script>
    <link href="css/ie.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <![endif]-->

    <link href="<?= CSS ?>magic-check.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= CSS ?>superfish.css" media="screen" type="text/css"/>
    <!-- Theme CSS -->

  <?php if ($currLang == 'arabic') { ?>
      <link href="<?= CSS ?>style_ar.css" rel="stylesheet" type="text/css">
  <?php } else { ?>
      <link href="<?= CSS ?>style_en.css" rel="stylesheet" type="text/css">
  <?php } ?>
    <link href="<?= CSS ?>theme.css" rel="stylesheet" type="text/css">
    <link href="<?= CSS ?>style.css" rel="stylesheet" type="text/css">
    <link href="<?= CSS ?>responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= CSS ?>menusection.css" type="text/css"/>
    <link rel="stylesheet" href="<?= CSS ?>pricing-table.css">
    <link rel="stylesheet" href="<?= CSS ?>prettyPhoto.css" media="screen">
    <!-- Skin -->

    <link rel="stylesheet" href="<?= CSS ?>colors/blue.css" id="colors" type="text/css"/>
    <!-- Responsive CSS -->
  <?php /*?><link rel="stylesheet" href="<?=CSS?>theme-responsive.css" type="text/css" /><?php */ ?>
    <!-- Switcher CSS -->

    <link href="<?= CSS ?>switcher.css" rel="stylesheet" type="text/css"/>
    <link href="<?= CSS ?>spectrum.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?= CSS ?>foundation.css" type="text/css"/>
    <!-- Favicons -->

    <link rel="shortcut icon" href="<?= ASSETS ?>favicon/<?php echo SITE_FAVICON; ?>">

  <?php if ($current_page == 'dashboard') { ?>
      <script type="text/javascript" src="<?= JS ?>jquery-3.3.1.min.js"></script>
  <?php }else{ ?>
      <script src="<?= JS ?>jquery.min.js"></script>
  <?php } ?>

  <?php /*<script type="text/javascript" src="<?=JS?>jquery-2.2.4.js"></script>*/ ?>
    <script type="text/javascript" src="<?= JS ?>animation.min.js"></script>
    <!--<script src="<?php // echo JS;?>jquery.pagescroll.min.js"></script>-->
    <script src="<?php echo JS; ?>jquery.nicescroll.min.js"></script>
    <!--<link rel="stylesheet" href="<?php // echo ASSETS;?>jquery/jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?php // echo ASSETS;?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?php // echo ASSETS;?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?php // echo ASSETS;?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>-->
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->

    <!--[if lt IE 9]>
  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <script src="<?= JS ?>respond.min.js"></script>
  <![endif]-->
    <!--[if IE]>
  <link rel="stylesheet" href="<?= CSS ?>ie.css">
  <![endif]-->
  <?php echo $load_css_js; ?>

</head>
