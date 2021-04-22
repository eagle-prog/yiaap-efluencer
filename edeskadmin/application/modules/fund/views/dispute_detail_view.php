<link rel="stylesheet" href="<?=JS?>jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
	<script src="<?=JS?>jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
		
		});
	});
	</script>


<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active">Disputes</li>
            </ul>
        </div>


        <div class="container-fluid">           
			
			<?php
				if($this->session->flashdata('succ_msg')){
				?>
				<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?php echo $this->session->flashdata('succ_msg'); ?>
				</div> 
				<?php
				}
				if($this->session->flashdata('error_msg')){
				
				?>
				<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?php echo $this->session->flashdata('error_msg'); ?>
				</div>
				<?php
				}
				?>
			
			
					<table class="table table-hover table-bordered adminmenu_list">
						<thead>  	
                            <tr>
                                <th>Project</th>
                                <th>Dispute Amount</th>
                                <th>Action</th>
                            </tr>
						 </thead>
						 <tbody>
							<tr>
								<td>
									<?php
									$title = '';
									if(!empty($dispute_row['project_id'])){
										$title = getField('title', 'projects','project_id', $dispute_row['project_id']);
									}
									echo $title;
									?>
								</td>
								<td>
									$<?php echo !empty($dispute_row['amount']) ? $dispute_row['amount'] : '0.00'; ?>
								</td>
								<td>
									<?php if(!empty($dispute_row) && ($dispute_row['status'] == 'D')){ ?>
									
									<button class="btn btn-xs btn-success" onclick="$('#close_dispute_form').show(); $('#close_dispute_btn').hide();" id="close_dispute_btn">Settlement</button>
									
									<form onsubmit="handleDispute(this, event)" id="close_dispute_form" style="display: none; ">
										<?php
										$p_user = getField('user_id', 'projects', 'project_id', $dispute_row['project_id']);
										$employer_fname = getField('fname', 'user', 'user_id', $p_user);
										$employer_lname = getField('lname', 'user', 'user_id', $p_user);
										$emp_name = $employer_fname.' '. $employer_lname;
										$bid_id = getField('bid_id', 'project_milestone', 'id' , $dispute_row['milestone_id']);
										$f_user = getField('bidder_id', 'bids', 'id' , $bid_id);
										$worker_fname = getField('fname', 'user', 'user_id', $f_user);
										$worker_lname = getField('lname', 'user', 'user_id', $f_user);
										$worker_name = $worker_fname.' '.$worker_lname;
										
										$milestone_amount = $dispute_row['amount'];
										$commission = (($milestone_amount * SITE_COMMISSION) / 100);
										$amount_to_distribute = $milestone_amount -  $commission;
										
			
										?>
										
										<p><b>Settle </b></p>
										<p>
										Dispute Amount : <b>$<?php echo $milestone_amount; ?></b><br/>
										Commission : <b>$<?php echo $commission; ?></b><br/>
										Amount to Distribute : <b>$<?php echo $amount_to_distribute; ?></b>
										</p>
										<div id="milestone_idError" class="rerror"></div>
										<table>
											<tr>
												<td><?php echo $emp_name; ?><br/><small>(Employer)</small></td>
												<td>
												<input type="text" placeholder="Amount" name="employer_amount"/>
												<input type="hidden" name="employer_id" value="<?php echo $p_user; ?>"/>
												<div id="employer_amountError" class="rerror"></div>
												</td>
											</tr>
											<tr>
												<td><?php echo $worker_name; ?><br/><small>(Worker)</small></td>
												<td>
												<input type="text" placeholder="Amount"name="worker_amount"/>
												<input type="hidden" name="worker_id" value="<?php echo $f_user; ?>"/>
												<input type="hidden" name="milestone_id" value="<?php echo $dispute_row['milestone_id'];?>"/>
												
												<input type="hidden" name="project_id" value="<?php echo $dispute_row['project_id'];?>"/>
												<input type="hidden" id="max_div_amount" value="<?php echo $amount_to_distribute; ?>"/>
												<div id="worker_amountError" class="rerror"></div>
												</td>
											</tr>
											<tr>
												<td></td>
												<td>
												<button class="btn btn-primary btn-xs">Confirm</button>
												<button type="button" class="btn pull-right btn-xs" onclick="$('#close_dispute_form').hide(); $('#close_dispute_btn').show();">Cancel</button>
												</td>
											</tr>
										</table>
										  <br/>
									
									</form>
									
									<?php } ?>
								</td>
							</tr>
						 </tbody>
					</table>
				
			
            <div class="row">
			
                <div class="col-lg-6">
                    <div id="prod">
					<h4>CONVERSATIONS</h4>
                    <table class="table table-hover table-bordered adminmenu_list">
                        <thead>  	
                            <tr>
                                <th> ID #</th>
                                <th>sender</th>
                                <th>Message</th>
                                <th>Attachment</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                       
                            <?php
                               $attr = array(
                                
                                'class' => 'i-cancel-circle-2 red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                
                                'class' => 'i-checkmark-3 red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                               
                                'class' => 'i-checkmark-3 green',
                                'title' => 'Active',
								'href'=> 'javascript:;'
                            );
							?>
                            <?php
                            if (count($all_messages) > 0) {
                                foreach ($all_messages as $key => $val) { ?>

                                    <tr> 

                                        <td><?php echo !empty($val['message_id']) ? $val['message_id'] : '-'; ?></td>
                                        <td><?php echo !empty($val['sender_name']) ? $val['sender_name'] : ''; ?></td>
                                        
                                        <td title="<?php echo !empty($val['message']) ? $val['message'] : ''; ?>"><?php echo !empty($val['message']) ? (strlen($val['message']) > 15 ? substr($val['message'], 0, 15).'...' : $val['message'] ) : ''; ?></td>
										
										<td align="center">-</td>
                                        
                                    </tr>



                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center" style="color:#F00">No records found...</td>
                                </tr>
							
								<?php
							}
							?>
							
                        </tbody>
                    </table>
     
				<?php echo $links;?>
              </div>
                    
                </div><!-- End .col-lg-6  -->
				
				<div class="col-lg-6">
					<h4>History</h4>
					<table class="table table-hover table-bordered adminmenu_list">
						<thead>  	
                            <tr>
                                <th> ID #</th>
                                <th>Worker</th>
                                <th>Employer</th>
                                <th>Requested Amount</th>
                                <th>Requested Date</th>
                                <th>Status</th>
                                
                            </tr>
                        </thead>
						
						 <tbody>
							<?php if(count($all_dispute_history) > 0){foreach($all_dispute_history as $k => $v){ ?>
								<tr>
									<td><?php echo $v['id'];?></td>
									<td><?php echo $v['worker_name']; ?></td>
									
									<td><?php echo $v['employer_name']; ?></td>
									<td>
										<?php echo $v['worker_name'] . ': <b> $' . $v['worker_amount'].'</b>'; ?><br/>
										<?php echo $v['employer_name'] . ': <b> $' . $v['employer_amount'].'</b>'; ?>
									
									</td>
									<td><?php echo $v['requested_date']; ?></td>
									<td>
									<?php 
										if($v['status'] == 'P'){
											echo 'Pending';
										}else if($v['status'] == 'A'){
											echo 'Approved';
										}else{
											echo 'Declined';
										}
									?>
									</td>
								</tr>
							<?php } } ?>
						  </tbody>
					</table>
				</div>
			
            </div><!-- End .row-fluid  -->
			
			

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>

<div id="txnDetailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Transaction Detail</h4>
      </div>
      <div class="modal-body" id="modal_body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

 <style>
  @media print {
  body * {
    visibility: hidden;
  }
  #st{ display: none;}
  #ac{ display: none;}
  #stt{ display: none;}
  #acc{ display: none;}
  #example1_length{ display: none;}
  #example1_filter{ display: none;}
  .pagination{ display: none;}
  .crumb{ display: none;}
  #sidebar{ display: none;}
  #prod * {
    visibility: visible;
  }
  #prod {
    position: absolute;
    left: 0;
    top: 0;
  }
}

