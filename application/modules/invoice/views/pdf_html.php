<?php 
$sender_information = (array) json_decode($invoice['sender_information']);
$receiver_information = (array) json_decode($invoice['receiver_information']);
$invoicenumber = __('invoice_number','Invoice Number');
$createddate = __('created_date','Created Date');
$from = __('from','From');
$to = __('to','To');
$name = __('name','Name');
$address = __('address','Address');
$particulars = __('particulars','Particulars');
$rate = __('rate','Rate');
$quantity = __('quantity','Quantity');
$unit = __('unit','Unit');
$amount_text = __('amount_text','Amount');
$total_price = __('total_price','Total Price');
$this_is = __('this_is','This is a computer generated invoice');
$username = __('username','Username');
$inv_row = '';
$total_amount_array = array();
if(count($invoice_row) > 0){
	foreach($invoice_row as $k => $v){
		$amount = $v['per_amount'] * $v['quantity'];
		$total_amount_array[] = $amount ;
		$inv_row  .= '<tr><td style="padding: 8px;border-top: 1px solid #ccc;">'.$v['description'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;">'.$v['per_amount'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;">'.$v['quantity'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">'.$v['unit'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">'.$amount.'</td></tr>';
	}
}

$total_amount = array_sum($total_amount_array);

$extraRow= 4;

$c = CURRENCY;
$html = <<<EOT
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>A simple, clean, and responsive HTML invoice template</title>
 
<link rel="icon" href="/images/favicon.png" type="image/x-icon">
<style>
body {
	font-family:Arial, Helvetica, sans-serif;
}
.table {
	border-collapse:collapse;
	max-width:100%;
	width:100%;
	border: 1px solid #ccc;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
	border:none;
    border-top: 1px solid #ddd;
}
tr {
	border: none;
}
th {
    text-align: left;
	text-transform:uppercase;
	font-weight:bold
}
</style>
</head>
<body>
<div class="invoice-box">
<table class="table" cellpadding="0" border="0" style="border:none;">
<tr>
<td style="border:none;"><img src="./assets/images/logo.png" alt="" style="border:none; width:100px;"></td>
<td style="border:none; text-align:right">
	<p>{$invoicenumber} : #{$invoice['invoice_number']}</p>
	<p>{$createddate} : {$invoice['invoice_date']}</p>
</td>
</tr>
</table>
<div>&nbsp;</div>
<table class="table" cellpadding="5" style="border-collapse:collapse;">
<tr>
	<td style="border:none;padding:8px;"><b>{$from} </b></td>		
	
	
	<td style="border:none;padding:8px;text-align:right;"><b>{$to}</b>
		
	</td>
</tr>
<tr>
	<td style="border:none;padding:8px;"><p><lable>{$name} :</lable> {$sender_information['name']}</p>
	<p><lable>{$address} :</lable> {$sender_information['address']}</p></td>
	
	<td style="border:none;padding:8px;text-align:right;"><p><lable>{$name} :</lable>  {$receiver_information['name']}</p><p><lable>{$address} :</lable> {$receiver_information['address']} </p></td>
</tr>
</table>

<table class="table" cellpadding="5" style="border-collapse:collapse;">
<thead>
<tr><th style="padding: 8px;border-top: 1px solid #ccc;">{$particulars}</th><th style="padding: 8px;border-top: 1px solid #ccc;">{$rate} ($c)</th><th style="padding: 8px;border-top: 1px solid #ccc;">{$quantity}</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">{$unit} </th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">{$amount_text} ($c) </th></tr>
</thead>
<tbody>
{$inv_row}
</tbody>
<tfoot>
<tr><th colspan="{$extraRow}" style="padding: 8px;border-top: 1px solid #ccc;">{$total_price} ($c)</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">{$total_amount}</th></tr>
</tfoot>

</table>
<p style="text-align:center;">{$this_is}</p>
</div>
</body>
</html>
EOT;
get_pdf($html, 'download.pdf', array('title' => __('invoice','INVOICE')));
//echo $html;
