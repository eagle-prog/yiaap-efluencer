<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?2Rzam8ZNPz6rZ3NyzlMnYE4R27s4alZK';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->



<body class="home">
      <div class="wrap">
         <!-- Header Start -->
         <header id="header">
            <!-- Header Top Bar Start -->
            
            <!-- Header Top Bar End -->
            <!-- Main Header Start -->
            <div class="main-header">
               <div class="container">
                  <!-- TopNav Start -->
                  
                  <!-- TopNav End -->
                  <!-- Logo Start -->
<!--<div class="logo pull-left">
                     <h1>
                        <a href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>">
                        <img src="<?=ASSETS?>img/logo.png" alt="pixma" width="125" height="60">
                        </a>
                     </h1>
                  </div>-->
                  <!-- Logo End -->
                  
                  <div class="logo">                                                  
                        <a href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>">
                        <img src="<?=ASSETS?>img/<?php echo SITE_LOGO;?>" style="max-height:44px; max-width:225px">
                        </a>
                   </div>
                  <!-- Mobile Menu Start -->
                  
                  <div class="mobile navbar-header">
                     <a class="navbar-toggle" data-toggle="collapse" data-target=".menu">
                     <i class="icon-reorder icon-2x"></i>
                     </a> 
                  </div>
                  <!-- Mobile Menu End -->
                  <!-- Menu Start -->
                  <nav class="collapse navbar-collapse menu">
                     <ul class="nav navbar-nav sf-menu">
                       <li>
                           <?php 
                            if(!$this->session->userdata('user')){ 
                           ?>
                            <!--<a  href="<?php echo VPATH?>dashboard" <? if($current_page=="dashboard"){?>id="current"<? }?>>DASHBOARD</a>-->
                             <a  href="<?=VPATH?>" <? if($current_page=="home"){?>id="current"<? }?>>HOME</a>
                           <?php 
                            }                           
                           ?> 
                            
                           
                        </li> 
                        <li>
                         <a href="<?=VPATH?>information/info/about_us/" <? if($current_page=="about_us"){?>id="current"<? }?>>ABOUT US</a>
                        </li>

                        <li>
                        <?php
                        if($this->session->userdata('user'))
						{
						?>
                         <a href="<?=VPATH?>postjob/" <? if($current_page=="postjob"){?> id="current" <? }?>>POST JOB</a>
                         <?php
						}
						else
						{
						?>
                        <a href="<?=VPATH?>login?refer=postjob/" <? if($current_page=="postjob"){?> id="current" <? }?>>POST JOB</a>
                        <?php	
						}
						 ?>
                        </li>

                        <li>
                        <a href="<?=VPATH?>findtalents/" <? if($current_page=="findtalent"){?>id="current"<? }?>>FIND FREELANCER</a>
                        </li>
                       
                       <li><a href="<?=VPATH?>findjob/" <? if($current_page=="findjob"){?>id="current"<? }?>>FIND JOBS</a></li>
                        <li><a href="<?php echo VPATH;?>knowledgebase/" <? if($current_page=="knowledge_base"){?>id="current"<? }?>>SUCCESS TIPS

</a></li>
						<li><a href="<?php echo VPATH;?>support/" target="_blank" <? if($current_page=="support"){?>id="current"<? }?>>HELP

</a></li>
<?php
 if(!$this->session->userdata('user'))
 {
 ?>
  <li><a href="<?=VPATH?>signup/" <? if($current_page=="signup"){?>id="current"<? }?>> 
                       REGISTER</a></li>
  <li><a href="<?=VPATH?>login/" <? if($current_page=="login"){?>id="current"<? }?>> 
                       LOGIN</a></li>
<?php
}
else
{
?>	
 <li><a href="<?=VPATH?>dashboard/" <? if($current_page=="dashboard"){?>id="current"<? }?>>DASHBOARD</a></li>
<li><a href="<?=VPATH?>user/logout/" <? if($current_page=="logout"){?>id="current"<? }?>>LOGOUT</a></li>

<?php
}
?>					 
                     </ul>                     
                     
                  </nav>
                  <!-- Menu End --> 
                   <!--Newtab-->
                   
 <!--Login Section-->      
 <!--<div class="login-section">
<div class="nav_area_rht">
<a href="#" onClick="postjob_fn()" id="post_job">Post a Job<img src="<?=ASSETS?>images/dn_aro.png" align="right" class="aro_img" /></a>
 <?php
 if(!$this->session->userdata('user'))
 {
 ?>       
<a href="#" onClick="login_fn()" id="login"><span style="color:#000;">Log In</span> / Sign Up<img src="<?=ASSETS?>images/dn_aro.png" align="right" class="aro_img" /></a>
<?php
}
else
{
?>
<a href="<?=VPATH?>dashboard/" >Dashboard</a>
<a href="<?=VPATH?>user/logout/" >Logout</a>
<?php
}
?>
</div>
 <?php
 if($this->session->userdata('user'))
 {
	 $user=$this->session->userdata('user');
	$email=	$user[0]->email; 
}
else
{
	$email="Your email address"	;
}
 ?>       