.rerror {
    font-size: 12px;
    color: #d01010;
}

</style>    


<script>

var handleDispute = function(f, e){
	e.preventDefault();
	
	var validForm = true;
	
	var emp_amount = $(f).find('[name="employer_amount"]').val();
	var worker_amount = $(f).find('[name="worker_amount"]').val();
	var milestone_id = $(f).find('[name="milestone_id"]').val();
	var max_amount = $('#max_div_amount').val();
	
	if(emp_amount == '' || isNaN(emp_amount)){
		$('#employer_amountError').html('Invalid input');
		validForm = false;
	}else{
		$('#employer_amountError').html('');
	}
	
	if(worker_amount == '' || isNaN(worker_amount)){
		$('#worker_amountError').html('Invalid input');
		validForm = false;
	}else{
		$('#worker_amountError').html('');
	}
	
	
	if(milestone_id == ''){
		$('#milestone_idError').html('Invalid input');
		validForm = false;
	}else{
		$('#milestone_idError').html('');
	}
	
	if(max_amount != (parseFloat(worker_amount) + parseFloat(emp_amount))){
		$('#milestone_idError').html('Distribution amount must be equal to '  + max_amount);
		validForm = false;
	}else{
		$('#milestone_idError').html('');
	}
	
	var fdata = $(f).serialize();
	
	if(validForm){
		
		$.ajax({
			url : '<?php echo base_url('fund/close_dispute')?>',
			data: fdata,
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				$(f).find('button').attr('disabled', 'disabled');
			},
			success: function(res){
				$(f).find('button').removeAttr('disabled', 'disabled');
				if(res.status == 1){
					
					location.href = '<?php echo base_url('fund/disputes')?>';
					
				}
			}
		});
	}
	
	
}
</script>
