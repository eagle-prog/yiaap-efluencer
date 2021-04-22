<?php echo $breadcrumb;?>     
<script src="<?=JS?>mycustom.js"></script>
<section id="mainpage">  
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 
<div class="col-md-10 col-sm-9 col-xs-12">
<div class="spacer-20"></div>
<!--ProfileRight Start-->
<ul class="tab">
    <li><a  href="<?php echo VPATH;?>myfinance/" ><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
    <li class="hidden"><a  href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li> 
    <li><a  class="selected" href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li> 
    <li><a  href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li> 
    <li class="hide"><a  href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li> 
</ul>
<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?><?php echo $balance;?></div>
<!--EditProfile Start-->
	 	 	
<h4><?php echo __('myfinance_paypal_account_details','Paypal Account Details'); ?></h4>

<?php 

if($this->session->flashdata('succ_msg')){

echo $this->session->flashdata('succ_msg');

}elseif($this->session->flashdata('error_msg')){

echo $this->session->flashdata('error_msg');

}


?>

<div class="whiteSec"> 
<div class="methodbox">

<form name="paypal_setting" class="form-horizontal" method="post">
<input type="hidden" name="account_for" value="P"> 


<div style="margin: 0 0 15px; overflow:hidden">
<p><?php echo __('myfinance_paypal_account_setting_text','If you are registered with Paypal then just enter your registered account email id in the space provided below. Otherwise first register yourself in paypal site and then provide the registered account email id. Please note that all payments will be provided to you in your registered account email id as provided by you'); ?></p>
</div>

<?php 
$pay_pal='';
foreach($bank_account as $bank_acc){

if($bank_acc['account_for'] =='P'){
$pay_pal = $bank_acc['paypal_account'];

}

}

?>

<div class="form-group">
<div class="col-xs-12">
<label><?php echo __('myfinance_paypal_account_no','PayPal A/C No'); ?> :</label>
<input type="text" class="form-control" id="paypal_account" size="15" name="paypal_account"  <?php if($pay_pal !="") { ?> value ="<?php echo $pay_pal; ?>"<?php }else{ ?>value="<?php echo set_value('paypal_account');?>"<?php }?>>
<?php echo form_error('paypal_account', '<div class="error-msg13">','</div>'); ?>
</div>
</div>

<div class="form-group">
<div class="col-xs-12">
<input type="submit" name="update" value="<?php echo __('myfinance_update','Update'); ?>" class="btn btn-site" >
&nbsp;
<a href="<?php echo VPATH;?>myfinance/withdraw"><input type="button" name="cancel"  value="<?php echo __('myfinance_cancel','Cancel'); ?>" class="btn btn-warning"></a>
</div>
</div>


</form>

</div>

</div>
                 

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
<div class="addbox">
<?php 
echo $code;
?>
</div>                      
<?php                      
}
elseif($type=='B'&& $image!="")
{
?>
<div class="addbox">
<a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
</div>
<?php  
}
}

?>
</div>

</div>
</div>               

</section>                    
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
</script>