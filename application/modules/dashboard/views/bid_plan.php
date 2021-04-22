
<?php echo $breadcrumb; ?> 
<section id="mainpage">
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard-left'); ?>
</div> 
<aside class="col-md-10 col-sm-9 col-xs-12">
	<div class="spacer-20"></div>
    
    <h4><?php echo __('dashboard_bid_plan','Bid Plan')?></h4>
	<div class="row">
		<div class="col-sm-8">
			<div class="table-responsive">
				<table class="table">
				<thead> 
					<th><?php echo __('dashboard_plan_name','Plan Name')?></th><th><?php echo __('dashboard_bids','Bids')?></th><th><?php echo __('dashboard_price','Price')?> (<?php echo CURRENCY;?>)</th><th></th>   	
				</thead>
				<tbody>
					<?php if(count($bid_plan) > 0){foreach($bid_plan as $k => $v){ ?>
					<tr>
						<td><?php echo $v['plan_name']; ?></td>
						<td><?php echo $v['bids']; ?></td>
						<td><?php echo $v['price']; ?></td>
						<td><button class="btn btn-primary" onclick="buy_bid('<?php echo $v['id']; ?>', this)"><?php echo __('dashboard_buy','Buy')?></button></td>
					</tr>
					<?php } } ?>
				</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-4">
			<div id="fundError"></div>
		</div>
	</div>
    
    
    
</aside>
</div>
</div>
</section>




<script>

function buy_bid(id, ele){
	if(id == ''){
		return false;
	}
	
	$('.errorBx').empty();
	if(ele){
		$(ele).html('Checking...').attr('disabled', 'disabled');
	}
	
	$.ajax({
		url : '<?php echo base_url('dashboard/buy_bid_ajax'); ?>',
		data: {plan_id: id},
		dataType: 'json',
		type: 'post',
		success: function(res){
			if(res.status == 1){
				location.href = '<?php echo base_url('dashboard/dashboard_new')?>';
			}else{
				var errors = res.errors;
				for(var i in errors){
					$('#'+i+'Error').addClass('errorBx').html(errors[i]);
				}
			}
		}
	});
}
</script>






