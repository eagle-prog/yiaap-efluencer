<!-- Title, Breadcrumb Start-->
<?php echo $breadcrumb;?>
<script type="text/javascript">
function editFormPost(){
FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>dashboard/check",'editprofile');
$(window).scrollTop(20);
}
</script>       
<script src="<?=JS?>mycustom.js"></script>
<section id="mainpage">
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard-left'); ?>
</div> 
<aside class="col-md-10 col-sm-9 col-xs-12">
	<div class="spacer-20"></div>
                        
<div class="profile_right">
<div class="success alert-success alert" style="display:none"><?php echo __('dashboard_editprofile_your_msg_has_been_sent_successfully','Your message has been sent successfully.'); ?> <a class="close" data-dismiss="alert" aria-label="close">×</a></div>
<span id="agree_termsError" class="error-msg13" style="display:none"></span>
<!--EditProfile Start-->
<?php
    $attributes = array('id' => 'editprofile','class' => 'form-horizontal','role'=>'form','name'=>'editprofile','onsubmit'=>"disable", 'enctype'=>'multipart/form-data');
    echo form_open('', $attributes);
?>
<!--<h4 class="title-sm">Edit Professional Profile</h4>-->

<div class="editprofile" style="padding:15px; background-color:#fff; border:1px solid #e0e0e0">
	<input type="hidden" name="uid" value="<?php echo $user_id;?>"/>
<div class="form-group">
    <div class="col-sm-6 col-xs-12">
    <p><?php echo __('dashboard_editprofile_username','Username'); ?> :</p>
    <h5><font color="#666666"><?php echo $username;?></font></h5>
    </div>
    <div class="col-sm-6 col-xs-12">
        <label><?php echo __('dashboard_editprofile_designation','Designation'); ?>: </label>
        <input type="text" class="form-control" size="30" value="<?php echo $slogan;?>" name="slogan" id="slogan"  /> 
    </div>
</div>   
<div class="form-group">
    <div class="col-sm-6 col-xs-12">
        <label><?php echo __('dashboard_editprofile_first_name','First Name'); ?> : *</label>
        <input type="text" class="form-control" size="30" name="fname"  id="fname" value="<?php echo $fname;?>" required />    
        <span id="fnameError" class="error-msg13"></span>
    </div>
    <div class="col-sm-6 col-xs-12">
    	<label><?php echo __('dashboard_editprofile_last_name','Last Name'); ?>: * </label>
        <input type="text" class="form-control" size="30" name="lname" id="lname"  value="<?php echo $lname;?>" required   />
        <span id="lnameError" class="error-msg13"></span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-6 col-xs-12">
        <label><?php echo __('dashboard_editprofile_country_name','Country Name'); ?>: *</label>
        <select class="form-control" size="1" id="country" name="country" required onchange="citylist(this.value)">
        <option value=""><?php echo __('dashboard_editprofile_select_country','Select Country'); ?></option>
        <?php
        foreach($country_list as $key=>$val)
        {
        ?>
         
         <option value="<?php echo $val['code'];?>" <?php if($val['code']==$country){echo "selected";}?>><?php echo $val['name'];?></option>
        <?php
        }
        ?>
        
        </select>
        <span id="countryError" class="rerror"></span>
    </div>

    <div class="col-sm-6 col-xs-12">
    <label><?php echo __('dashboard_editprofile_city_name','City Name'); ?>: *</label>
    <select class="form-control" size="1" id="city" name="city" required/>
		<option value=""><?php echo __('dashboard_editprofile_select_city','Select City'); ?></option>
    <?php
    foreach($city_list as $key=>$val)
    {
    ?>
     
     <option value="<?php echo $val['id'];?>" <?php if($val['id']==$cname){echo 'selected="selected"';}?>><?php echo $val['name'];?></option>
    <?php
    }
    ?>
    <div class="focusmsg" id="cityFocus" style="display:none"><?php echo __('dashboard_editprofile_select_city','Select City'); ?></div>
    
    <span id="cityError" class="error-msg13"></span>
    </select>
    </div>

</div>

<div class="form-group hidden">
	<div class="col-xs-12">
	<p><?php echo __('dashboard_editprofile_logo','Logo'); ?> :</p> 
    <div id="imge">
    <?php
    if($logo!="")
	{
	?>
		<img src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo;?>" width="100">
    <?php
	}
	else
	{
	?>   
  	<img src="<?php echo VPATH;?>assets/images/face_icon.gif">
    <?php }?>
  
  <div class="loadingimg">
  <img id="loading" src="<?php echo VPATH;?>assets/images/loading.gif" style="display:none;"></div><br>
  
  <!-- <img alt="" title="" src="viewimage.php?img=images/face_icon.gif&amp;width=60&amp;height=60"><br> -->
  </div>
  <input type="hidden" name="logo" id="logo"/>
  <div class="browsebox">
    <input type="file" class="browseimg-input" id="fileToUpload" name="fileToUpload" onchange="return ajaxFileUpload();" />
