<?php echo $breadcrumb; ?>
<section id="mainpage">
<div class="container-fluid">
<div class="row">
    <div class="col-md-2 col-sm-3 col-xs-12">
        <?php $this->load->view('dashboard/dashboard-left'); ?>
    </div>
    
    <div class="col-md-10 col-sm-9 col-xs-12"> 
    <div class="row">
    <aside class="col-md-9 col-xs-12">
    <!-- Nav tabs -->
    <?php $this->load->view('employer_tab'); ?>
    
    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="overview">
    
        <div class="row">
        <article class="col-sm-6 col-xs-12">
            <?php
            $bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_detail['project_id']);
            $bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id));
            $paid_amount=$this->autoload_model->getPaidAmount($project_detail['project_id'],$bidder_id);
            if(!$paid_amount){
                $paid_amount=0;
            }
            
            $commission_amount = $this->projectdashboard_model->getCommission($project_detail['project_id'], $bidder_id);
			if(!$commission_amount){
				$commission_amount = 0;
			}
            $pending_dispute_amount = $this->projectdashboard_model->getPendingDispute($project_detail['project_id'], $bidder_id);
            $dispute_amount = $this->projectdashboard_model->getApproveDispute($project_detail['project_id']);
           
			$remaining_bal = (number_format($bidder_amt) - number_format($paid_amount) - number_format($pending_dispute_amount) - number_format($dispute_amount) - number_format($commission_amount));
            
            // include commission in total paid
            $paid_amount += $commission_amount;
            ?>
            <h4><?php echo __('summary','Summary')?></h4>
            
            <ul class="list-group proamount" style="margin-bottom:20px">
                <li class="list-group-item"><?php echo __('projectdashboard_project_amount','Project Amount'); ?> : <span class="badge"><?php echo CURRENCY. $bidder_amt; ?></span></li>
                <li class="list-group-item"><?php echo __('projectdashboard_paid_amount','Paid Amount'); ?> : <span class="badge"><?php echo CURRENCY. $paid_amount; ?></span></li>
                
                <?php if($pending_dispute_amount > 0){ ?>
                <li class="list-group-item"><?php echo __('projectdashboard_pending_dispute_amount','Pending Dispute Amount'); ?> : <span class="badge"><?php echo CURRENCY. $pending_dispute_amount;?></span></li>
                <?php } ?>
                
                <?php if($dispute_amount > 0){ ?>
                <li class="list-group-item"><?php echo __('projectdashboard_dispute_amount','Dispute Amount'); ?> : <span class="badge"><?php echo ' + '.CURRENCY. $dispute_amount; ?></span></li>
                <?php } ?>
                
                <li class="list-group-item"><?php echo __('projectdashboard_remaining_amount','Remaining Amount'); ?> : <span class="badge"><?php echo CURRENCY. ($remaining_bal); ?></span></li>
                
                
            </ul>	
            
        </article>
        
        <article class="col-sm-6 col-xs-12">
            <h4>&nbsp;</h4>
            <div class="alert alert-info text-left">     
				<h4><?php echo __('about_job','About Job')?></h4>
                <p><?php echo !empty($project_detail['description']) ? $project_detail['description'] : '' ; ?></p>
            </div>
        </article>
        
        </div>
        
            <h4><?php echo __('freelancer','Freelancers')?></h4>
            <div class="table-responsive">
            <table class="table">
            <tbody>
                <?php 
                    $bidders = $project_detail['bidder_id'];
                    $all_bidders = explode(',', $bidders);
                    
                    if(count($all_bidders) > 0){ foreach($all_bidders as $k => $v){ 
                    $user_info = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $v)));
                    
                    $name = $user_info['fname'].' '.$user_info['lname'];
                    
                    $freelancer_private_feedback =$freelancer_public_feedback = array();
                    
                    $freelancer_given_public_feedback = $freelancer_given_private_feedback = array();
                    
                    $is_freelancer_feedback_done = false;
                    
                    if(!empty($feedback['private'][$user_id.'|'.$v])){
                        $freelancer_private_feedback = $feedback['private'][$user_id.'|'.$v];
                        
                    }
                    
                    if(!empty($feedback['public'][$user_id.'|'.$v])){
                        $freelancer_public_feedback = $feedback['public'][$user_id.'|'.$v];
                    }
                    
                    if(!empty($feedback['public'][$v.'|'.$user_id])){
                        $freelancer_given_public_feedback =$feedback['public'][$v.'|'.$user_id];
                        $is_freelancer_feedback_done=true;
                    }
                    
                    if(!empty($feedback['private'][$v.'|'.$user_id])){
                        $freelancer_given_private_feedback =$feedback['private'][$v.'|'.$user_id];
                        $is_freelancer_feedback_done=true;
                    }
                
                    ?>
                <tr>
                    <td><?php echo $user_info['fname'].' '.$user_info['lname'];?></td>
                    <td class="text-right">
                        <?php if($project_detail['status'] == 'P'){ ?>
                            <a href="<?php echo base_url('message/browse/'.$project_detail['project_id'].'/'.$v);?>"><i class="zmdi zmdi-email zmdi-18x" title="<?php echo __('projectdashboard_message','Message'); ?>"></i></a>&nbsp;
                            <a href="javascript:void(0)" onclick="giveBonus('<?php echo $project_detail['project_id'];?>','<?php echo $v;?>')"><i class="zmdi zmdi-money zmdi-18x" title="<?php echo __('projectdashboard_bonus','Bonus'); ?>"></i></a>&nbsp;
                            
                        <?php } ?>
                        
                            <?php if($project_detail['status'] == 'C'){ ?>
                            
                            <!--<a href="<?php echo base_url('dashboard/rating/'.$project_detail['project_id'].'/'.$v); ?>"><i class="zmdi zmdi-star zmdi-18x" title="<?php echo __('projectdashboard_rating','Rating'); ?>"></i></a>-->
                            
                            <?php if(!empty($freelancer_public_feedback)){ ?>
                         <a title="Update Review" href="javascript:void(0);" data-freelancer-id="<?php echo $v; ?>" data-name="<?php echo $name; ?>" onclick="updateFeedback(this)" data-public-feedback='<?php echo json_encode($freelancer_public_feedback);?>' data-private-feedback='<?php echo json_encode($freelancer_private_feedback);?>'><i class="zmdi zmdi-star zmdi-18x"></i></a>
                         <?php }else{  ?>
                         
                          <a title="Give Review" href="javascript:void(0);" data-freelancer-id="<?php echo $v; ?>" data-name="<?php echo $name; ?>" onclick="updateFeedback(this)"><i class="zmdi zmdi-star zmdi-18x"></i></a>
                          
                         <?php } ?>
                     
                             <?php if($is_freelancer_feedback_done){ ?>
                            | <a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($freelancer_given_public_feedback); ?>' data-private-feedback='<?php echo json_encode($freelancer_private_public_feedback); ?>' data-name="<?php echo $name; ?>"><?php echo __('projectdashboard_view_freelancer_feedback','View Freelancer Feedback')?></a>
                         <?php } ?>
                     
                            <?php } ?>
                    </td>
                </tr>
                <?php } } ?>
            </tbody>
            
            </table>
            </div>
           
    </div>
    </div>
    </aside>
    <aside class="col-md-3 col-xs-12">
    <?php $this->load->view('right-section');?>
    </aside>
