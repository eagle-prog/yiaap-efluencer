<!-- Footer Start -->
<?php
$page_partner=$this->auto_model->getFeild('partner','pagesetup','id','1');
$page_newsletter=$this->auto_model->getFeild('newsletter','pagesetup','id','1');
$page_posts=$this->auto_model->getFeild('posts','pagesetup','id','1');
$page_popular_links=$this->auto_model->getFeild('popular_links','pagesetup','id','1');
$footer_text=$this->auto_model->getFeild('footer_text','setting','id','1');

$event=$this->auto_model->getalldata('','event','status','Y');
$partner=$this->auto_model->getalldata('','partner','status','Y',6);
$popular=$this->auto_model->getalldata('','popular','id','1');
?>
         <footer id="footer">
<!--Partners  Start-->
  <?php
if($page_partner=='Y' && $current_page=='home')
{
?>


<section class="ft-logos">
<!--Partners  Start-->
  <div class="prt_img_area2">
<div class="container">
 <div class="row">
 <div class="partner_area">
 <h2>Our <span>Partners </span></h2>
 <div class="prt_img_area">
 <ul class="bxslider">
    <li><a target="_blank" href="http://airtel.com"><img width="148" height="70" src="<?php echo ASSETS;?>partner_image/Airtel_bangla_logo.svg__thumb.png"></a></li>
    <li><a target="_blank" href="http://seilder.com"><img width="148" height="70" src="<?php echo ASSETS;?>partner_image/partners2_thumb.jpg"></a></li>
    <li><a target="_blank" href="http://naturalessentials.com"><img width="148" height="70" src="<?php echo ASSETS;?>partner_image/partners3_thumb.jpg"></a></li>
    <li><a target="_blank" href="http://ovelin.com"><img width="148" height="70" src="<?php echo ASSETS;?>partner_image/partners4_thumb.jpg"></a></li>
    <li><a target="_blank" href="http://itp.com"><img width="148" height="70" src="<?php echo ASSETS;?>partner_image/partners6_thumb.jpg"></a></li>
    <li><a target="_blank" href="http://itp.com"><img width="148" height="70" src="<?php echo ASSETS;?>partner_image/partners2_thumb.jpg"></a></li>
    
    
    
<!--					<li><a href="http://airtel.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner1.png"></a></li>
					<li><a href="http://seilder.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner2.png"></a></li>                    
					<li><a href="http://naturalessentials.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner3.png"></a></li> 
					<li><a href="http://ovelin.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner4.png"></a></li>
					<li><a href="http://itp.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner1.png"></a></li>
					<li><a href="http://itp.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner2.png"></a></li> 
					<li><a href="http://airtel.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner1.png"></a></li>
					<li><a href="http://seilder.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner2.png"></a></li>                    
					<li><a href="http://naturalessentials.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner3.png"></a></li> 
					<li><a href="http://ovelin.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner4.png"></a></li>
					<li><a href="http://itp.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner1.png"></a></li>
					<li><a href="http://itp.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner2.png"></a></li> 
					<li><a href="http://airtel.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner1.png"></a></li>
					<li><a href="http://seilder.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner2.png"></a></li>                    
					<li><a href="http://naturalessentials.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner3.png"></a></li> 
					<li><a href="http://ovelin.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner4.png"></a></li>
					<li><a href="http://itp.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner1.png"></a></li>
					<li><a href="http://itp.com"><img alt="Upportdash" src="<?=ASSETS?>images/partner2.png"></a></li>-->                                                            
					
    
    
    
    
                   
 </ul>
 </div>
 </div>
                        
<div style="clear:both;"></div>

</div>
</div>
</div>
<?php
}
?> 
<!--Partners  End-->

         
            <!-- Footer Top Start -->
            <div class="footer-top">
               <div class="container">
                  <div class="row">
                           
<div style="clear:both;"></div>
				