<div id="post_div" class="logsection" style="display:none;">
<form name="post_frm" method="post" action="<?php echo VPATH;?>npost" onSubmit="return check()">
<div class="logform">
<input type="text" onBlur="if(this.value == '') { this.value = 'What do want to get done?' }" onClick="this.value = ''" value="What do want to get done?" id="title_name" name="title" class="logform-input" title="Please enter your project title" required="">
</div>

<div class="logform">
<input type="text" onBlur="if(this.value == '') { this.value = 'Your email address' }" onClick="if(this.value == 'Your email address') { this.value = '' }" value="<?php echo $email;?>" id="mail" name="mail" class="logform-input" title="Please enter your email address" required>
</div>

<div class="logform">
<input type="submit" value="Lets’ Go" class="logbtn" name="jobpost">
</div>
</form>
</div>

<form name="login_frm" method="post" action="<?php echo VPATH;?>nlogin/check">
<div id="login_div" class="logsection"    <?php if(!$this->session->set_flashdata("error_msg")){ echo "style='display:none;'";}?> >

<a href="<?php echo VPATH;?>login/fblogin/" class="facebott2">
    <img src="<?php echo VPATH;?>assets/images/facebott.png" alt=""  title=""/>
</a>
<a href="<?php echo VPATH;?>linkedin_signup/initiate" class="facebott2">
    <img src="<?php echo VPATH;?>assets/images/linkedbott.png" alt=""  title=""/>
</a>    
    
    
<div style="clear:both;"></div>
<div class="orboxline"><h2>or</h2></div><br />
<div class="logform">
    <input type="text" required onClick="this.value = ''" value="" placeholder="User Name" id="User Name" name="username" class="logform-input" title="Please enter your Username/Email">
</div>

<div class="logform">
<input type="password" required placeholder="Password" value="" name="password" id="password" class="logform-input" title="Please enter your password">
</div>

<div class="logform">
<input type="submit" value="Login" class="logbtn" name="login">
<input type="button" onClick="window.location.href='<?php echo VPATH;?>login'" value="New User ?&nbsp;Signup&nbsp;»" class="logbtn" name="">
<a href='<?php echo VPATH;?>forgot_pass' style="margin-left: 30%;">Forgot Password ?</a>

</div>

</div>
</form>
        
        </div>-->        
 <!--Login Section End-->                   
                   
<?php /*?><ul class="nav_area_rht">
                     <?php
                     if($this->session->userdata('user'))
					 {
					 	
					 	$user=$this->session->userdata('user');
						$user_id=$user[0]->user_id;
						$user_name=$user[0]->username;
						$user_login=$user[0]->ldate;
					 ?>
                     <li><a href="#"> <?php echo $user_name;?>&nbsp;&nbsp;<img alt="" src="http://lab8.oneoutsource.com/icbidding/images/white_arrow.png"></a>
                     <ul class="sub-menu">
                     <li>  
                     <a href="<?=VPATH?>dashboard/" <? if($current_page=="dashboard"){?>id="jbselected"<? }?>> 
                       Dashboard</a></li>
                       <li>
                       <a href="<?=VPATH?>user/logout"> 
                       Logout</a></li>
                      </ul>
                      </li>
                     <?php	
					 }
					 ?>  
                          
</ul><?php */?>
<!--NewTab -->
               </div>
            </div>
            <!-- Main Header End -->
            <script type="text/javascript">stLight.options({publisher: "5a428347-9978-4bd6-b25c-4a3a5d336ba5", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
         </header>
         <!-- Header End --> 
         
<script type="text/javascript">
function postjob_fn(){
	$("#post_div").toggle();
	document.getElementById("login_div").style.display="none";
	}
	
function login_fn(){
	document.getElementById("post_div").style.display="none";
	$("#login_div").toggle();
	}
 
 function check()
 {
	var title=$('#title_name').val();
	var mail=$('#mail').val();
    var atpos = mail.indexOf("@");
    var dotpos = mail.lastIndexOf(".");
    
	if(title=='' || title=='What do want to get done?')
	{
		alert('job title cant be left blank');
		return false;	
	}
	else if(mail=='' || mail=='Your email address')
	{
		alert('email cant be left blank');
		return false;	
	}
	else if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        return false;
    }
	else
	{
		return true; 
	}
}      
   
</script>