</div>
</div>
</div>
</div>
</section>

<!-- modals -->

<div class="modal fade" id="givebonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#givebonus').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('projectdashboard_give_bonus','Give Bonus'); ?></h4>
      </div>
      <div class="modal-body">
      <div id="bonusmessage" class="login_form"></div>
	  
      <form action="" name="givebonusform" class="form-horizontal givebonusform" method="POST">
       <input type="hidden" name="bonus_freelancer_id" id="bonus_freelancer_id" value="0"/>
       
       <div class="form-group">
           <div class="col-xs-12">
               <label><?php echo __('projectdashboard_amount','Amount'); ?>: </label>
               <input type="text" class="form-control" size="30" value="0" name="bonus_amount" id="bonus_amount"> 
           </div>
       </div>
       <div class="form-group">
           <div class="col-xs-12">
           <label><?php echo __('projectdashboard_reason','Reason'); ?>: </label>
           <textarea type="text" class="form-control"  name="bonus_reason" id="bonus_reason"> </textarea>
           </div>
       </div>
       <button type="button" onclick="sendbonus()" id="sbmt" class="btn btn-site btn-sm"><?php echo __('projectdashboard_send','Send'); ?></button>
       </form>
	   
	   <div class="clearfix"></div>
      </div>      
    </div>
  </div>
</div>

<?php $this->load->view('employer_rating_review'); ?>
<script>
function giveBonus(p_id, f_id){
	$('#bonus_freelancer_id').val(f_id);
	$('#givebonus').modal('show');
}

function sendbonus(){
	$("#bonusmessage").html('Wait...');
	var requestbonis=$(".givebonusform").serialize();
	
	$.ajax({
		data:$(".givebonusform").serialize(),
		type:"POST",
		dataType: "json",
		url:"<?php echo base_url('findtalents/givebonus')?>",
		success:function(response){
			
			if(response['status']=='OK'){
				
				$("#bonusmessage").html('<div class="info-success">'+response['msg']+'</div>');
				$(".givebonusform").css('display','none');
				$("#givebonus div.modal-footer button#sbmt").css('display','none');
				$(".givebonusform")[0].reset();	
				
			}else{
				
				$("#bonusmessage").html('<div class="info-error">'+response['msg']+'</div>');	
				
			}
		}
	});
}
</script>