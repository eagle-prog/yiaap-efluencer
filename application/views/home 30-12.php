<?php
$page_skill=$this->auto_model->getFeild('skills','pagesetup','id','1');
$page_testimonial=$this->auto_model->getFeild('testimonial','pagesetup','id','1');
$page_cms=$this->auto_model->getFeild('cms','pagesetup','id','1');
$page_counting=$this->auto_model->getFeild('counting','pagesetup','id','1');
$cms_sec1=$this->auto_model->getalldata('','cms','id','1');
$cms_sec2=$this->auto_model->getalldata('','cms','id','2');
$cms_sec3=$this->auto_model->getalldata('','cms','id','3');
?>
<section class="banner">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators 
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>-->

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="<?php echo IMAGE;?>banner01.jpg" alt="...">
      <div class="carousel-caption">
	  <?php echo $content_sec1; ?>
       <!-- <h1>Welcome to our site<br>
		<span>Make your business quick and powerfull</span></h1> -->
        <a href="<?php echo base_url('login?refer=postjob')?>" class="btn btn-lg btn-site btn-big"><img src="<?php echo IMAGE;?>tie.png" alt=""> Post a Job</a>&nbsp;&nbsp;
        <a href="<?php echo base_url('signup');?>" class="btn btn-lg btn-warning btn-big"><i class="zmdi zmdi-account" style="font-size: 22px;line-height: 1"></i> Register now</a>
      </div>
    </div>
    <!--<div class="item">
      <img src="<?php echo IMAGE;?>banner02.jpg" alt="...">
      <div class="carousel-caption">
        <h1>Welcome to our site<br>
		<span>Make your business quick and powerfull</span></h1>
      </div>
    </div>-->
    
      
  </div>

  <!-- Controls 
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>-->
</div>  
</section>
<div class="clearfix"></div>
<section class="text-center sec">
<div class="container">
<h2 class="title">Our <span class="siteC">Plans</span><br> <img class="text-center" src="<?php echo IMAGE;?>small.png" alt=""/></h2>
<div class="pricing-table">
<div class="price" data-effect="slide-left">
    <div class="name"><h2>&nbsp;</h2><h4>&nbsp;</h4></div>
        <ul>
            <li>Bids</li>
            <li>Skills</li>
            <li>Portfolio</li>
            <li>Projects</li>
            <li>Unlimited Days</li>
        </ul>						
</div>
<?php if(count($mem_plans) > 0){ foreach($mem_plans as $k => $v){ 
	$price_cls = 'free';
	$style = 'background-color:#00a651';
	if($k == 1){
		$price_cls = 'silver featured';
		$style = 'background-color:#00aae2';
	}else if($k == 2){
		$price_cls = 'gold';
		$style = 'background-color:#cc9900';
	}else if($k == 3){
		$price_cls = 'platinum';
		$style = 'background-color:#fc7e66';
	}
?>

<div class="price <?php echo $price_cls;?>" data-effect="slide-left">
    <div class="name" style="<?php echo $style;?>"><h2><?php echo ucfirst($v['name']);?></h2><h4>Jobbid Fees : <span><?php echo round($v['bidwin_charge']);?></span> % </h4></div>
		<ul>
			<li><?php echo $v['bids'];?></li>
            <li><?php echo $v['skills'];?></li>
            <li><?php echo $v['portfolio'];?></li>
            <li><?php echo $v['project'];?></li>
			<?php if(strtolower($v['days']) == 'unlimited'){ ?>
			<li><i class="zmdi zmdi-check"></i></li>
			<?php } else { ?>
			 <li><i class="zmdi zmdi-close"></i></li>
			<?php } ?>
           
        </ul> 					
</div>
<?php } } ?>


</div>
<div class="center-block text-center" style="display:none;">
<div class="btn-group unfold">
  <button type="button" class="btn btn-site dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="zmdi zmdi-unfold-more"></i> <!--<i class="zmdi zmdi-unfold-less">--></i>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <a href="#" class="btn btn-site"> View More</a>
</div>
</div>
</div>  
</section>
<div class="clearfix"></div>

<?php if($page_skill=='Y') { ?>
<!-- skill secton start -->

<section class="sec skills" data-effect="slide-bottom">
<div class="container">
<h2 class="title">What <span class="siteC">skills</span> you looking for?<br> <img class="text-center" src="<?php echo IMAGE;?>small.png" alt=""/></h2>
<div class="row">


<?php if(count($skills) > 0){ foreach($skills as $k => $v){
	$img = !empty($v['image']) ? ASSETS.'skill_image/'.$v['image'] : IMAGE.'no-image_60x60.png';
?>
<article class="col-md-3 col-sm-4 col-50 col-xs-12">
<div class="skill-widgets">
    <a href="<?php echo base_url('findtalents/filtertalent/'.$v['id'].'/All')?>" class="icon">
        <img  src="<?php echo $img;?>" alt=""/>
    </a>
<h5><a href="<?php echo base_url('findtalents/filtertalent/'.$v['id'].'/All')?>"><?php echo strlen($v['skill_name']) > 20 ? substr(ucwords($v['skill_name']) , 0 , 20).'..' : ucwords($v['skill_name']);?></a></h5>
</div>
</article>
<?php } } ?>



</div>
<div class="center-block text-center" style="display:none;">
	<a href="#" class="btn btn-border btn-lg tu">See all influencers</a>
</div>
</div>
</section>

<!-- skill section end -->
<?php } ?>
<div class="clearfix"></div>

