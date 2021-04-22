<?php

if (!function_exists('get_user')) {

    function get_user($id = '') {
        $CI = & get_instance();
        $user = new stdClass();
        $user->id = 0;
        if ($CI->session->userdata('user'))
            $user = $CI->session->userdata('user');
        return $user;
    }

}

function pre($data, $exit = false)
{
    echo "<br />";
    print_r($data);
    if(!$exit)
        die();
}


if ( ! function_exists('__'))
{

 function __($section_name,$name_default){
 	$CI = & get_instance();
 	$tamplatelang_section=0;
 	if($CI->input->get('ltpl')){
		$tamplatelang_section=$CI->input->get('ltpl');
	}
	
	$name=trim($name_default);
	$langvaue=trim($CI->lang->line($section_name));
	
	if($langvaue!=''){
		$l= $langvaue;
	}else{
		$l= $name;
	}
	
	/*$text = $section_name . "@@@" . $l . "\n";
	$con=$CI->router->fetch_class();
	//$path=APATH."application/EClang/".$con.'_lang.txt';	
	$path=APATH."application/EClang/".'_lang.txt';	
	$fp = fopen($path, 'a+');
	if (file_exists($path)){
	
	 		$contents = file_get_contents($path);
	 		$contents = explode("\n", $contents);
	   		$users = array();
	   		foreach ($contents as $value) {
	      			$user = explode('@@@', $value);
	      			$users[$user[0]] = $user[1];
	    	}
		if($users[$section_name]!=""){

		}else{
			fwrite($fp, $text);
		}
	}
 	fclose ($fp);*/	

	if($tamplatelang_section==1){
	 	return "<span class='sectionview'>".$section_name."</span>"."".$l;
	}elseif($tamplatelang_section==2){
	 	return "<font color=red>".$section_name."</font>";
	}elseif($tamplatelang_section==3){
		if(trim($CI->lang->line($section_name))!=''){
			return $l;
		}else{
		 	return "<font color=red>".$section_name."</font>";
		}
	}elseif($tamplatelang_section==4){
	 	return $section_name;
	}else{
	 	return $l;
	}
 }
}


if(!function_exists('filter_data')){
	
	
	function filter_data($data=array()){
		
		if(is_array($data)){
			$return = array();
			foreach($data as $k => $v){
				
				if(!is_array($v)){
					$return[$k] = htmlentities($v);
				}
				
			}
			
			return $return;
		}else{
			return  htmlentities($data);
		}
	
	}
	
}

if(!function_exists('get_earned_amount')){
	
	
	function get_earned_amount($user_id=''){
		if(!$user_id){
			die("Invalid parameter");
		}
		$earned_amount = 0;
		$user_wallet_id = get_user_wallet($user_id);
		$ci = &get_instance();
		$ci->db->select("sum(txn_r.credit) as total_credit")
				->from("transaction_new txn")
				->join("project_transaction p_txn", "p_txn.txn_id=txn.txn_id")
				->join("transaction_row txn_r", "txn_r.txn_id=txn.txn_id")
				->where(array("txn.status" => "Y", "txn_r.wallet_id" => $user_wallet_id));
		$result = $ci->db->get()->row_array();
		
		if(!empty($result['total_credit'])){
			$earned_amount = $result['total_credit'];
		}
		
		return $earned_amount ;
	}
	
}

if(!function_exists('get_project_spend_amount')){
	
	
	function get_project_spend_amount($user_id=''){
		if(!$user_id){
			die("Invalid parameter");
		}
		$spend_amount = 0;
		$ci = &get_instance();
		$projects = $ci->db->dbprefix('projects');
		$user_wallet_id = get_user_wallet($user_id);
		
		$ci->db->select("sum(txn_r.debit) - sum(txn_r.credit) as total_spend")
				->from("transaction_new txn")
				->join("project_transaction p_txn", "p_txn.txn_id=txn.txn_id")
				->join("transaction_row txn_r", "txn_r.txn_id=txn.txn_id")
				->where(array("txn.status" => "Y", "txn_r.wallet_id" => $user_wallet_id));
			$ci->db->where("p_txn.project_id IN (select project_id from $projects where user_id = $user_id)");
		$result = $ci->db->get()->row_array();
	
		if(!empty($result['total_spend'])){
			$spend_amount = $result['total_spend'];
		}
		
		return $spend_amount ;
	}
	
}

