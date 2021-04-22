<!-- Content Start -->
<script type="text/javascript">
    var RecaptchaOptions = {
        theme: 'white'
    };
</script>
<?php echo $breadcrumb; ?>

<script type="text/javascript">

    function registerFormPost() {
        $('.error-msg').html('');
        FormPost('#submit-ckck', "<?=VPATH?>", "<?=VPATH?>signup/check", 'register');
//Recaptcha.reload();
    }

    function checkuname(user) {
        var dataString = 'user=' + user;
        $.ajax({
            type: "POST",
            data: dataString,
            url: "<?php echo VPATH;?>signup/usercheck",
            success: function (return_data) {
                //  alert(return_data);
                if (return_data == 0) {
                    //  alert('run');
                    $("#uisname").show();
                    $("#uisname").text("<?php echo __('signup_error_username_exist', 'This username is already in use, please try another'); ?>");
                    $("#regusername").addClass("error");
                } else {
                    $("#uisname").hide();
                    $("#regusername").removeClass("error");
                    $("#regusername").addClass("success");
                }
            }
        })
    }

    function checkemail(email) {
        var dataString = 'email=' + email;
//	alert(dataString);
        $.ajax({
            type: "POST",
            data: dataString,
            url: "<?php echo VPATH;?>signup/emailcheck",
            success: function (return_data) {
                //alert(return_data);
                if (return_data == 0) {
                    $("#umail").show();
                    $("#umail").text("<?php echo __('signup_error_email_exist', 'This email is already in use, please try another'); ?>");
                    $("#email").addClass("error");
                } else {
                    $("#umail").hide();
                    $("#email").removeClass("error");
                    $("#email").addClass("success");
                }
            }
        })
    }
</script>

<script src="<?= JS ?>mycustom.js"></script>

<div class="profile_right">
    <?php
    if ($this->session->flashdata('log_eror')) {
        ?>
        <div class="error-msg5 error alert-error alert"><?php echo $this->session->flashdata('log_eror'); ?></div>
        <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('refer_succ_msg')) {
        ?>
        <div class="success alert-success alert"><?php echo $this->session->flashdata('refer_succ_msg'); ?></div>
        <?php
    }
    ?>
    <?php
    $attributes = array('id' => 'logform', 'class' => 'reply', 'role' => 'form', 'name' => 'logform', 'onsubmit' => "disable");
    echo form_open('', $attributes);
    ?>
    <span id="agree_termsError" class="error-msg5 error alert-error alert" style="display:none"></span>
    <?php
    if (DEMO == 'Y') {
        $username = "pritamnath@originatesoft.com";
        $password = "123456";
    } else {
        $username = "";
        if (set_value('username')) {
            $username = set_value('username');
        }
        $password = "";
    }
    ?>
    <!--LoginLeft Start-->

    <div class="editprofile" id="login_div2" style="display:none;">

        <div class="signupForm">
            <a class="facebook facebott" style="cursor: pointer;" href="javascript:void(0)"><img title="" alt=""
                                                                                                 src="<?php echo ASSETS; ?>images/facebott.png"></a>
            <a class="linkedbott" style="cursor: pointer;" href="<?php echo VPATH; ?>linkedin_signup/initiate"><img
                        title="" alt="" src="<?php echo ASSETS; ?>images/linkedbott.png"></a>
            <div class="orboxline"><h2>or</h2></div>
            <input type="hidden" name="refer" value="<?php echo $refer; ?>" readonly="readonly"/>
            <div class="login_form"><p>User Name/Email:
                    <span>*</span></p><input class="loginput6" id="username" name="username" type="text"
                                             value="<?php echo $username; ?>"
                                             tooltipText="Enter Your Name or Email Id"/>

                <span id="usernameError" class="error-msg13"></span></div>

            <div class="login_form"><p>Password:
                    <span>*</span></p><input class="loginput6" id="password" name="password" type="password"
                                             value="<?php echo $password; ?>" tooltipText="Enter Your Valid Password"/>

                <span id="passwordError" class="error-msg13"></span></div>

            <div class="login_form"><input type="button" value="Login" onclick="loginFormPost()" id="submit-check"
                                           class="btn-normal btn-color submit  bottom-pad">
                <?php
                if (DEMO == 'N') {
                    ?>
                    <a href="<?php echo VPATH; ?>forgot_pass"> Forgot Password ?</a>
                    <?php
                }
                ?>
            </div>
            <div style="clear:both; height:15px;"></div>
        </div>
        </form>
        <!--LoginRight Start-->
        <div id="work_hire_1"><h2>Welcome to efluence<br/>
                <span>The World's Leading Site for Online Advertising</span></h2>
            <div class="logimg"><img title="" alt="" src="<?php echo ASSETS; ?>images/logbg_right.png"></div>
        </div>
        <!--LoginRight End-->


    </div>

