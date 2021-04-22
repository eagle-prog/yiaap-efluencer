<section id="mainpage">
<div class="container-fluid">
<div class="row">
<div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 
<aside class="col-md-10 col-sm-9 col-xs-12">
	<div class="spacer-20"></div>
		
	<div class="well">
		<h3 class="text-uppercase"></h3>
		 <div class="table-responsive">
			<table class="table">
				<thead>  	
					<tr>
						<th style="text-align:left;">Txn ID #</th>
						<th style="text-align:left;">Wallet Info</th>
						<th style="text-align:left;">Datetime</th>
						<th style="text-align:left;">Info</th>
						<th style="text-align:center;">Status</th>
						<th style="text-align:center;">Debit (Dr)</th>
						<th style="text-align:center;">Credit (Cr)</th>
						
					</tr>
				</thead>
				<tbody>
				<?php
				if (count($all_data) > 0) {
					foreach ($all_data as $key => $val) { ?>

						<tr> 

							<td><?php echo !empty($val['txn_id']) ? $val['txn_id'] : '-'; ?></td>
							<td>
								<?php
								$wallet_id = $val['wallet_id'];
								$wallet_title = getField('title', 'wallet', 'wallet_id', $wallet_id);
								$type = 'From :';
								if($val['credit'] > 0){
									$type = 'To :';
								}
								?>
								<?php /*<p><b>Wallet ID # : </b><?php echo $wallet_id; ?><br/>*/ ?>
								<b><?php echo $type; ?>  </b><?php echo $wallet_title; ?> (Wallet)</p>
							</td>
							<td><?php echo !empty($val['datetime']) ? $val['datetime'] : 'N/A'; ?></td>
							<td><?php echo !empty($val['info']) ? $this->auto_model->parseTransaction($val['info']) : ''; ?></td>
							<td align="center">
							<?php
							$status = '';
							switch($val['status']){
								case 'Y' : 
									$status = '<font color="green">Success</font>';
								break;
								case 'P' : 
									$status = '<font color="blue">Pending</font>';
								break;
								case 'N' : 
									$status = '<font color="red">Rejected</font>';
								break;
							}
							echo $status;
							?>
							</td>
							<td align="center"><?php echo CURRENCY;?> <?php echo !empty($val['debit']) ? $val['debit'] : '0.00'; ?></td>
							<td align="center"><?php echo CURRENCY;?> <?php echo !empty($val['credit']) ? $val['credit'] : '0.00'; ?></td>
							
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
		</div>
	</div>

</aside>
</div>
</div>
</section>