<div class="info_area">
				<?php
                  if($page_newsletter=='Y')
				  {
				  ?>
                <div class="info_lft_area">
                	<ul>
                    <li>
                    <div class="info">
                    	<h2>Newsletter Subscription</h2>
                        <p>Please subscribe our newsletter to get regular update</p>
                    </div>
                    </li>
                    <li>
                    </li>
                    
                    </ul>
                    
                    <div class="ftr_src_area">
                    <span id="subs_error" style="float: left;margin-top: -22px;width: 100%;color: #FF5600;font-size: 16px; display:none;">Enter your email</span>
                    <input id="sub_email" placeholder="Enter your email-id" type="text" class="ftr_src_text" />
                    <input id="subscription" type="button" class="ftr_src_btn"  value="Subscribe" onclick="getSubscription()"/>
                    </div>
                    
                </div>
                 <?php }?>
                <div class="info_rht_area">
                <?php
                  if($page_posts=='Y')
				  {
				  ?>
                	<div class="post_area">
                    <h2>recent post</h2>
                    <ul>
                    <marquee direction="up" scrollamount="3">
                    <?php
					//print_r($event);
                    foreach($event as $val)
					{
					?>
                    <li><?php echo ucwords(html_entity_decode($val->event_desc));?></li>
                     <p class="yel_text"><?php echo date('d M, Y',strtotime($val->created));?></p>
                     <?php
					}
					 ?>
                    </marquee>
                    </ul>
                    </div>
                 <?php }?>   
                <?php
                  if($page_popular_links=='Y')
				  {
				  ?>

                    <div class="post_area right">
                    <h2 class="padding-left20">popular links</h2>
                    <?php
                    foreach($popular as $vals)
					{
					?>
                    <?php
                    if($vals->terms=='Y')
					{
					?>
                        <div class="text textcol2"><a href="<?php echo  base_url()?>information/info/terms_condition">Terms & Conditions</a></div>
                        <?php
					}
						?>
                        <?php
                    if($vals->service=='Y')
					{
					?>
                        <div class="text textcol2"><a href="<?php echo  base_url()?>information/info/service_agreement">Service provider agreement</a></div><?php }?>
                        
                        <?php
                    if($vals->refund=='Y')
					{
					?>
                         <div class="text textcol2"><a href="<?php echo  base_url()?>information/info/refund_policy">Refund Policy</a></div><?php }?>
                     <?php
                    if($vals->privacy=='Y')
					{
					?>
                        <div class="text textcol2"><a href="<?php echo  base_url()?>information/info/privacy_policy">Privacy Policy</a></div><?php }?>
                        <?php
                    if($vals->faq=='Y')
					{
					?>
                        <div class="text textcol2"><a href="<?php echo  base_url()?>faq_help">FAQs</a></div><?php }?>
                        <?php
                    if($vals->sitemap=='Y')
					{
					?>
                        <div class="text textcol2"> <a href="<?php echo  base_url()?>sitemap">Sitemap</a></div><?php }?>
                        <?php
                    if($vals->contact=='Y')
					{
					?>
                        <div class="text textcol2"> <a href="<?php echo VPATH;?>contact/">Contact Us</a></div><?php }?>
                        <div style="clear:both;"></div>
                        
                      <ul class="social social-icons-footer-bottom">
                      <?php
                    if($vals->facebook=='Y' && ADMIN_FACEBOOK!='')
					{
					?>
                           <li class="facebook"><a title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="Facebook" href="<?php echo ADMIN_FACEBOOK;?>" target="_blank"><i class="icon-facebook"></i></a></li><?php }?>
                           <?php
                    if($vals->twitter=='Y' && ADMIN_TWITTER!='')
					{
					?>
                           <li class="twitter"><a title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="Twitter" href="<?php echo ADMIN_TWITTER;?>" target="_blank"><i class="icon-twitter"></i></a></li><?php }?>
                           <?php
                    if($vals->pinterest=='Y' && ADMIN_PINTEREST!='')
					{
					?>
                           <li class="dribbble"><a title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="Dribble" href="<?php echo ADMIN_PINTEREST;?>" target="_blank"><i class="icon-dribbble"></i></a></li><?php }?>
                           <?php
                    if($vals->linkedin=='Y' && ADMIN_LINKEDIN!='')
					{
					?>
                           <li class="linkedin"><a title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="LinkedIn" href="<?php echo ADMIN_LINKEDIN;?>" target="_blank"><i class="icon-linkedin"></i></a></li><?php }?>
                           
                        </ul>
                        <?php
					}
						?>
                    </div>
                    <?php }?>
                </div>
