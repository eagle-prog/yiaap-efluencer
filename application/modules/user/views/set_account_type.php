<html>
<head>

<title>Set account type</title>
<script src="<?=JS?>jquery.min.js"></script>
<?php if($currLang == 'arabic'){ ?>
<link href="<?=CSS?>bootstrap.rtl.css" rel="stylesheet" type="text/css">
<link href="<?=CSS?>style_ar.css" rel="stylesheet" type="text/css">
<?php }else{ ?>
<link href="<?=CSS?>bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=CSS?>style_en.css" rel="stylesheet" type="text/css">
<?php } ?>
<link href="<?=CSS?>magic-check.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <style>
body {
    font-family: 'IBM Plex Sans', sans-serif;
    background-color: #f5f5f5;
}
header {
	background-color:#fff;
	border-bottom:1px solid #ddd;
	padding:10px;
}
.text-center {
	text-align:center
}
.uppercase {
	text-transform:uppercase
}
.signup {
    color: #fff;
    position: relative;
	padding:30px 0;
    overflow: hidden;
    z-index: 1;
}
.for-freelancer {
    padding-left: 15px;
}
.radio-inline {
	margin-top:0;
	margin-bottom:10px
}
@media (min-width: 768px) {
.signup:before, .signup:after {
    content: '';
    position: absolute;
	top: 0;
    height: 100%;
    width: 50%;
    height: 100%;
    z-index: -1;
}
.signup:before {
    background-color: #2C597A;
	left: 0;
}
.signup:after {
    background-color: #29b6f6;
	right: 0;
}
}
</style>
</head>
<body>
<header>
<div class="container">
<?php if($currLang == 'arabic'){ ?>
    <img src="<?=ASSETS?>img/logo_ar.png" alt="" title="">
    <?php }else{ ?>
    <img src="<?=ASSETS?>img/<?php echo SITE_LOGO;?>" alt="" title="">
<?php } ?>
</div>
</header>
<section class="sec signup hidden-xs" id="work_hire">
<div class="container">
<div class="row">
	<aside class="col-sm-6 col-xs-12">
    	<div class="for-employer">   
        <h3 class="uppercase"><?php echo __('signup_how_it_works_for_employer','How it works for employer'); ?></h3>
        <div class="row text-center"> 
              <article class="col-sm-5 col-xs-12">                
                <img src="<?php echo VPATH;?>assets/images/post-jobs.png" alt="">
                <h5><?php echo __('signup_post_job','Post Jobs'); ?></h5>
              </article>
              <article class="col-sm-5 col-xs-12 pull-right">
                <img src="<?php echo VPATH;?>assets/images/manage-bids.png" alt="">
                <h5><?php echo __('signup_manage_bids','Manage Bids'); ?></h5>
              </article>
              <div class="clearfix"></div>
              	<h3><?php echo __('signup_hire','Hire'); ?></h3>
              <div class="clearfix"></div>
              <article class="col-sm-5 col-xs-12">                
                <img src="<?php echo VPATH;?>assets/images/get-payment.png" alt="">
                <h5><?php echo __('signup_get_paid','Get Payment'); ?></h5>
              </article>
              <article class="col-sm-5 col-xs-12 pull-right">
                <img src="<?php echo VPATH;?>assets/images/service-provider.png" alt="">
                <h5><?php echo __('signup_service_provider','Service Provider'); ?></h5>
              </article>
          </div>
                             
        </div>
	</aside>

	<aside class="col-sm-6 col-xs-12">
    	<div class="for-freelancer">     
    	<h3 class="uppercase"><?php echo __('signup_how_it_works_for_freelancer','How it works for freelancer'); ?></h3>
		<div class="row text-center"> 
              <article class="col-sm-5 col-xs-12">                
                <img src="<?php echo VPATH;?>assets/images/post-jobs.png" alt="">
                <h5><?php echo __('signup_search_jobs','Search Jobs'); ?></h5>
              </article>
              <article class="col-sm-5 col-xs-12 pull-right">
                <img src="<?php echo VPATH;?>assets/images/place-bids.png" alt="">
                <h5><?php echo __('signup_place_bids_on_jobs','Place Bid on Jobs'); ?></h5>
              </article>
              <div class="clearfix"></div>
              	<h3><?php echo __('signup_work','Work'); ?></h3>
              <div class="clearfix"></div>
              <article class="col-sm-5 col-xs-12">                
                <img src="<?php echo VPATH;?>assets/images/get-payment-02.png" alt="">
                <h5><?php echo __('signup_get_paid','Get Payment'); ?></h5>
              </article>
              <article class="col-sm-5 col-xs-12 pull-right">
                <img src="<?php echo VPATH;?>assets/images/worker.png" alt="">
                <h5><?php echo __('signup_do_work_for_employer','Do Work for Employer'); ?></h5>
              </article>
          </div>  
                       
		</div>
	</aside>
</div>
</div>  
</section>
<br><br>
<form id="acc_type_sub" class="text-center">
  <p>Choose your account type:</p>
  <br>
  <div class="radio radio-inline">
  <input type="hidden" value="<?php echo $token?>" name="token" id="token">
  <input type="radio" name="account_type" class="magic-radio" id="employer" value="E" checked='checked'>
  <label for="employer">EMPLOYER</label>
  </div>
  <div class="radio radio-inline">
  <input type="radio" name="account_type" class="magic-radio" id="freelancer" value="F">  
  <label for="freelancer">FREELANCER</label>
  </div>
  <div class="clearfix"></div>
  <input type="submit" class="btn btn-info" value="Continue">
</form>
</body>
<script>
		$( "#acc_type_sub" ).submit(function( event ) {
			event.preventDefault();
			var acc_type_data = {
				token: $("#token").val(),
				acc_type: $("input[name='account_type']:checked").val()
			};
			$.ajax({
				url : '<?php echo base_url('user/acc_type_update')?>',
				data: acc_type_data,
				type: 'POST',
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						if(res.next){
							location.href = res.next;
						}else{
							location.href = '<?php echo base_url('dashboard'); ?>';
						}
					}else{
						alert('Something went wrong');
					}
				}
			});
		});
	</script>
</html>