<section class="sec freeStart" data-effect="slide-left">
  <div class="container">
  <aside class="col-sm-6 col-xs-12">
  <?php echo $content_sec2_header; ?>
      <!-- <h2>Free <span>started</span></h2> -->
      <hr class="thin-line" />
	  <h4><?php echo $content_sec2_body; ?></h4>
      <!-- <h4>Try the free trial starter pack, and enjoy all the advantages<br> of our service is absolutely free.</h4> -->
  </aside>
  <aside class="col-sm-6 col-xs-12">
  	<a href="<?php echo base_url('signup');?>" class="btn btn-lg btn-white pull-right">Try it Now</a>
  </aside>
  </div>
</section>
<div class="clearfix"></div>

<?php if($page_testimonial=='Y') { ?>
<!-- client testimonial section -->

<section class="sec happyClient" data-effect="slide-bottom">
<div class="overlay"></div>
  <div class="container">
  <h2 class="title">WHAT OUR <span class="siteC">CLIENT</span> SAY<br> <img class="text-center" src="<?php echo IMAGE;?>small.png" alt=""/></h2>
  <h5 class="text-center"><?php echo $content_sec3; ?></h5>
  <?php if(count($testimonials) > 0){ foreach($testimonials as $k => $v){  
	if($k > 1){
		break;
	}
	$client = $this->db->select('fname , lname , logo')->where('user_id' , $v['user_id'])->get('user')->row_array();
	$client['logo'] = !empty($client['logo']) ? ASSETS.'uploaded/'.$client['logo'] : ASSETS.'images/user.png';
  ?>
  <aside class="col-md-6 col-sm-12 col-xs-12">
  	<div class="media client">
    	<div class="media-left">
    		<img src="<?php echo $client['logo'];?>" alt="Client image" class="img-circle">
    	</div>
        <div class="media-body">
        <img src="<?php echo IMAGE;?>quote_top.png" alt="">
    		<p><?php echo $v['description'];?> </p>
            <h5 class="name"><?php echo strtoupper($client['fname'].' '.$client['lname']);?></h5>
            <span class="line"><img src="<?php echo IMAGE;?>line.png" alt=""></span>
            <p class="designation"><?php echo date('d M , Y' , strtotime($v['posted']));?></p>
    	</div>
    </div>
  </aside>
  <?php } } ?>
 
  </div>
</section> 

<!-- end of client testimonial section -->
<?php } ?>
 
<div class="clearfix"></div>

<!-- partner section start -->
<section class="sec partner" data-effect="slide-right">
	<div class="container">
    	<ul class="">
			<?php if(count($partner) > 0){foreach($partner as $k => $v){ ?>
				<li><a href="#"><img src="<?php echo ASSETS.'partner_image/'.$v['image']?>" alt="<?php echo $v['name']?>"></a></li>
			<?php } } ?>
        
	</div>
</section>  

<!-- end of partner section -->

<div class="clearfix"></div>
<section class="sec ourTeam">
	<div class="container">    	
        <h2 class="title">Work with someone <span class="siteC">perfect</span> for your<span class="siteC"> team</span><br> <img class="text-center" src="<?php echo IMAGE;?>small.png" alt=""/></h2>
        <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-left">
        	<div class="team">
            	<div class="hexagon" style="background-image: url(<?php echo IMAGE;?>team1.png)">
                  <div class="hexTop"></div>
                  <div class="hexBottom"></div>
                </div>
                <p>Kelly</p>
                <h5><a href="#">Web Designer</a></h5>
                <ul class="social-icons icon-circle icons-A hidden-xs">                  
                  <li data-effect="helix"><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-twitter"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </article>
        
        <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-left">
        	<div class="team">
            	<div class="hexagon" style="background-image: url(<?php echo IMAGE;?>team2.png)">
                  <div class="hexTop"></div>
                  <div class="hexBottom"></div>
                </div>
                <p>Jonathan Doe</p>
                <h5><a href="#">Android Developer</a></h5>
                <ul class="social-icons icon-circle icons-A hidden-xs">                  
                  <li data-effect="helix"><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-twitter"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </article>
        
        <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-right">
        	<div class="team">
            	<div class="hexagon" style="background-image: url(<?php echo IMAGE;?>team3.png)">
                  <div class="hexTop"></div>
                  <div class="hexBottom"></div>
                </div>
                <p>Elvira</p>
                <h5><a href="#">Web Designer</a></h5>
                <ul class="social-icons icon-circle icons-A hidden-xs">                  
                  <li data-effect="helix"><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-twitter"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </article>
        
        <article class="col-md-3 col-sm-6 col-xs-12" data-effect="slide-right">
        	<div class="team">
            	<!--<div class="hexagon">
                	<a href="#"><img src="<?php echo IMAGE;?>team4.png" alt=""></a>
                </div>-->
                <div class="hexagon" style="background-image: url(<?php echo IMAGE;?>team4.png)">
                  <div class="hexTop"></div>
                  <div class="hexBottom"></div>
                </div>
                <p>Adam Smith</p>
                <h5><a href="#">Video Editor</a></h5>
                <ul class="social-icons icon-circle icons-A hidden-xs">                  
                  <li data-effect="helix"><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-twitter"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li data-effect="helix"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </article>
    </div>