</div>


<!--ProfileRight Start-->
<div class="profile_right" style="margin-top:0px !important;">
    <div class="success alert-success alert" style="display:none"></div>

    <!--<h1>
    <a class="selected" href="javascript:void(0)" onclick="showdiv('s')">Sign Up</a>
    </h1>-->

    <!--EditProfile Start-->


    <div id="signupForm" style="display:none">

        <section class="sec">
            <div class="container">
                <div class="row">
                    <aside class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12" data-effect="slide-top">

                        <div class="success alert-success alert" style="display:none"></div>

                        <h3 class="form-title"
                            style="margin:0"><?php echo __('signup_create_your_account', 'Create Your Account') ?></h3>
                        <div class="general-form" style="margin-top:25px; padding-top:25px">
                            <!--<form class="form-horizontal" id="signUpForm">-->
                            <?php $attributes = array('id' => 'register', 'class' => 'form-horizontal', 'role' => 'form', 'name' => 'register', 'onsubmit' => "registerFormPost();return false;");
                            echo form_open('', $attributes);
                            ?>
                            <div class="form-group">
                                <div class="col-sm-6 col-xs-12">
                                    <!--            	<label for="" class="control-label">-->
                                    <?php //echo __('signup_first_name','First Name'); ?><!--</label>            	-->
                                    <input type="text" class="form-control" value="<?php echo set_value('fname'); ?>"
                                           placeholder="First Name" id="fname" name="fname">
                                    <span id="fnameError" class="error-msg13"></span>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <!--            	<label for="" class="control-label">-->
                                    <?php //echo __('signup_last_name','Last Name'); ?><!--</label>            	-->
                                    <input type="text" class="form-control" value="<?php echo set_value('lname'); ?>"
                                           placeholder="Last Name" id="lname" name="lname">
                                    <span id="lnameError" class="error-msg13"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <!--            	<label for="" class="control-label">-->
                                    <?php //echo __('signup_username','Username'); ?><!--:</label>            	-->
                                    <input type="text" class="form-control"
                                           value="<?php echo set_value('regusername'); ?>" placeholder="Username"
                                           id="regusername" name="regusername" onblur="checkuname(this.value)">
                                    <span id="uisname" style="display:none;" class="errormsg13 rerror"></span>
                                    <span id="regusernameError" class="error-msg13"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <!--            	<label for="" class="control-label">-->
                                    <?php //echo __('signup_email_id','Email ID'); ?><!--:</label>            	-->
                                    <input type="email" class="form-control" value="<?php echo set_value('email'); ?>"
                                           placeholder="Email ID" id="email" name="email"
                                           onblur="checkemail(this.value)">
                                    <span id="umail" style="display:none;" class="errormsg13 rerror"></span>
                                    <span id="emailError" class="error-msg13"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <!--            	<label for="" class="control-label">-->
                                    <?php //echo __('signup_conf_email_id','Confirm Email ID'); ?><!--:</label>            	-->
                                    <input type="email" class="form-control" value="" id="cnfemail"
                                           placeholder="Confirm Email ID" name="cnfemail">
                                    <span id="cnfemailError" class="error-msg13"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <!--            	<label for="" class="control-label">-->
                                    <?php //echo __('signup_password','Password'); ?><!--:</label>            	-->
                                    <input type="password" class="form-control" value="" id="regpassword"
                                           placeholder="Password" name="regpassword">
                                    <span id="regpasswordError" class="error-msg13"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <!--            	<label for="" class="control-label">-->
                                    <?php //echo __('signup_conf_password','Confirm Password'); ?><!--:</label>            	-->
                                    <input type="password" class="form-control" value="" id="cpassword"
                                           placeholder="Confirm Password" name="cpassword">
                                    <span id="cpasswordError" class="error-msg13"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="" class="control-label"><?php echo __('signup_country', 'Country'); ?>
                                        :</label>
                                    <select class="form-control" id="country" name="country"
                                            onchange="citylist(this.value)">
                                        <option>--Select Country--</option>
                                        <?php foreach ($country_list as $k => $v) { ?>
                                            <option value="<?php echo $v['code']; ?>"><?php echo $v['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span id="countryError" class="error-msg13"></span>
                                </div>

                                <div class="col-xs-6">
                                    <label for="" class="control-label">City:</label>
                                    <select class="form-control" id="city" name="city">
                                        <option> --<?php echo __('signup_select_city', 'Select City') ?>--</option>
                                    </select>
                                    <span id="cityError" class="error-msg13"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="checkbox checkbox-inline">
                                        <input class="magic-checkbox" type="checkbox" name="termsandcondition" value="Y"
                                               id="termsandcondition">
                                        <label for="termsandcondition" style="display:inline">
                                            <?php echo __('signup_tc_conf', 'By registering as a freelancer, you accept the') ?>
                                            <a href="<?php echo VPATH; ?>information/info/terms_condition"
                                               target="_blank"><?php echo __('signup_terms_&_conditions', 'Terms & Conditions') ?></a>
                                            &amp;
                                            <a href="<?php echo VPATH; ?>information/info/privacy_policy"
                                               target="_blank"><?php echo __('signup_privecy_policy', 'Privacy Policy'); ?></a>
                                            <?php echo __('signup_tc_conf_end', 'of efluencer; and that you will be working as a 1099 employee (USA) and will file taxes on your own.') ?>
                                        </label>
                                    </div>
                                    <br/>
                                    <span id="termsandconditionError" class="error-msg13 rerror"></span>
                                </div>
                            </div>
                            <div class="flex-center">
                                <button type="submit" id="submit-ckck"
                                        class="btn btn-site btn-block"><?php echo __('signup_register', 'Register'); ?></button>
                            </div>
                            <input type="hidden" name="account_type" id="account_type" value="freelancer"/>
                            <!--<input type="submit" class="btn btn-site btn-block">-->
                            </form>

                            <div class="text-center">
                                <!--login through g+ and facebook-->
                                <img id="login-button" disabled
                                     src="<?php echo base_url(); ?>assets/images/sign-in-with-google.png" alt=""
                                     style="width: 35%; margin-top: 20px; display: none"/>
                            </div>
                        </div>
                    </aside>


                </div>
            </div>
        </section>

        <!--SingupLeft End-->

    </div>
    <?php $this->load->view('google_login'); ?>
    <div class="clearfix"></div>
    <!--SingupRight Start-->
    <?php /*?><div class="rightlogin" style="width:100%;">
<div class="signtext"><h2>How it works for employer</h2>
<div class="logimg"><img title="" alt="" src="<?php echo ASSETS;?>images/postright_bg2.png"></div>
<div class="signbuttons"><button type="button" id="freelancer" class="btn-normal btn-color submit  bottom-pad" value="employee" onclick="setAccountType(this.value)">HIRE</button></div>
</div>


<div class="signtext"><h2>How it works for Freelancer</h2>
<div class="logimg"><img title="" alt="" src="<?php echo ASSETS;?>images/works_freelancerbg.png"></div>
<div class="signbuttons"><button type="button" id="freelancer" class="btn-normal btn-color submit  bottom-pad" value="freelancer" onclick="setAccountType(this.value)">WORK</button></div>
</div>

</div><?php */ ?>


    <section class="sec signup hidden-xs" id="work_hire">
        <div class="container">
            <div class="row">
                <aside class="col-sm-6 col-xs-12" data-effect="slide-left">
                    <div class="for-employer">
                        <h3><?php echo __('signup_how_it_works_for_employer', 'How it works for employer'); ?></h3>
                        <div class="row">
                            <article class="col-sm-5 col-xs-12">
                                <img src="<?php echo VPATH; ?>assets/images/post-jobs.png" alt="">
                                <h5><a href="javascript:void(0);"><?php echo __('signup_post_job', 'Post Jobs'); ?></a>
                                </h5>
                            </article>
                            <article class="col-sm-5 col-xs-12 pull-right">
                                <img src="<?php echo VPATH; ?>assets/images/manage-bids.png" alt="">
                                <h5><a href="#"><?php echo __('signup_manage_bids', 'Manage Bids'); ?></a></h5>
                            </article>
                            <div class="clearfix"></div>
                            <a href="JavaScript:Void(0);" class="btn btn-site" id="employee" value="employee"
                               onclick="setAccountType('E')"><?php echo __('signup_hire', 'Hire'); ?></a>
                            <div class="clearfix"></div>
                            <article class="col-sm-5 col-xs-12">
                                <img src="<?php echo VPATH; ?>assets/images/get-payment.png" alt="">
                                <h5>
                                    <a href="javascript:void(0);"><?php echo __('signup_get_paid', 'Get Payment'); ?></a>
                                </h5>
                            </article>
                            <article class="col-sm-5 col-xs-12 pull-right">
                                <img src="<?php echo VPATH; ?>assets/images/service-provider.png" alt="">
                                <h5>
                                    <a href="javascript:void(0);"><?php echo __('signup_service_provider', 'Service Provider'); ?></a>
                                </h5>
                            </article>
                        </div>

                    </div>
                </aside>

                <aside class="col-sm-6 col-xs-12" data-effect="slide-right">
                    <div class="for-freelancer">
                        <h3><?php echo __('signup_how_it_works_for_freelancer', 'How it works for influencers'); ?></h3>
                        <div class="row">
                            <article class="col-sm-5 col-xs-12">
                                <img src="<?php echo VPATH; ?>assets/images/post-jobs.png" alt="">
                                <h5>
                                    <a href="javascript:void(0);"><?php echo __('signup_search_jobs', 'Search Jobs'); ?></a>
                                </h5>
                            </article>
                            <article class="col-sm-5 col-xs-12 pull-right">
                                <img src="<?php echo VPATH; ?>assets/images/place-bids.png" alt="">
                                <h5><a href="#"><?php echo __('signup_place_bids_on_jobs', 'Place Bid on Jobs'); ?></a>
                                </h5>
                            </article>
                            <div class="clearfix"></div>
                            <a href="JavaScript:Void(0);" class="btn btn-primary" id="freelancer"
                               onclick="setAccountType('F')"><?php echo __('signup_work', 'Work'); ?></a>
                            <div class="clearfix"></div>
                            <article class="col-sm-5 col-xs-12">
                                <img src="<?php echo VPATH; ?>assets/images/get-payment-02.png" alt="">
                                <h5>
                                    <a href="JavaScript:Void(0);"><?php echo __('signup_get_paid', 'Get Payment'); ?></a>
                                </h5>
                            </article>
                            <article class="col-sm-5 col-xs-12 pull-right">
                                <img src="<?php echo VPATH; ?>assets/images/worker.png" alt="">
                                <h5>
                                    <a href="JavaScript:Void(0);"><?php echo __('signup_do_work_for_employer', 'Do Work for Employer'); ?></a>
                                </h5>
                            </article>
                        </div>

                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="sec signup hidden-sm hidden-md hidden-lg" id="work_hireMobile">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                                                      data-toggle="tab"><?php echo __('signup_employer', 'Employer'); ?></a>
            </li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                       data-toggle="tab"><?php echo __('signup_freelancer', 'Freelancer'); ?></a></li>
        </ul>
        <div class="container">

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="row">
                        <aside class="col-sm-6 col-xs-12" style="background-color: #2C597A;">
                            <div class="for-employer">
                                <h3><?php echo __('signup_how_it_works_for_employer', 'How it works for a business'); ?></h3>
                                <div class="row">
                                    <article class="col-sm-5 col-xs-12">
                                        <img src="<?php echo VPATH; ?>assets/images/post-jobs.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_post_job', 'Post Jobs'); ?></a>
                                        </h5>
                                    </article>
                                    <article class="col-sm-5 col-xs-12 pull-right">
                                        <img src="<?php echo VPATH; ?>assets/images/manage-bids.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_manage_bids', 'Manage Bids'); ?></a>
                                        </h5>
                                    </article>
                                    <div class="clearfix"></div>
                                    <a href="JavaScript:Void(0);" class="btn btn-site" id="employee" value="employee"
                                       onclick="setAccountType('E')">Hire</a>
                                    <div class="clearfix"></div>
                                    <article class="col-sm-5 col-xs-12">
                                        <img src="<?php echo VPATH; ?>assets/images/get-payment.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_get_paid', 'Get Payment'); ?></a>
                                        </h5>
                                    </article>
                                    <article class="col-sm-5 col-xs-12 pull-right">
                                        <img src="<?php echo VPATH; ?>assets/images/service-provider.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_service_provider', 'Service Provider'); ?></a>
                                        </h5>
                                    </article>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
                    <div class="row">
                        <aside class="col-sm-6 col-xs-12" style="background-color: #29b6f6;">
                            <div class="for-freelancer">
                                <h3><?php echo __('signup_how_it_works_for_freelancer', 'How it works for an influencer'); ?></h3>
                                <div class="row">
                                    <article class="col-sm-5 col-xs-12">
                                        <img src="<?php echo VPATH; ?>assets/images/post-jobs.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_search_jobs', 'Search Jobs'); ?></a>
                                        </h5>
                                    </article>
                                    <article class="col-sm-5 col-xs-12 pull-right">
                                        <img src="<?php echo VPATH; ?>assets/images/place-bids.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_place_bids_on_jobs', 'Place Bid on Jobs'); ?></a>
                                        </h5>
                                    </article>
                                    <div class="clearfix"></div>
                                    <a href="JavaScript:Void(0);" class="btn btn-primary" id="freelancer"
                                       onclick="setAccountType('F')">Work</a>
                                    <div class="clearfix"></div>
                                    <article class="col-sm-5 col-xs-12">
                                        <img src="<?php echo VPATH; ?>assets/images/get-payment-02.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_get_paid', 'Get Payment'); ?></a>
                                        </h5>
                                    </article>
                                    <article class="col-sm-5 col-xs-12 pull-right">
                                        <img src="<?php echo VPATH; ?>assets/images/worker.png" alt="">
                                        <h5>
                                            <a href="JavaScript:Void(0);"><?php echo __('signup_do_work_for_employer', 'Do Work for Employer'); ?></a>
                                        </h5>
                                    </article>
                                </div>

                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>

    <!--ProfileRight Start-->
    <div class="clearfix"></div>
    <?php

    if (isset($ad_page)) {
        $type = $this->auto_model->getFeild("type", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
        if ($type == 'A') {
            $code = $this->auto_model->getFeild("advertise_code", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
        } else {
            $image = $this->auto_model->getFeild("banner_image", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
            $url = $this->auto_model->getFeild("banner_url", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
        }

        if ($type == 'A' && $code != "") {
            ?>
            <div class="addbox2">
                <?php
                echo $code;
                ?>
            </div>
            <?php
        } elseif ($type == 'B' && $image != "") {
            ?>
            <div class="addbox2">
                <a href="<?php echo $url; ?>" target="_blank"><img src="<?= ASSETS ?>ad_image/<?php echo $image; ?>"
                                                                   alt="" title=""/></a>
            </div>
            <?php
        }
    }

    ?>
    <div class="clearfix"></div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#register').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },

            fields: {
                fname: {
                    row: '.col-xs-12',
                    validators: {
                        notEmpty: {
                            message: 'The first name is required'
                        }
                    }
                },
                lname: {
                    row: '.col-xs-12',
                    validators: {
                        notEmpty: {
                            message: 'The last name is required'
                        }
                    }
                },
                regusername: {
                    validators: {
                        notEmpty: {
                            message: 'The username is required'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: 'The username can only consist of alphabetical, number, dot and underscore'
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
                regpassword: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        },

                        different: {
                            field: 'username',
                            message: 'The password cannot be the same as username'
                        },
                        identical: {
                            field: 'confirmPassword',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },


                confirmPassword: {
                    validators: {
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            }
        });

    });

</script>

<script>
    function showState(v) {
        if (v != "Nigeria") {
            $("#state_div").hide();
        } else {
            $("#state_div").show();
        }
    }

    function setAccountType(accounttype) {
        $("#account_type").val(accounttype);
        //alert(accounttype);
        $("#work_hire, #work_hireMobile").hide();
        $("#signupForm").show();
    }

    function citylist(country) {
        var dataString = 'cid=' + country;
        $.ajax({
            type: "POST",
            data: dataString,
            url: "<?php echo base_url();?>login/getcity/" + country,
            success: function (return_data) {
                //alert(return_data);
                $('#city').html('');
                $('#city').html(return_data);
            }
        });
    }


</script>