if(!function_exists('get_total_bids')){
	
	
	function get_total_bids($user_id=''){
		if(!$user_id){
			die("Invalid parameter");
		}

		$ci = &get_instance();
		$count = $ci->db->where("bidder_id", $user_id)->count_all_results('bids');
		return $count;
	}
	
}


if(!function_exists('get_total_project_post')){
	
	
	function get_total_project_post($user_id=''){
		if(!$user_id){
			die("Invalid parameter");
		}
	
		$ci = &get_instance();
		$count = $ci->db->where("user_id", $user_id)->count_all_results('projects');
		return $count;
	}
	
}


if(!function_exists('get_freelancer_project')){
	
	
	function get_freelancer_project($user_id='', $status='C'){
		if(!$user_id){
			die("Invalid parameter");
		}
			
		$count = 0;
		
		$ci = &get_instance();
		if($status=='C'){
			$count = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) AND (status = 'C' OR FIND_IN_SET('$user_id', ended_contractor))")->count_all_results('projects');
		}
        if($status=='T'){
            $count = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) ")->count_all_results('projects');
            //$count2 = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) AND (status = 'P' )")->count_all_results('projects');
            //$count3 = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) AND (status = 'E' )")->count_all_results('projects');
            //$count = $count + $count2 + $count3;
        }


		return $count;
	}
	
}

if(!function_exists('get_freelancer_jss')){


    function get_freelancer_jss($user_id=''){
        if(!$user_id){
            die("Invalid parameter");
        }

        $count = 0;

        $ci = &get_instance();

            $completed = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) AND (status = 'C' OR FIND_IN_SET('$user_id', ended_contractor))")->count_all_results('projects');

            //$total = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) ")->count_all_results('projects');
            $count2 = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) AND (is_completed = 'Y')")->count_all_results('projects');
            $count3 = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) AND (is_completed = 'N')")->count_all_results('projects');
            //$count = $count + $count2 + $count3;
        $count3 = $count2 + $count3;
        $count =  (int) $completed * 100 / (int) ($count3 - 1);

        if($count>=100){
            $count = 100;
        }
        return round($count, 2);
    }

}
if(!function_exists('get_available_bids')){
	
	
	function get_available_bids($user_id='', $free=FALSE){
		
		$total_free_bid_month = getField('free_bid_per_month', 'setting', 'id', 1);
		
		$used_free_bid = get_used_bids($user_id, TRUE);
		$available_free_bid = $total_free_bid_month - $used_free_bid;
		
		if($free){
			$available_bids = $available_free_bid;
		}else{
			
			$available_purchase_bid = getField('available_bids', 'user', 'user_id', $user_id);
			$available_bids = $available_free_bid + $available_purchase_bid;
			
		}
		
		
		return $available_bids;
		
	}
	
}


if(!function_exists('get_used_bids')){
	
	
	function get_used_bids($user_id='', $free=FALSE){
		$date = date('n'); // current month
		$year = date('Y'); // current year
		$ci = &get_instance();
		$row_count = $ci->db->where("MONTH(add_date) = $date AND YEAR(add_date) = $year AND bidder_id = $user_id")->count_all_results('bids');
		
		if($free){
			
			$total_free_bid_month = getField('free_bid_per_month', 'setting', 'id', 1);
			if($row_count > $total_free_bid_month){
				$row_count =  $total_free_bid_month;
			}
		}
		
		return $row_count;
	}
	
}


if(!function_exists('update_user_bids')){
	
	
	function update_user_bids($user_id='', $bids=0){
		$ci = &get_instance();
		$ci->db->set('available_bids', 'available_bids + '.$bids, FALSE);
		$ci->db->where('user_id', $user_id);
		return $ci->db->update('user');
	}
	
}