</section>    
<section class="sec experts hidden-xs" data-effect="slide-bottom">
	<div class="container">
    	<div class="row">
        <article class="col-sm-5 col-xs-12">       
        	<div class="diamondSquare diamond-lg"><h3><!--"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."--><?php echo $content_sec4_left; ?></h3></div>            
        </article>   
        <article class="col-sm-4 col-xs-12 pull-right">       
        	<div class="diamondSquare diamond-sm">
			<?php  echo $content_sec4_right; ?>
            	<!-- <h3>Mr. Josef<br><span>CEO</span></h3> -->
            </div>            
        </article>     
        </div>
    </div>
</section> 

<section class="sec experts visible-xs" data-effect="slide-bottom">
	<div class="container">
    	<div class="row">
        <article class="col-sm-5 col-xs-12">       
        	<h3>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h3>          
        </article>   
        <article class="col-sm-4 col-xs-12">       
        	
            	<h3>Mr. Josef<br><span>CEO</span></h3>
                 
        </article>     
        </div>
    </div>
</section>
<div class="clearfix"></div>

<!-- fantastic facts section start --> 
<?php  
$page_counting=$this->auto_model->getFeild('counting','pagesetup','id','1');
if($page_counting=='Y') { 
$user=$this->auto_model->getFeild('no_of_users', 'setting', 'id', 1);
$project=$this->auto_model->getFeild('no_of_projects', 'setting', 'id', 1);
$complete_project=$this->auto_model->getFeild('no_of_completed_prolects', 'setting', 'id', 1);
?>
<section class="sec projects happyClient" data-effect="slide-left">
<div class="overlay"></div>
  <div class="container">
  <h2 class="title"><!--FANTASTIC  <span class="siteC">facts</span><br> --><?php echo $content_sec5_header; ?> <img class="text-center" src="<?php echo IMAGE;?>small.png" alt=""/></h2>
  <h5 class="text-center subtitle"><?php echo $content_sec5_body; ?></h5>
  <article class="col-sm-4 col-xs-12">
  	<div class="facts">
    <h2 style="color:#fd5f42"><?php echo $user;?></h2>
    <h5>Total user</h5>
	<img src="<?php echo IMAGE;?>user.png" alt="">            
    </div>
  </article>
  <article class="col-sm-4 col-xs-12">
  	<div class="facts">
    <h2 style="color:#f7c640"><?php echo $project;?></h2>
    <h5>Total projects</h5>
	<img src="<?php echo IMAGE;?>projects.png" alt="">            
    </div>
  </article>
  <article class="col-sm-4 col-xs-12">
  	<div class="facts">
    <h2 style="color:#a8cf69"><?php echo $complete_project;?></h2>
    <h5>Total COMPLETED PROJECTS</h5>
	<img src="<?php echo IMAGE;?>suitcase.png" alt="">            
    </div>
  </article>  
  </div>
</section> 
<?php } ?>
<!-- fantastic facts section end -->


<!-- social section start -->
<section class="triangle-icon">
	<ul class="social-icons diamondShape-icon">  
<?php
$popular=$this->auto_model->getalldata('','popular','id','1');
if(!empty($popular)){foreach($popular as $vals){ ?>

<?php  if($vals->facebook=='Y' && ADMIN_FACEBOOK!=''){ ?>
 <li data-effect="helix"><a href="<?php echo ADMIN_FACEBOOK;?>"><i class="fa fa-facebook"></i></a></li>
<?php } ?>

<?php  if($vals->twitter=='Y' && ADMIN_TWITTER!=''){ ?>
 <li data-effect="helix"><a href="<?php echo ADMIN_TWITTER;?>"><i class="fa fa-twitter"></i></a></li>
<?php } ?>

<?php   if($vals->linkedin=='Y' && ADMIN_LINKEDIN!=''){ ?>
<li data-effect="helix"><a href="<?php echo ADMIN_LINKEDIN;?>"><i class="fa fa-linkedin"></i></a></li>
<?php } ?>


<?php } } ?>	
     
     
      <!--<li data-effect="helix"><a href="#"><i class="fa fa-google-plus"></i></a></li>
      <li data-effect="helix"><a href="#"><i class="fa fa-instagram"></i></a></li>
      <li data-effect="helix"><a href="#"><i class="fa fa-vimeo"></i></a></li>-->
    </ul>
</section> 
<!-- social section end -->