<input type="hidden" id="upload_file" name="upload_file" value="" >    
<label style=" cursor:pointer; float:left;"> <img src="<?php echo VPATH;?>assets/images/browseimg.png"/></label>
 <span style="color:rgb(113, 155, 34);width:94%; line-height:16px;float:left;padding-left: 0%;">
     <?php echo __('dashboard_editprofile_file_must_formatted','File must be gif,jpg,png,jpeg.'); ?></span>
 </div>
 
<!--   <div class="masg2"> <input type="file" class="acount-input3" size="30" name="fileToUpload" id="fileToUpload" onChange="return ajaxFileUpload();"></div>
   <span style="color:red;width:94%; line-height:16px;float:left;padding-left: 33%;">
     File must be gif,jpg,png,jpeg.</span>-->
   </div>
</div>
<div class="form-group">
	<div class="col-xs-12">
<p><?php echo __('dashboard_editprofile_overview','Overview'); ?> :</p>
<textarea class="form-control" name="overview" id="overview" rows="5"><?php echo $overview;?></textarea>
 <div class="focusmsg" id="overviewFocus" style="display:none"></div>
<h4><?php echo __('dashboard_editprofile_this_information_will_be_public','This information will be public.'); ?></h4></div>
</div>

<div class="form-group">
<div class="col-xs-12">
	<label><?php echo __('dashboard_editprofile_facebook_link','Facebook Link'); ?> : </label>
	<input type="text" class="form-control"  value="<?php echo $facebook_link;?>" name="facebook_link" id="facebook_link"/>
	<div class="focusmsg" id="facebook_linkFocus" style="display:none"><?php echo __('dashboard_editprofile_enter_your_facebook_url','Enter Your Facebook Url'); ?> </div>
    <span id="fbError" class="error-msg13"></span>
</div>
</div>

<div class="form-group">
<div class="col-xs-12">
<label><?php echo __('dashboard_editprofile_twitter_link','Twitter Link'); ?> : </label>
<input type="text" class="form-control"  value="<?php echo $twitter_link;?>" name="twitter_link" id="twitter_link"/>
<div class="focusmsg" id="twitter_linkFocus" style="display:none"><?php echo __('dashboard_editprofile_enter_your_twitter_url','Enter Your Twitter Url'); ?> </div>
<span id="twiterError" class="error-msg13"></span>
</div>
</div>

<div class="form-group">
<div class="col-xs-12">
	<label><?php echo __('dashboard_editprofile_google_plus_link','Google+ Link'); ?> : </label>
    <input type="text" class="form-control"  value="<?php echo $gplus_link;?>" name="gplus_link" id="gplus_link"   />    <div class="focusmsg" id="gplus_linkFocus" style="display:none"><?php echo __('dashboard_editprofile_enter_your_google_plus_url','Enter Your Google Plus Url'); ?> </div>
	<span id="gplusError" class="error-msg13"></span>
</div>
</div>

<div class="form-group">
<div class="col-xs-12">
    <label><?php echo __('dashboard_editprofile_linked_in_link','Linkedin Link'); ?> : </label>
    <input type="text" class="form-control"  value="<?php echo $linkedin_link;?>" name="linkedin_link" id="linkedin_link"   />    <div class="focusmsg" id="linkedin_linkFocus" style="display:none"><?php echo __('dashboard_editprofile_enter_your_linkedin_url','Enter Your Linkedin Url'); ?> </div>
    <span id="linkedinError" class="error-msg13"></span>
</div>
</div>

<input class="btn btn-site" type="button" id="submit-check" onclick="editFormPost()" value="<?php echo __('dashboard_editprofile_submit','Submit'); ?>" /></div>
<div class="clearfix"></div>
</form>
<!--EditProfile Start-->

</div>                                              

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
        <div class="addbox2">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>
<div class="clearfix"></div>

</div>
<!-- Left Section End -->
</div>
</section>
<script>
function ajaxFileUpload()
{
		
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
		$.ajaxFileUpload
		(
			{
				url:'<?php echo VPATH;?>dashboard/fileUpload',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							console.log(data);
							//alert(data.msg);
							$('#logo').val(data.msg);
							$('#imge').html('');
							$('#imge').html('<img src="<?php echo VPATH;?>assets/uploaded/'+data.msg+'">');
							//alert("logo:"+$('#logo').val());
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

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
	</script>	