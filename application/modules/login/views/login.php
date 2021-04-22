<!-- Content Start -->
<script type="text/javascript">
  var RecaptchaOptions = {
    theme: 'white'
  };
</script>

<?php echo $breadcrumb; ?>

<script type="text/javascript">

  function loginFormPost() {
//	alert('alert');
    FormPost('#submit-check', "<?=VPATH?>", "<?=VPATH?>login/check", 'logform');

  }
</script>
<script src="<?= JS ?>mycustom.js"></script>
<?php /*
<div class="container min_h">
<div class="row">
  <div class="sidebar col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <!-- Left nav Widget Start -->
    <div class="widget category">

      <!--Log In start-->

      <div class="profile_right">
        <h1> <a href="javascript:void(0)" onclick="showdiv('l')" class="selected" id="alogin">Log In</a> </h1>
        <?php
if($this->session->flashdata('log_eror'))
{
?>
        <span class="error-msg5 error alert-error alert"><?php echo $this->session->flashdata('log_eror');?></span>
        <?php
}
?>
        <?php
if($this->session->flashdata('refer_succ_msg'))
{
?>
        <div class="success alert-success alert"><?php echo $this->session->flashdata('refer_succ_msg');?></div>
        <?php
}
?>
						<?php
							$attributes = array('id' => 'logform','class' => 'reply','role'=>'form','name'=>'logform','onsubmit' =>"loginFormPost();return false;");
							echo form_open('', $attributes);
                              ?>
        <span id="agree_termsError" class="error-msg5 error alert-error alert" style="display:none"></span>
        <?php
if(DEMO=='Y')
{
$username="pritamnath@scriptgiant.com";
$password="123456";
}
else
{
$username="";
if(set_value('username'))
{
    $username=	set_value('username');
}
$password="";
}
?>
        <!--LoginLeft Start-->

        <div class="editprofile" id="login_div2">
          <div class="leftlogin"> <a class="facebook facebott" style="cursor: pointer;" href="javascript:void(0)"><img title="" alt="" src="<?php echo ASSETS;?>images/facebott.png"></a>
            <!--<a class="linkedbott" style="cursor: pointer;" href="<?php echo VPATH;?>linkedin_signup/initiate"><img title="" alt="" src="<?php echo ASSETS;?>images/linkedbott.png"></a>-->

            <div class="orboxline">
              <h2>or</h2>
            </div>
            <input type="hidden" name="refer" value="<?php echo $refer;?>" readonly="readonly"/>
            <div class="login_form">
              <p>User Name/Email: <span>*</span></p>
              <input class="loginput6" id="username" name="username" type="text" value="<?php echo $username;?>" tooltipText="Enter Your Name or Email Id"/>
              <span id="usernameError" class="error-msg13"></span></div>
            <div class="login_form">
              <p>Password: <span>*</span></p>
              <input class="loginput6" id="password" name="password" type="password" value="<?php echo $password;?>" tooltipText="Enter Your Valid Password" />
              <span id="passwordError" class="error-msg13"></span></div>
            <div class="loginfor_right">
              <input type="submit" value="Login" id="submit-check" class="btn-normal btn-color submit  bottom-pad">
              <?php
if(DEMO=='N')
{
?>
              <a href="<?php echo VPATH;?>forgot_pass"> Forgot Password ?</a>
              <?php
}
?>
            </div>
            <div style="clear:both; height:15px;"></div>
          </div>
          </form>
          <!--LoginLeft End-->

          <!--LoginRight Start-->
          <div class="rightlogin">
            <h2>Welcome to Jobbid.org<br />
              <span>The World's Leading Site for Online Work</span></h2>
            <div class="logimg"><img title="" alt="" src="<?php echo ASSETS;?>images/logbg_right.png"></div>
          </div>
          <!--LoginRight End-->

        </div>
      </div>

      <!--Log In End-->

    </div>
    <!-- Left nav Widget End -->
  </div>
  <!-- Sidebar End -->
  <div class="posts-block col-lg-12 col-md-9 col-sm-8 col-xs-12">

    <div style="clear:both;"></div>
    <?php

if(isset($ad_page)){
$type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
if($type=='A')
{
$code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
}
else
{
$image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
$url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
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
    <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
    <?php
}
}

?>
    <div style="clear:both;"></div>
  </div>
  <!-- Left Section End -->
</div>
</div>

<script>
      function showState(v){
          if(v!="Nigeria"){
              $("#state_div").hide();
          }
          else{
            $("#state_div").show();
          }
      }
function citylist(country)
{

	var dataString = 'cid='+country;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>login/getcity/"+country,
     success:function(return_data)
     {
	 	//alert(return_data);
      	$('#city').html('');
		$('#city').html(return_data);
     }
    });
}

function showdiv(v){
  if(v=='s'){
    $("#signup_div").show();
    $("#login_div2").hide();
    $("#asingup").addClass("selected");
    $("#alogin").removeClass("selected");
  }
  else if(v=='l'){
    $("#login_div2").show();
    $("#signup_div").hide();
    $("#alogin").addClass("selected");
    $("#asingup").removeClass("selected");
  }
}
    </script>

 */ ?>