<div style="clear:both;"></div>
<?php 
  
  if(isset($ad_page)){ 
  		$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"F"));
		if($type=='A') 
		{
			$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"F"));	
		}
		else
		{
			$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"F"));
	   $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"F"));	
		}
        
      if($type=='A'&& $code!=""){ 
?>
<div class="addbox2">
 <?php 
   echo $code;
 ?>
</div>                      
<?php                      
      }
	  elseif($type=='B'&& $image!="")
	  {
		?>
        <div class="addbox2">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
	}
  }

?>               

                
            </div>

<div style="clear:both;"></div>

                </div>
               </div>
            </div>
            <!-- Footer Top End --> 
            <!-- Footer Bottom Start -->
            <div class="footer-bottom">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6  textcol"><?php echo $footer_text; ?></div>
                     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 col-md-6text textcol">
                     Designed & Developed by : <a href="#">Scriptgiant.com</a>
                        <!-- <ul class="social social-icons-footer-bottom">
                           <li class="facebook"><a href="#" data-toggle="tooltip" title="Facebook"><i class="icon-facebook"></i></a></li>
                           <li class="twitter"><a href="#" data-toggle="tooltip" title="Twitter"><i class="icon-twitter"></i></a></li>
                           <li class="dribbble"><a href="#" data-toggle="tooltip" title="Dribble"><i class="icon-dribbble"></i></a></li>
                           <li class="linkedin"><a href="#" data-toggle="tooltip" title="LinkedIn"><i class="icon-linkedin"></i></a></li>
                           <li class="rss"><a href="#" data-toggle="tooltip" title="Rss"><i class="icon-rss"></i></a></li>
                        </ul>--> 
                     </div>
                  </div>
               </div>
            </div>
            <!-- Footer Bottom End --> 
         </footer>
         <!-- Scroll To Top --> 
         <a href="#" class="scrollup"><i class="icon-angle-up"></i></a>
      </div>
     <!-- Wrap End -->
      
      
      <script src="<?=JS?>bootstrap.js"></script>
      <script>
jQuery(document).ready(function(){
    setInterval(function(){
		var dataString = '';
	 	 jQuery.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo base_url();?>dashboard/getNotificationcount/",
		 success:function(return_data)
		 {
			//alert(return_data);
			if(return_data>0)
			{
			jQuery('.count_list').html('');
			jQuery('.count_list').html(return_data);
			jQuery('.count_list').show();
			}
		 }
		});
	}, 3000);
	setTimeout(function(){
		var matches=[];
		 $('input[name^="notif_id"]').each(function() {
		matches.push($(this).val());
		});
	var dataString = 'notifid='+matches;
	 	 jQuery.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo base_url();?>dashboard/updatenotification/",
		 success:function(return_data)
		 {
			//alert(return_data);
			if(return_data>0)
			{
				jQuery('.notifbox').removeClass('notif_active');
			}
		 }
		});
		
	}, 6000);
	
});
</script> 
      <?php
      if($current_page=='jobdetails')
	  {
	  ?>
      <script type="text/javascript" src="<?php echo ASSETS;?>js/new_ajaxfileupload.js"></script>
      <?php
	  }
	  ?>
      
      <?php
      if($current_page=='dashboard' || $current_page=="talentdetails")
	  {
	  ?>
      
      	<script src="<?php echo VPATH?>assets/js/mootools-1.2.1-core-yc.js" type="text/javascript"></script>
		<script src="<?php echo VPATH?>assets/js/mootools-1.2-more.js" type="text/javascript"></script>
		<script src="<?php echo VPATH?>assets/js/jd.gallery.js" type="text/javascript"></script>
		<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($('myGallery'), {
					timed: true
				});
			}
			window.addEvent('domready',startGallery);
		</script>
        
        <?php
		}
		if($current_page=='editprofile_professional' || $current_page=='postjob' || $current_page=='editportfolio' || $current_page=='addportfolio')
		{
		?>
        <script type="text/javascript" src="<?php echo JS;?>jquery.js"></script>
	  <script type="text/javascript" src="<?php echo JS;?>ajaxfileupload.js"></script>
        <?php
		}
      ?>
      
      <script src="<?=JS?>jquery.parallax.js"></script> 
      <script src="<?=JS?>modernizr-2.6.2.min.js"></script> 
      <script src="<?=JS?>revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
      <script src="<?=JS?>jquery.nivo.slider.pack.js"></script>
      <script src="<?=JS?>jquery.prettyPhoto.js"></script>
      <script src="<?=JS?>superfish.js"></script>
      <!--<script src="<?=JS?>tweetMachine.js"></script>-->
      <script src="<?=JS?>tytabs.js"></script>
      <script src="<?=JS?>jquery.gmap.min.js"></script>
      <script src="<?=JS?>circularnav.js"></script>
      <script src="<?=JS?>jquery.sticky.js"></script>
      <script src="<?=JS?>imagesloaded.pkgd.min.js"></script>
      <script src="<?=JS?>jflickrfeed.js"></script>
      <script src="<?=JS?>waypoints.min.js"></script>
      <script src="<?=JS?>spectrum.js"></script>
      <script src="<?=JS?>switcher.js"></script>
      <script src="<?=JS?>custom.js"></script>
      <link rel="stylesheet" href="<?php echo ASSETS;?>jquery/jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">


	<script src="<?php echo ASSETS;?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>

	<script src="<?php echo ASSETS;?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>

	<script src="<?php echo ASSETS;?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>

	<link rel="stylesheet" href="<?php echo ASSETS;?>css/form-field-tooltip.css" media="screen" type="text/css">
	<script type="text/javascript" src="<?php echo ASSETS;?>js/rounded-corners.js"></script>
	<script type="text/javascript" src="<?php echo ASSETS;?>js/form-field-tooltip.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS;?>css/jquery.bxslider.css" />
