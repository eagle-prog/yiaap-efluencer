<script>
    $(window).load(function(){
      $("#sticky_panel").sticky({ topSpacing: 105 , bottomSpacing: 485});
    });
</script>
<section class="sec" style="min-height:600px">
<div class="container-fluid">
<div class="row">
<aside class="col-md-9 col-sm-8 col-xs-12">
<!-- Nav tabs -->
<?php $this->load->view('freelancer_tab'); ?>

<!-- Tab panes -->
<div class="tab-content whiteBg" style="padding: 15px">
<div role="tabpanel" class="tab-pane active" id="overview">

<h4>Milestones</h4>	
<div class="table-responsive">

<!-- working area -->
	<table class="table">
	<thead>
	<tr>
		<th>Milestone No</th><th>Amount(<?php echo CURRENCY;?>)</th><th>Project</th><th>Date</th><th>Title</th><th>Payment Request</th>
	</tr>
	</thead>
	<tbody>
	<?php
	
	foreach($set_milestone_list as $key=>$val)
	{
		
	$is_escrowed = 0;
	$escrow_row = $this->db->where('milestone_id', $val['id'])->get('escrow_new')->row_array();
	if(!empty($escrow_row)){
		$is_escrowed = 1;
	}
	$project_name=$this->auto_model->getFeild("title","projects","project_id",$val['project_id']);
	?>
	
	<tr>
	<td><?=$val['milestone_no']?></td>
	<td><?=$val['amount']?></td>
	<td><?=$project_name?></td>
	<td><?php echo $val['mpdate'] != '0000-00-00' ? $this->auto_model->date_format($val['mpdate']) : 'At Project Ends' ;?></td>
	<td><?=$val['title']?></td>
	<?php
	if($val['client_approval']=='N'){
	echo "<td>Not Approve</td>";
	echo "<td>Not Approve</td>";
	}
	elseif($val['client_approval']=='Y')
	{
	if($val['fund_release']=='P'){
		$str = '';
		if($val['approval']=='N'){
			$str = '<a href="#">Send Request</a>';
		}else if($val['approval']=='P'){
			$str = 'Approval pending';
		}else if($val['approval']=='R'){
			$str = 'Rejected | <a href="#">Send Request</a>';
		}else{
			$str = '<a href="'.VPATH.'dashboard/FundRequest/'.$val['id'].'?next=projectdashboard_new/freelancer/milestone/'.$val['project_id'].'" style="float:none">Send Invoice</a>';
		}
	?>
	<td><a href="<?=VPATH?>dashboard/FundRequest/<?php echo $val['id'];?>?next=projectdashboard_new/freelancer/milestone/<?php echo $val['project_id']; ?>" style="float:none">Send Invoice</a></td>
	<?php
	}
	elseif($val['fund_release']=='R' && $val['release_payment'] == 'R'){
		$today = strtotime(date('Y-m-d'));
		$last_check = strtotime("+7 days", strtotime($val['requested_date']));
	?>
	<td>
	<?php if($today > $last_check){ ?>
	<button onclick="sendRemainder('<?php echo $val['id']?>');" class="btn btn-xs btn-danger">Send Remainder</button>
	<?php } ?>
	Unpaid | <a href="<?php echo base_url('/dashboard/invoice/'.$val['invoice_id'].'/'.'F')?>" target="_blank">Invoice</a>
	<?php if(($is_escrowed == 1 ) && ($escrow_row['status'] == 'D')){ ?>
	Disputed | <a href="#">View</a>
	<?php } ?>
	</td>
	<?php
	}else if($val['fund_release']=='R' && $val['release_payment'] == 'D'){ ?>
	
	<td>
	<?php if(($is_escrowed == 1 ) && ($escrow_row['status'] == 'D')){ ?>
		Disputed | <a href="<?php echo base_url('projectdashboard/dispute_room/'.$val['id'].'/'.$val['project_id']); ?>">View</a>
	<?php } ?>
	</td>
	
	<?php
		
	}elseif($val['fund_release']=='A'){
	
	?>    
	<td><i class="zmdi zmdi-check-circle zmdi-hc-2x green-text" title="Fund Approve"></i> | <a href="<?php echo base_url('/dashboard/invoice/'.$val['invoice_id'].'/'.'F')?>" target="_blank">Invoice</a></td>
	<?php
	}else if($val['release_payment']=='C'){
		echo '<td>Cancelled <a href="'.VPATH.'dashboard/FundRequest/'.$val['id'].'?next=projectdashboard_new/freelancer/milestone/'.$val['project_id'].'">Resend</a> | <a href="'.base_url('/dashboard/invoice/'.$val['invoice_id'].'/'.'F').'" target="_blank">Invoice</a></td>';
	}
	
	}
	?>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	

<!-- working area -->

</div>

</div>


</div>
</aside>

<aside class="col-md-3 col-sm-4 col-xs-12">
<?php $this->load->view('right-section'); ?>
</aside>

</div>
</div>
</section>

<script>
function sendRemainder(milestone_id){
	$.ajax({
		url: '<?php echo base_url('projectdashboard_new/send_remainder')?>',
		data: {milestone_id: milestone_id},
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
}
</script>