<!--<link rel="stylesheet" href="css/formValidation.css"/>
<script src="js/formValidation.js"></script>
<script src="js/bootstrap.validate.js"></script>-->
<section class="sec sec-login">
    <div class="container">
        <h2 class="title">Sign in</h2>
        <div class="spacer-30"></div>
        <div class="container flex-center">
            <div class="col-md-6 col-sm-6 col-xs-12" data-effect="slide-top">


                <div class="form">
                    <!--        <div class="img-circle">-->
                    <!--        	<img src="--><?php //echo VPATH;?><!--assets/images/lock.png" alt="">-->
                    <!--        </div>-->
                  <?php
                  $attributes = array('id' => 'logform', 'class' => 'form-horizontal', 'role' => 'form', 'name' => 'logform', 'onsubmit' => "loginFormPost(); return false;");
                  echo form_open('', $attributes);
                  ?>
                    <div id="agree_termsError" class="error-msg5 error alert-error alert alert-danger"
                         style="display:none"></div>

                    <input type="hidden" name="refer" value="<?php echo $refer; ?>" readonly="readonly"/>
                    <div class="login-form">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <!--            	<label for="" class="control-label">-->
                              <?php //echo __('login_username','Username'); ?><!-- / -->
                              <?php //echo __('login_email_id','Email ID'); ?><!--:</label>            	-->
                                <input type="text" class="form-control" value="" name="username"
                                       placeholder="Username / Email ID">
                                <span id="usernameError" class="error-msg13"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <!--            	<label for="" class="control-label">-->
                              <?php //echo __('login_password','Password'); ?><!--:</label>            	-->
                                <input type="password" class="form-control" value="" name="password"
                                       placeholder="Password">
                                <span id="passwordError" class="error-msg13"></span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="" class="control-label" style="display:none;">
                                <input type="checkbox"> <?php echo __('login_remember_me', 'Remember Me') ?> </label>

                            <label for="" class="pull-left">
                                <input id="i_agree_terms" name="agree_terms" type="checkbox" checked> By clicking you
                                agree to the <a href="<?php echo base_url() ?>information/info/terms_condition">Terms
                                    and Conditions</a>
                            </label>

                        </div>
                        <div class="spacer-15"></div>
                        <div class="col-xs-12">
                            <a href="<?php echo VPATH; ?>forgot_pass"
                               class="pull-left"><?php echo __('login_forget_passowrd', 'Forgot Password?'); ?></a>
                        </div>
                        <div class="spacer-10"></div>
                    </div>
                    <button id="signin-btn"
                            class="btn btn-site btn-block btn-new"><?php echo __('login_sign_in', 'Sign In'); ?></button>
                    <div class="text-center">
                        <!--login through g+ and facebook-->
                        <img id="login-button" disabled
                             src="<?php echo base_url(); ?>assets/images/sign-in-with-google.png" alt=""
                             style="width: 45%; margin-top: 20px; display: none; pointer: cursor"/>

                        <!--<a href="javascript:void(0);" onclick="facebook_login();">
			<img id="login-button2" disabled src="<?php echo base_url(); ?>assets/images/fb-sign-in-button.png" alt="" style="width: 45%; margin-top: 20px; float: right" />
		</a>-->
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="spacer-30"></div>
</section>
<?php $this->load->view('google_login'); ?>
<div class="clearfix"></div>
<script type="text/javascript">
  /* $(document).ready(function() {
      $('#signInForm').formValidation({
          framework: 'bootstrap',
          icon: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },

          fields: {

              username: {
                  validators: {
                      notEmpty: {
                          message: '<?php echo __('login_username_field_required', 'The username or email id is required'); ?>'
                    },
                    stringLength: {
                        min: 6,
                        max: 20,
                        message: '<?php echo __('The username must be more than 6 and less than 12 characters long', 'The username must be more than 6 and less than 12 characters long'); ?>'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: '<?php echo __('login_username_field_required_alphabetic_number', 'The username can only consist of alphabetical, number, dot and underscore'); ?>'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: '<?php echo __('login_password_required', 'The password is required'); ?>'
                    },

                    different: {
                        field: 'username',
                        message: '<?php echo __('login_password_username_required', 'The password cannot be the same as username'); ?>'
                    },

				}
				},

        }
    });

        // Reset form
        $('#signUpForm').formValidation('resetForm', true);
    });
 */

  function checkAgree() {
    if ($('#i_agree_terms').attr("checked") == "checked") {
      $('#signin-btn').prop("disabled", false);
    } else {
      $('#signin-btn').attr("disabled", true);
    }
  }

  $('#i_agree_terms').change(function () {
    checkAgree();
  });
  checkAgree();
</script>

<?php $this->load->view('facebook_login'); ?>
