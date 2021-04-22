
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
          <ul class="tab">
            <li><a class="selected" href="<?php echo VPATH;?>myfinance/"><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>
            <?php /*?><li><a href="<?php echo VPATH;?>myfinance/milestone">Milestone</a></li>
			<li><a href="<?php echo VPATH;?>membership/">Membership</a></li><?php */?>
            <li><a href="<?php echo VPATH;?>myfinance"><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li>
            <li><a href="<?php echo VPATH;?>myfinance/transaction"><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li>            
          </ul>
            <div class="balance"><span><?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>
            <br />
            <div class="alert alert-success">
            <i class="zmdi zmdi-check-circle"></i> <?php echo __('myfinance_your_payment_is_successful_fund_was_added_to_your_wallet','Your payment is successful. Fund was added to your wallet.')?>                       
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
          <div class="addbox"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
          <?php  
 }
  }

?>
        </div>
        <!-- Left Section End --> 
      </div>
    </div>
</section>