<script src="<?php echo ASSETS;?>js/jquery.bxslider.js"></script>       
        
 <script>

	$(function() {

		$( "#datepicker_from" ).datepicker({

			maxDate: new Date(),
			
			showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});

	$(function() {

		$( "#datepicker_to" ).datepicker({

			showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});
	
	$(function() {

		$( "#dep_date" ).datepicker({

			maxDate: new Date(),
			
			showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});
	
	$(function() {

		$( ".mdt" ).datepicker({
			
			minDate: new Date(),
			
			showOn: "button",

			buttonImage: "<?php echo ASSETS;?>images/caln.png",

			buttonImageOnly: true

		});

	});
	
	function getSubscription(){ 
	     if($("#sub_email").val()==""){ 
		   $("#subs_error").show();
		 }
		 else{ 
			 var dataString = 'email='+$("#sub_email").val();
			 
			  $.ajax({
				 type:"POST",
				 data:dataString,
				 url:"<?php echo VPATH;?>user/newsletterSubscription",
				 success:function(return_data){
					  if(return_data== '1'){
						$("#subs_error").text("Thank you. Your newsletter subscription is successful.");  
						$("#subs_error").css("color","#FFFFFF");
						$("#subs_error").show();
						$("#sub_email").val('');
					  }
					  else if(return_data== '2'){ 
						$("#subs_error").text("Sorry..! Unable to process your request.");  
						$("#subs_error").show();					  
					  }
					  else if(return_data== '3'){ 
						$("#subs_error").text("Sorry..! This Email Id already exist.");  
						$("#subs_error").show();					  
					  }
					  else{ 
    					  $("#subs_error").show();	
					  }
				 }
			  });		   
		   
		   
		 }
	  }
	
	$('.bxslider').bxSlider({
	  minSlides: 5,
	  maxSlides: 10,
	  slideWidth: 360,
	  slideMargin: 10,
	   auto: true,
	 
	});
	</script>
        
<script type="text/javascript">
    var tooltipObj = new DHTMLgoodies_formTooltip();
    tooltipObj.setTooltipPosition('right');
    tooltipObj.setPageBgColor('#EEEEEE');
    tooltipObj.setTooltipCornerSize(15);
    tooltipObj.initFormFieldTooltip();
</script>        
<div id="fb-root"></div>

   <script type="text/javascript">
  window.fbAsyncInit = function() {
	  //Initiallize the facebook using the facebook javascript sdk
     FB.init({ 
       appId:'<?php echo YOUR_APP_ID; ?>', // App ID 
	   cookie:true, // enable cookies to allow the server to access the session
       status:true, // check login status
	   xfbml:true, // parse XFBML
	   oauth : true //enable Oauth 
     });
   };
   //Read the baseurl from the config.php file
   (function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
         }(document));
	//Onclick for fb login
 $('.facebook').click(function(e) {
    FB.login(function(response) {
	  if(response.authResponse) {
		  parent.location ='<?php echo base_url(); ?>login/fblogin'; //redirect uri after closing the facebook popup
	  }
 },{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
});
   </script>        
       
   </body>
</html>