<!-- <section class="breadcrumb-classic">
 <div class="container">
  	   <div class="row">
    <aside class="col-sm-6 col-xs-12">
      <h3><?php echo __('contact_us', 'Contact Us'); ?></h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">
        <ol class="breadcrumb pull-right">
      <li><a href="<?php echo base_url(); ?>"><?php echo __('home', 'Home'); ?></a></li>
      <li class="active"><?php echo __('contact', 'Contact'); ?></li>
    </ol>
    </aside>
    </div>
	</div>
</section>-->
<section class="sec sec-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-12 center-element-ma">
                <div class="spacer-20"></div>
                <h2 class="title">Contact Us</h2>
                <div class="" id="contact-form">

                    <p class="text-center"><?php echo __('description1', 'Description'); ?></p>
                    <p class="text-center"><?php echo __('description2', 'Description'); ?></p>
                    <div class="spacer-15"></div>
                  <?php if ($this->session->flashdata('succ_msg')) {

                    ?>
                      <div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg'); ?></div>
                    <?php

                  } elseif ($this->session->flashdata('error_msg')) {


                    echo $this->session->flashdata('error_msg');


                  } ?>
                    <div class="clearfix"></div>
                    <form method="post" class="form-horizontal" action="<?php echo base_url() ?>contact/contact_form"
                          id="contact" name="contact">
                        <fieldset>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" id="subject" name="subject" type="text"
                                           value="<?php echo set_value('subject'); ?>"
                                           placeholder="<?php echo __('subject', 'Subject'); ?> *"
                                           tooltipText="Enter Your Subject"/>
                                  <?php echo form_error('subject', '<div class="error-msg5">', '</div>'); ?> </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <input class="form-control" id="name" name="name" type="text"
                                           value="<?php echo set_value('name'); ?>"
                                           placeholder="<?php echo __('name', 'Name'); ?> *"
                                           tooltiptext="Enter Your Name"/>
                                  <?php echo form_error('name', '<div class="error-msg5">', '</div>'); ?>
                                </div>

                                <div class="col-xs-6">
                                    <input class="form-control" type="email" id="email" name="email"
                                           value="<?php echo set_value('email'); ?>"
                                           placeholder="<?php echo __('email', 'Email'); ?> *"
                                           tooltipText="Enter Your Valid Email Id"/>
                                  <?php echo form_error('email', '<div class="error-msg5">', '</div>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <textarea class="form-control" id="text" name="message" rows="5" cols="40"
                                              placeholder="<?php echo __('message', 'Message'); ?> *"
                                              tooltipText="Enter Your Message"/><?php echo set_value('message'); ?></textarea>
                                  <?php echo form_error('message', '<div class="error-msg5">', '</div>'); ?> </div>
                            </div>
                        </fieldset>
                        <button class="center-block btn btn-site btn-new" type="submit" name="contact" value="contact">
                            Submit
                        </button>
                        <div class="success alert-success alert"
                             style="display:none"><?php echo __('success', 'Your message has been sent successfully'); ?>
                            .
                        </div>
                        <div class="error alert-error alert"
                             style="display:none"><?php echo __('error', 'E-mail must be valid and message must be longer than 100 characters'); ?>
                            .
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <div class="spacer-20"></div>
                    <hr>
                </div>
            </div>
            <!--        -->
            <!--    <aside class="col-md-4 col-sm-6 col-xs-12">-->
            <!--    <h4 class="title-sm">--><?php //echo __('head_office','Head Office'); ?><!--</h4>-->
            <!--      <div class="whiteSec">-->
            <!--        <div class="address">-->
            <!--          <ul class="contact-us">-->
            <!--            <li>-->
            <!--			--><?php //$address = $this->auto_model->getFeild("corporate_address","setting","id",1);?>
            <!--              <p><i class="fa fa-map-marker"></i> <strong>-->
          <?php //echo __('address','Address'); ?><!--:</strong> --><?php //echo $address;?><!-- </p>-->
            <!--            </li>-->
            <!--            <li>-->
            <!--			--><?php //$contact_no = $this->auto_model->getFeild("contact_no","setting","id",1);?>
            <!--              <p><i class="fa fa-phone"></i> <strong>-->
          <?php //echo __('phone','Phone'); ?><!--:</strong> --><?php //echo $contact_no;?><!-- </p>-->
            <!--            </li>-->
            <!--            <li>-->
            <!--			--><?php //$email = $this->auto_model->getFeild("admin_mail","setting","id",1);?>
            <!--              <p><i class="fa fa-envelope"></i> <strong>-->
          <?php //echo __('email','Email'); ?><!--:</strong> <a href="mailto:--><?php //echo $email;?><!--"> -->
          <?php //echo $email;?><!-- </a> </p>-->
            <!--            </li>-->
            <!--          </ul>-->
            <!--        </div>-->
            <!--        <div class="spacer-10"></div>-->
            <!--        <!--<div class="contact-info widget">-->
            <!--           <h3 class="title">Business Hour</h3>-->
            <!--           <ul>-->
            <!--              <li><i class="icon-time"> </i>Monday - Friday 9am to 5pm </li>-->
            <!--              <li><i class="icon-time"> </i>Saturday - 9am to 2pm</li>-->
            <!--              <li><i class="icon-remove-circle"> </i>Sunday - Closed</li>-->
            <!--           </ul>-->
            <!--        </div>-->
            <!---->
            <!--        --><?php
          //
          $popular = $this->auto_model->getalldata('', 'popular', 'id', '1');
          //
          //        ?>
            <!--        <div class="follow">-->
            <!--          <h4 class="title-sm">--><?php //echo __('follow_us','Follow Us'); ?><!--</h4>-->
        </div>
        <div class="row">
            <div class="col-md-6  text-center center-element-ma">

                <ul class="contact-us">
                    <li>
                      <?php $contact_no = $this->auto_model->getFeild("contact_no", "setting", "id", 1); ?>
                        <p><i class="fa fa-phone"></i> <strong><?php echo __('phone', 'Phone'); ?>
                                :</strong> <?php echo $contact_no; ?> </p>
                    </li>
                    <li>
                      <?php $email = $this->auto_model->getFeild("admin_mail", "setting", "id", 1); ?>
                        <p><i class="fa fa-envelope"></i> <strong><?php echo __('email', 'Email'); ?>:</strong> <a
                                    href="mailto:<?php echo $email; ?>"> <?php echo $email; ?> </a></p>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6 text-center center-element-ma">

                <ul class="social-icons icons-A icon-circle">
                  <?php

                  foreach ($popular as $vals) {

                    ?>
                    <?php

                    if ($vals->facebook == 'Y' && ADMIN_FACEBOOK != '') {

                      ?>
                        <li><a href="<?php echo ADMIN_FACEBOOK; ?>" target="_blank"><i
                                        class="zmdi zmdi-facebook"></i></a></li>
                    <?php } ?>
                    <?php

                    if ($vals->twitter == 'Y' && ADMIN_TWITTER != '') {

                      ?>
                        <li><a class="twitter" href="<?php echo ADMIN_TWITTER; ?>" target="_blank"><i
                                        class="zmdi zmdi-twitter"></i></a></li>
                    <?php } ?>
                    <?php

                    if ($vals->pinterest == 'Y' && ADMIN_PINTEREST != '') {

                      ?>
                        <li><a class="dribbble" href="<?php echo ADMIN_PINTEREST; ?>" target="_blank"><i
                                        class="zmdi zmdi-dribbble"></i></a></li>
                    <?php } ?>
                    <?php

                    if ($vals->rss == 'Y' && ADMIN_RSS != '') {

                      ?>
                        <li><a class="rss" href="<?php echo ADMIN_RSS; ?>" target="_blank"><i class="zmdi zmdi-rss"></i></a>
                        </li>
                    <?php } ?>
                    <?php

                    if ($vals->linkedin == 'Y' && ADMIN_LINKEDIN != '') {

                      ?>
                        <li><a class="linkedin" href="<?php echo ADMIN_LINKEDIN; ?>" target="_blank"><i
                                        class="zmdi zmdi-linkedin"></i></a></li>
                    <?php } ?>
                    <?php
                  }
                  ?>
                </ul>
            </div>
        </div>
        <!--        </div>-->
        <!--      </div>-->
        <!--    </aside>-->
        <!--    </div>-->
        <div class="spacer-20"></div>
        <!---->
        <!--    <div class="row">-->
        <!--      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
        <!--        <h4 class="title-sm">--><?php //echo __('our_location','Our Location'); ?><!--</h4>-->
        <!--        --><?php //$map = $this->auto_model->getFeild("map","setting","id",1);?>
        <!--        <div id="maps" class="google-maps">--><?php //echo html_entity_decode($map);?><!-- </div>-->
        <!---->
        <!--      </div>-->
        <!--    </div>-->


</section>
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
      <div class="addbox2"><a href="<?php echo $url; ?>" target="_blank"><img
                      src="<?= ASSETS ?>ad_image/<?php echo $image; ?>" alt="" title=""/></a></div>
    <?php

  }

}

?>
<div class="clearfix"></div>
