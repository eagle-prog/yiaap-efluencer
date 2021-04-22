<?php echo $breadcrumb;?>
<script type="text/javascript">

function loginFormPost(){

FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>forgot_pass/resetpass",'register');

}

</script><script src="<?=JS?>mycustom.js"></script> 
         
<div class="clearfix"></div>
<section class="sec">
<div class="container">
<div class="row">
	<aside class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-12">
      
      
      <div class="success alert-success alert" style="display:none; position: absolute;"> </div>
      <?php

		$attributes = array('id' => 'register','class' => 'form-horizontal','role'=>'form','name'=>'register','onsubmit'=>"disable");

		echo form_open('', $attributes);

		?>
      <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>
      
      <h3 class="form-title"><?php echo __('forgotpass_reset_password','Reset Password'); ?></h3>
      <div class="general-form text-center">
        <div class="img-circle">
        	<img src="<?php echo IMAGE;?>key.png" alt="">
        </div>
          <div class="form-group">        	
        	<div class="col-xs-12">	                    
                <input type="hidden" name="uid" value="<?php echo $user_id?>" readonly/>
                <label class="control-label"><?php echo __('forgotpass_enter_new_password','Enter New Password'); ?>: <span>*</span></label>
                <input class="form-control" id="user_pass" name="user_pass" type="password" value="<?php echo set_value('user_pass');?>" required />
                <span id="user_passError" class="rerror"></span>
            </div>
          </div>
          
          <div class="form-group">        	
        	<div class="col-xs-12">
            <label class="control-label"><?php echo __('forgotpass_confirm_new_password','Confirm New Password'); ?>: <span>*</span></label>
            <input class="form-control" id="conf_pass" name="conf_pass" type="password" value="<?php echo set_value('conf_pass');?>" required />
            <span id="conf_passError" class="rerror"></span> 
          </div>
          </div>              
          <button type="button" class="btn btn-site btn-block" id="submit-check" onclick="loginFormPost()"><?php echo __('forgotpass_submit','Submit'); ?></button>  
	  </div>
      </form>
      
        
    </aside>
</div>
</div>  
</section>

<div class="clearfix"></div>

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
<div class="clearfix"></div>
