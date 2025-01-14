<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectdashboard_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function getMessage($user_id,$project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('recipient_id',$user_id);
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getoutgoingMessage($user_id,$project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('sender_id',$user_id);
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getfiles($project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('attachment <>',"");
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getAllMessage($project_id,$sender_id,$recipient_id,$limit = '', $start = '')
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->limit($limit, $start);
		$rs=$this->db->get('message');
		$data=array();
        
        foreach($rs->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
				"attachment" => $val->attachment,
                "add_date" => $val->add_date
            );
        }
        return $data;
	}
	public function countAllMessage($project_id,$sender_id,$recipient_id)
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->from('message');
		return $this->db->count_all_results();
		
	}
	public function insertMessage($data)
	{
		return $this->db->insert('message',$data);	
	}
	public function delete_message($mid)
	{
		$this->db->where('id',$mid);
		return $this->db->delete('message');	
	}
	
	
	// ---------------------------Not Use Any More -------------------------------------//
	
	public function getOutgoingMilestone($uid,$pid){
        $this->db->select("*");
		 $data= array();
        $data=$this->db->get_where("milestone_payment",array("employer_id"=>$uid,'project_id'=>$pid))->result_array();
       
        return $data;
        
    }
	
	public function getIncomingMilestone($uid,$pid){
		 $data=array();
		 $this->db->select("*");
		
         $data=$this->db->get_where("milestone_payment",array("worker_id"=>$uid,"project_id"=>$pid))->result_array();
       
	   
      
        return $data;
        
    }
	
	// ---------------------------------------- End Of Not Use Any More ---------------------//
	
	 public function getprojectdetails($id){ 
	  $data=array();
        $this->db->select('*');
         $data=$this->db->get_where("projects",array("project_id"=> $id))->row_array();
       
        
        return $data;
        
        
    }
	
	public function listing_search_pagination($pid,$pagination_string = '', $offset = 6) {
        if ($pagination_string != "") {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?" . $pagination_string;
        } else {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?page_id=0";
        }

        $config['total_rows'] = $this->search_count();
        $config['per_page'] = $offset;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'limit';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
	
	private function search_count() {
        $nor = $this->db->query($this->last_query)->num_rows();
        return $nor;
    }
	
	public function getprojecttracker_manual($pid){
		$this->db->select("*");
		$this->db->where(array("project_id"=> $pid));		
		$this->db->where('stop_time <>','0000-00-00 00:00:00');
		$this->db->from("project_tracker_manual");
		$this->db->order_by('start_time','DESC');
		/* $this_query = $this->db->_compile_select();
        $this->last_query = $this_query; */
        $data=$this->db->get()->result_array();
		
        return $data;
	}
	
	
	public function getProjectUsers($project_id='', $utpye='E'){
		$user = $this->session->userdata('user');
		
		$result = array();
		
		if($utpye == 'F'){
			$p_row = get_row(array('select' => '*', 'from' => 'projects', 'where' => array('project_id' => $project_id)));
			$user_row = get_row(array('select' => 'fname,lname', 'from' => 'user', 'where' => array('user_id' => $p_row['user_id'])));
			if($p_row){
				$result[0]['user_id'] = $p_row['user_id'];
				$result[0]['name'] = $user_row['fname'].' '.$user_row['lname'];
				$result[0]['type'] = 'Employer';
				$result[0]['unread_msg'] =$this->db->where(array('recipient_id' => $user[0]->user_id, 'sender_id' => $p_row['user_id'],  'read_status' => 'N'))->count_all_results('message');
			}
		}else{
			
			$p_row = get_row(array('select' => '*', 'from' => 'projects', 'where' => array('project_id' => $project_id)));
			$p_users = $p_row['bidder_id'];
			//get_print($p_users , FALSE);
			if(!empty($p_users)){
				$all_users = explode(',',$p_users);
				if(count($all_users) > 0){
					foreach($all_users as $k => $v){
						if($v != 0){
							
							$user_row = get_row(array('select' => 'fname,lname', 'from' => 'user', 'where' => array('user_id' => $v['user_id'])));
							
							$result[] = array(
								'user_id' => $v,
								'name' => $user_row['fname'].' '.$user_row['lname'],
								'type' => 'Freelancer',
								'unread_msg' => $this->db->where(array('sender_id' => $v, 'recipient_id' => $user[0]->user_id, 'read_status' => 'N'))->count_all_results('message')
							);
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	public function getsetMilestone($pid){
		$data=array();
		
		$user=$this->session->userdata('user');
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		
        $this->db->select('pm.*')->from('project_milestone pm');
		$this->db->join('bids b','b.id=pm.bid_id','LEFT');
		$this->db->where('pm.project_id',$pid);
		$this->db->where('pm.status','A');
		if($data['account_type'] == 'F'){
		$this->db->where('b.bidder_id',$data['user_id']);
		}
        $data=$this->db->get()->result_array();
       
        
        return $data;
    }
	
	public function getProjectUserSingle($user_id=''){
		
		$user_row = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $user_id)));
		
		return $user_row;
	}	
	
	public function getCountryCityDetails_user($counrty='',$city_code=''){
		
		$this->db->select('Name,Code2');
		$this->db->from('country');
		$this->db->where('Code',$counrty);
		$result = $this->db->get()->row_array();
		$result['city_name'] = getField('Name','city','ID',$city_code);
		//get_print($result);
		return $result;
	}	
	

	/* New function */
	
	public function getProjectActivity($pid=''){
		 $this->db->select('*')
				->from('project_activity')
				->where('project_id', $pid);
		$res = $this->db->get()->result_array();
		if(count($res) > 0){
			foreach($res as $k => $v){
				$res[$k]['assigned_user'] = $this->_getActivityAssignedUser($v['id']);
			}
		}
		return $res;
	}
	
	public function _getActivityAssignedUser($act_id=''){
		$this->db->select('u.user_id,u.fname,u.lname,au.approved')
					->from('project_activity_user au')
					->join('user u', 'u.user_id=au.assigned_to', 'LEFT');
		$this->db->where('au.activity_id', $act_id);
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	public function getDisputeMessages($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$this->db->where('milestone_id', $srch['milestone_id']);
		$this->db->where('project_id', $srch['project_id']);
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('message_id', 'ASC')->get('dispute_messages')->result_array();

			if(count($result) > 0){
				foreach($result as $k => $v){
					
					$sender_info = $this->db->where('user_id', $v['sender_id'])->get('user')->row_array();
					
					$profile_pic = '';
			
					if(!empty($sender_info['logo'])){
						
						$profile_pic = base_url('assets/uploaded/'.$sender_info['logo']);
						
						if(file_exists('assets/uploaded/cropped_'.$sender_info['logo'])){
							$profile_pic = base_url('assets/uploaded/cropped_'.$sender_info['logo']);
						}
					}else{
						$profile_pic = base_url('assets/images/user.png');
					}
			
					
					$result[$k]['message'] = $v['message'];
					$result[$k]['date'] = date('d M, Y h:i A', strtotime($v['date']));
					$result[$k]['message_id'] = $v['message_id'];
					$result[$k]['attachment'] = $v['attachment'];
					$result[$k]['sender'] = array(
						'sender_id' => $v['sender_id'],
						'name' => $sender_info['fname'],
						'image' => $profile_pic,
					);
				}
			}
		}else{
			$result = $this->db->get('dispute_messages')->num_rows();
		}
		
		return $result;
	}
	
	public function getDisputeHistory($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$this->db->where('milestone_id', $srch['milestone_id']);
		$this->db->where('project_id', $srch['project_id']);
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('id', 'DESC')->get('dispute_history')->result_array();

			if(count($result) > 0){
				foreach($result as $k => $v){
					
					$employer_info = $this->db->where('user_id', $v['employer_id'])->get('user')->row_array();
					$freelancer_info = $this->db->where('user_id', $v['worker_id'])->get('user')->row_array();
					
					$result[$k]['employer_info'] = $employer_info;
					$result[$k]['freelancer_info'] = $freelancer_info;
					
				}
			}
		}else{
			$result = $this->db->get('dispute_messages')->num_rows();
		}
		
		return $result;
	}
	
	public function getPendingDispute($project_id='', $bidder_id=''){
		$m_rows= $this->db->select('sum(amount) as amount')->from('escrow_new')->where(array('project_id' => $project_id, 'status' => 'D'))->get()->row_array();
		
		if(!empty($m_rows)){
			return $m_rows['amount'];
		}
		
		return 0;
	}
	
	public function getApproveDispute($project_id=''){
		$m_rows= $this->db->select('milestone_id')->from('escrow_new')->where(array('project_id' => $project_id))->get()->result_array();
		$dispute_milestones = array();
		
		if($m_rows){
			foreach($m_rows as $k => $v){
				$dispute_milestones[] = $v['milestone_id'];
			}
			
			
			
			$this->db->select("(sum(employer_amount)) as diff",FALSE)
				->from('dispute_history')
				->where_in('milestone_id', $dispute_milestones)
				->where('status', 'A');
				
			$result = $this->db->get()->row_array();
			
			if(!empty($result['diff'])){
				return $result['diff'];
			}
			
			return 0;
		}
	}
	
	public function getCommission($project_id=''){
		$c_rows= $this->db->select('sum(commission) as commission')->from('milestone_payment')->where(array('project_id' => $project_id, 'release_type' => 'P'))->get()->row_array();
		
		if(!empty($c_rows)){
			return $c_rows['commission'];
		}
		
		return 0;
		
	}
	
	
	public function getProjectScheduleFreelancer($project_id='', $freelancer_id=''){
		
		return $this->db->where(array('project_id' => $project_id, 'freelancer_id' => $freelancer_id))->get('project_schedule')->row_array();
		
	}
	
	public function getProjectRequestFreelancer($project_id='', $freelancer_id=''){
		return $this->db->where(array('project_id' => $project_id, 'freelancer_id' => $freelancer_id))->get('project_start_request')->row_array();
	}
	
	public function getProjectSchedule($project_id=''){
		
		return $this->db->where(array('project_id' => $project_id))->get('project_schedule')->result_array();
		
	}
	
	public function getProjectRequest($project_id=''){
		return $this->db->where(array('project_id' => $project_id, 'status' => 'P'))->get('project_start_request')->result_array();
	}
	
	public function startScheduledProject(){
		$curr_date = date('Y-m-d');
		$this->db->where("project_start_date <= '$curr_date'")->update('project_schedule', array('is_project_start' => '1'));
		
	}
	
	public function insertTrackerManual($data=array()){ 
        $ins = $this->db->insert("project_tracker_manual",$data);
		return $this->db->insert_id();
    }
	
	public function checkProjectDeposit($min_deposit=0 , $project_id=''){
		$total_deposit = get_project_deposit($project_id);
		$total_release = get_project_release_fund($project_id);
		$total_pending = get_project_pending_fund($project_id);
		$remaining_bal = $total_deposit - $total_release - $total_pending;
	
		if($remaining_bal < $min_deposit){
			$this->db->where(array('project_id' => $project_id, 'status' => 'P'))->update('projects', array('status' => 'S'));
			
			$employer_id =  getField('user_id', 'projects', 'project_id', $project_id);
			$to_mail = array();
			$to_mail[] = getField('email', 'user', 'user_id', $employer_id);
			$all_flncer = $this->db->where(array('project_id' => $project_id, 'is_contract_end <>' => '1'))->get('project_schedule')->result_array();
			if($all_flncer){
				foreach($all_flncer as $k => $v){
					$to_mail[] = getField('email', 'user', 'user_id', $v['freelancer_id']);
				}
			}
			
			$template='project_stopped';
			$project_title = getField('title', 'projects', 'project_id', $project_id);
			$data_parse=array( 'PROJECT'=>$project_title);
			send_layout_mail($template, $data_parse, $to_mail);
					
		}else{
			$this->db->where(array('project_id' => $project_id, 'status' => 'S'))->update('projects', array('status' => 'P'));
		}
	}
	
	
	public function getProjectFeedback($project_id='', $feedback_from=''){
		
		$result = array();
		
		$feedback = $this->db->where('project_id', $project_id)->get('feedback')->result_array();
		
		$ratings = $this->db->where(array('project_id' => $project_id))->get('review_new')->result_array();
		
		foreach($feedback as $k => $v){
			$result['private'][$v['feedback_by_user'].'|'.$v['feedback_to_user']]  = $v;
		}
		foreach($ratings as $k => $v){
			$result['public'][$v['review_by_user'].'|'.$v['review_to_user']]  = $v;
		} 
		
		return $result;
		
	}
	
	public function getprojecttracker($pid ,$uid=''){
		$this->db->select("*");
		$this->db->where(array("project_id"=> $pid));	
		if($uid){
			$this->db->where(array("worker_id"=> $uid));	
		}
		$this->db->where('stop_time <>','0000-00-00 00:00:00');
		$this->db->from("project_tracker");
		$this->db->order_by('start_time','DESC');
		/* $this_query = $this->db->_compile_select();
        $this->last_query = $this_query; */
        $data=$this->db->get()->result_array();
		
        return $data;
	}
	
	
	public function getscreenshot($tracker_id, $limit = '', $start = '', $for_list=TRUE){
		$this->db->select("*");
		$this->db->from("project_tracker_snap");
		$this->db->where("project_tracker_id", $tracker_id);
		$this->db->order_by('project_work_snap_time','DESC');
		
		if($for_list){
			$this->db->limit($limit, $start);
			$res=$this->db->get()->result_array();
		}else{
			$res=$this->db->get()->num_rows();
		}
		
        return $res;
	}
	
	public function getTrackerDetail($srch=array()){
		$this->db->select("t_s.*");
		$this->db->from("project_tracker t");
		$this->db->join("project_tracker_snap t_s", "t.id=t_s.project_tracker_id");
		
		if(!empty($srch['project_id'])){
			$this->db->where("t.project_id", $srch['project_id']);
		}
		
		if(!empty($srch['worker_id'])){
			$this->db->where("t.worker_id", $srch['worker_id']);
		}
		
		if(!empty($srch['show_date'])){
			$d = date('Y-m-d', $srch['show_date']);
			$this->db->where("DATE(t_s.project_work_snap_time) = '$d'");
		}
	
		$this->db->order_by('t_s.project_work_snap_time','ASC');
		
		$res=$this->db->get()->result_array();
		
		
        return $res;
	}
	
	public function getProjectInvoice($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		
		$this->db->select('i.*,t.type')
				->from('invoice_main i')
				->join('invoice_type t', 'i.invoice_type=t.invoice_type_id', 'LEFT')
				->join('project_invoice p_i', 'p_i.invoice_id=i.invoice_id', 'LEFT');
		
		if(!empty($srch['project_id'])){
			$this->db->where('p_i.project_id', $srch['project_id']);
		}
		
		if(!empty($srch['user_id'])){
			$this->db->where("(i.sender_id = {$srch['user_id']} OR i.receiver_id = {$srch['user_id']})");
		}
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('i.invoice_id', 'DESC')->get()->result_array();

		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	
	public function pay_hourly_invoice($invoice_id='', $project_id=''){
	
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$msg  = array();
		$error = 0;
		$total_cost_new = 0;
		$invoice_row = get_row(array('select' =>'*', 'from' => 'invoice_main' ,  'where' => array('invoice_id' => $invoice_id)));
		
		$invoice_number = $invoice_row['invoice_number'];
		$tracker_rows = get_results(array('select' =>'*', 'from' => 'project_tracker' ,  'where' => array('invoice_id' => $invoice_id, 'payment_status <>' => 'P')));
		
		$freelancer_id = $invoice_row['sender_id'];
		$freelancer_wallet_id = get_user_wallet($freelancer_id);
		
		$tracker_ids = array();
		
		if(count($tracker_rows) > 0){
			foreach($tracker_rows as $tracker_row){
				$tracker_ids[] =  $tracker_row['id'];
				
				$bid_row=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$tracker_row['worker_id'])));
				
				$client_amt = $bid_row['total_amt'];
				$minute_cost_min = ($client_amt/60);
				$total_min_cost = $minute_cost_min *floatval($tracker_row['minute']);
				$cost_n=(($client_amt*floatval($tracker_row['hour']))+$total_min_cost);
				$cost_n=round($cost_n , 2);
				$total_cost_new += $cost_n;
			}
			
			$total_deposit = get_project_deposit($project_id);
			$total_release = get_project_release_fund($project_id);
			$total_pending = get_project_pending_fund($project_id);
			$remaining_bal = $total_deposit - $total_release - $total_pending;
			
			$remaining_deposit = $total_deposit - $total_release;
			
			$commission = (($total_cost_new * SITE_COMMISSION) / 100) ; 
			
			if($remaining_deposit < $total_cost_new){
				//  employer has no enough balance in his deposit
				$msg['msg'] = '<div class="info-error">'.__('not_enough_balance_in_your_project_deposit','Not enough balance in your project deposit').'</div>';
				$msg['status']=0;
				$error++;
			}
			
			if($error == 0){
				
				$this->load->helper('invoice');
				
				$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $invoice_row['sender_id'])));
					
				$sender_info = array(
					'name' => SITE_TITLE,
					'address' => ADMIN_ADDRESS,
				);
				$receiver_info = array(
					'name' => $user_info['fname'].' '.$user_info['lname'],
					'address' => getUserAddress($user_info['user_id']),
				);
				
				$invoice_data = array(
					'sender_id' => 0,
					'receiver_id' => $user_info['user_id'],
					'invoice_type' => 3,
					'sender_information' => json_encode($sender_info),
					'receiver_information' => json_encode($receiver_info),
					'receiver_email' => $user_info['email'],
				
				);
				
				$inv_id = create_invoice($invoice_data); // creating invoice
				
				$invoice_row_data = array(
					'invoice_id' => $inv_id,
					'description' => 'Commission - ' . SITE_COMMISSION . '% for invoice number #'.$invoice_number,
					'per_amount' => $commission,
					'unit' => '-',
					'quantity' => 1,
				);
				
				add_invoice_row($invoice_row_data); // adding invoice row
				
				add_project_invoice($project_id, $inv_id);
				
				$this->load->model('myfinance/transaction_model');
				
				$ref = $invoice_id;
				
				// transaction insert
				$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user_id);
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $total_cost_new, 'ref' => $ref , 'info' => '{Project_payment_to_freelancer} #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => $total_cost_new, 'ref' => $ref , 'info' => '{Project_payment_received} #'.$project_id));
				
				$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $freelancer_id, 'Y', $inv_id);
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $freelancer_wallet_id, 'debit' => $commission, 'ref' => $inv_id , 'info' => '{Commission_paid} #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $inv_id, 'info' => '{Commission_received}'));
				
				wallet_less_fund(ESCROW_WALLET,  $total_cost_new);
			
				wallet_add_fund($freelancer_wallet_id, ($total_cost_new-$commission));
				wallet_add_fund(PROFIT_WALLET, $commission);
				
				check_wallet($freelancer_wallet_id,  $new_txn_id);
				
				check_wallet(ESCROW_WALLET,  $new_txn_id);
				check_wallet(PROFIT_WALLET,  $new_txn_id);
				
				$this->db->where_in('id', $tracker_ids)->update('project_tracker', array('status' => '1', 'payment_status' => 'P', 'commission_invoice_id' => $inv_id));
				
				$project_txn = array(
					'project_id' => $project_id,
					'txn_id' => $new_txn_id,
				);
				
				$this->db->insert('project_transaction', $project_txn);
				
				$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
				$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
				
				$msg['status']=1;
			}
			

		}
		
		return $msg;
	}
	
	public function deny_hourly_invoice($invoice_id='', $project_id=''){
		
		$msg = array();
		
		$del_invoice = $this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_deleted' => date('Y-m-d H:i:s')));
		
		$tracker_rows = get_results(array('select' =>'*', 'from' => 'project_tracker' ,  'where' => array('invoice_id' => $invoice_id, 'payment_status <>' => 'P')));
		
		$tracker_ids = array();
		
		if(count($tracker_rows) > 0){
			foreach($tracker_rows as $tracker_row){
				$tracker_ids[] =  $tracker_row['id'];
			}
			
			$this->db->where_in('id', $tracker_ids)->update('project_tracker', array('status' => '1', 'payment_status' => 'C', 'commission_invoice_id' => 0, 'invoice_id' => 0));
			
		}
		
		$msg['status']=1;
		
		return $msg;
	}
	
	
	public function pay_fixed_invoice($invoice_id='', $project_id=''){
		
		$msg = array();
		$user = $this->session->userdata('user');
		
		$st = 'A';
		
		$invoice_row = get_row(array('select' =>'*', 'from' => 'invoice_main' ,  'where' => array('invoice_id' => $invoice_id, 'is_paid' => '0000-00-00 00:00:00', 'is_deleted' => '0000-00-00 00:00:00')));
		
		if(!$invoice_row){
			$msg['status'] = 0;
			$msg['msg'] = 'Invalid request';
			return $msg;
		}
		
		$this->load->model('myfinance/transaction_model');
		$this->load->model('myfinance/myfinance_model');
		$this->load->helper('invoice');
		$milestone_id = getField('id', 'project_milestone', 'invoice_id', $invoice_id);
		$invoice_number = $this->auto_model->getFeild("invoice_number","invoice_main","invoice_id",$invoice_id);
		$milestone_title = $this->auto_model->getFeild("title","project_milestone","id",$milestone_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		
		$acc_balance=get_wallet_balance($user_wallet_id);
			
			
		$pln_id=$this->auto_model->getFeild('membership_plan','user','user_id',$user[0]->user_id);
		
		$bidwin_charge=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$pln_id);
		
		$bid_id = $this->auto_model->getFeild("bid_id","project_milestone","id",$milestone_id);
		
		$bidder_id = $this->auto_model->getFeild("bidder_id","bids","id",$bid_id);
		$project_id = $pid = $this->auto_model->getFeild("project_id","bids","id",$bid_id);
		$employer_id = $this->auto_model->getFeild("user_id","projects","project_id",$pid);
		
		$milestone_amount = $this->auto_model->getFeild("amount","project_milestone","id",$milestone_id);
		
		
		if(empty($project_id) || empty($milestone_id)){
			$msg['status'] = 0;
			$msg['msg'] = 'Invalid request';
			
			return $msg;
			
		}
		
		$commission = (($milestone_amount * SITE_COMMISSION) / 100) ; 
		
		$bidder_to_pay = $milestone_amount - $commission;
		
		$post_data['bider_to_pay']=$bidder_to_pay;
		
		
		$post_data['employer_id'] =$employer_id;
		$post_data['project_id'] = $pid;
		$post_data['milestone_id'] = $milestone_id;
		
	   
		$post_data['worker_id'] = $bidder_id;
		
		$post_data['payamount'] = $milestone_amount;
		$post_data['commission'] = $commission;
	  
		$post_data['reason_txt'] = $this->auto_model->getFeild("description","project_milestone","id",$milestone_id); 
		
		$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $bidder_id)));
		
		$sender_info = array(
			'name' => SITE_TITLE,
			'address' => ADMIN_ADDRESS,
		);
		$receiver_info = array(
			'name' => $user_info['fname'].' '.$user_info['lname'],
			'address' => getUserAddress($user_info['user_id']),
		);
		
		$invoice_data = array(
			'sender_id' => 0,
			'receiver_id' => $bidder_id,
			'invoice_type' => 3,
			'sender_information' => json_encode($sender_info),
			'receiver_information' => json_encode($receiver_info),
			'receiver_email' => $user_info['email'],
		
		);
		
		$inv_id = create_invoice($invoice_data); // creating invoice
		
		$invoice_row_data = array(
			'invoice_id' => $inv_id,
			'description' => 'Commission - ' . SITE_COMMISSION . '% for invoice number #'.$invoice_number,
			'per_amount' => $commission,
			'unit' => '-',
			'quantity' => 1,
		);
		
		add_invoice_row($invoice_row_data); // adding invoice row
		
		add_project_invoice($pid, $inv_id);
			
		$post_data['commission_invoice_id'] = $inv_id;
	
		$escrow_check = $this->db->where(array('milestone_id' => $milestone_id, 'status' => 'P', 'project_id' => $project_id))->get('escrow_new')->row_array();
	
		$ref1 = json_encode(array('project_id' => $pid, 'project_type' => 'F', 'milestone_id' => $milestone_id));
		
		if(!empty($escrow_check)){
			
			$bidder_wallet_id = get_user_wallet($bidder_id);
			
			// deduct milestone amount from escrow and transfer the amount in freelancer account
			
			// transaction insert
			$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user[0]->user_id);
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $escrow_check['amount'], 'ref' => $escrow_check['escrow_id'], 'info' => '{Freelancer_payment_through_escrow_wallet}'));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $bidder_wallet_id, 'credit' => $escrow_check['amount'] , 'ref' => $milestone_id, 'info' => '{Project_payment}'));
			
			$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $bidder_id, 'Y', $inv_id);
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $bidder_wallet_id, 'debit' => $commission , 'ref' => $milestone_id, 'info' => '{Commission_deducted} #'.$pid));
			
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $milestone_id, 'info' => '{Commission_received}'));
			
			
			wallet_less_fund(ESCROW_WALLET,$escrow_check['amount']);
			
			wallet_add_fund($bidder_wallet_id, $bidder_to_pay);
			
			wallet_add_fund(PROFIT_WALLET, $commission);
			
			check_wallet($bidder_wallet_id,  $new_txn_id);
			check_wallet(ESCROW_WALLET,  $new_txn_id);
			check_wallet(PROFIT_WALLET,  $new_txn_id);
			
			$project_txn = array(
				'project_id' => $project_id,
				'txn_id' => $new_txn_id,
			);
			
			$this->db->insert('project_transaction', $project_txn);
			
			$this->db->where('escrow_id', $escrow_check['escrow_id'])->update('escrow_new', array('status' => 'R'));
			
			$insert = $this->myfinance_model->insertMilestone($post_data);
			
			$val['fund_release']=$st;
			$val['commission_invoice_id']=$inv_id;
			$where=array("id"=>$milestone_id);
			$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
			
			$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
			$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); 
			
			if($upd){
				
				$flg="S";	
				
			}else{
				
				$flg="D";	
			}
			
		}else{
			
			if($acc_balance >= $post_data['payamount']){
				$insert = $this->myfinance_model->insertMilestone($post_data);
				
				if($insert){ 
					
						$milestone_pay_amount = $milestone_amount;
						// pay freelancer through employer wallet 
						
						$bidder_wallet_id = get_user_wallet($bidder_id);
					
						// transaction insert
						$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_DIRECT,  $user[0]->user_id);
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $milestone_pay_amount, 'ref' => $milestone_id, 'info' => '{Project_payment_to_freelancer}'));
						
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $bidder_wallet_id, 'credit' => $milestone_pay_amount, 'ref' => $milestone_id, 'info' => '{Project_payment_received} #'.$pid));
						
						$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $bidder_id, 'Y', $inv_id);
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $bidder_wallet_id, 'debit' => $commission, 'ref' => $milestone_id, 'info' => '{Commission_deducted} #'.$pid));
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $milestone_id, 'info' => '{Commission_received}'));
						
						
						wallet_less_fund($user_wallet_id,$milestone_pay_amount);
						
						wallet_add_fund($bidder_wallet_id, $bidder_to_pay);
						
						wallet_add_fund(PROFIT_WALLET, $commission);
						
						check_wallet($bidder_wallet_id,  $new_txn_id);
						
						check_wallet($user_wallet_id,  $new_txn_id);
						
						check_wallet(PROFIT_WALLET,  $new_txn_id);
						
						$project_txn = array(
							'project_id' => $project_id,
							'txn_id' => $new_txn_id,
						);
						
						$this->db->insert('project_transaction', $project_txn);
			
				} 
				
				$val['fund_release']=$st;
				$val['commission_invoice_id']=$inv_id;
				$where=array("id"=>$milestone_id);
				$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
				
				$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
			
				$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); 
			
				if($upd){
					$flg="S";	
				}else{
					$flg="D";	
				}
				
			}else{
				$flg="I";	
			}
		
		}
		
		if($flg){
			if($flg=='S'){
				$from=ADMIN_EMAIL;
				$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
				$employer_id= $this->auto_model->getFeild('user_id','projects','project_id',$project_id);
				$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
				$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
				$template='payment_release';
				$data_parse=array('name'=>$fname." ".$lname,
									'title'=>$project_title,
									'amount'=>$post_data['bider_to_pay']
									);
				
				send_layout_mail($template, $data_parse, $to_mail);
				
				$to_mail=$this->auto_model->getFeild('email','user','user_id',$employer_id);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$employer_id);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$employer_id);
				$template='payment_release_employer';
				$data_parse=array('name'=>$fname." ".$lname,
									'title'=>$project_title,
									'amount'=>$post_data['bider_to_pay']
									);
				send_layout_mail($template, $data_parse, $to_mail);
				
				
				$from=ADMIN_EMAIL;
				$to=ADMIN_EMAIL;
				$template='add_fund_escrow';
				$data_parse=array('title'=>$project_title
				);
				$this->auto_model->send_email($from,$to,$template,$data_parse);
				
				
			}elseif($flg=='P'){
				$from=ADMIN_EMAIL;
				$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
				$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
				$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
				$template='fund_declined';
				$data_parse=array('name'=>$fname." ".$lname,
									'title'=>$project_title,
									);
				$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
				
				$post_data['employer_id'] =$this->auto_model->getFeild("employer_id","project_milestone","id",$milestone_id);					
			
				$notification = "{you_have_declined_the_Fund_request_for_milestone}: ".$milestone_title." {for_project} ".$project_title;
				$link = "projectdashboard_new/milestone_employer/".$project_id;
				$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
				
				$notification1 = "{your_Fund_request_declined_for_milestone}: ".$milestone_title." {for_the_project} ".$project_title;
				$link1 = "projectdashboard_new/milestone_freelancer/".$project_id;
				$this->notification_model->log($post_data['employer_id'], $bidder_id, $notification1, $link1);
			
				
				$this->session->set_flashdata('succ_msg',__('congratulation_you_have_declined_the_request',"Congratulation!! You have declined the request."));
				
			}elseif($flg=='I'){
				
				$msg['status'] = 0;
				$msg['msg'] = __('you_do_not_have_enough_balance_in_your_wallet','Oops!! You have insufficient fund in your wallet. Please add fund in your wallet.');	
				
				return $msg;
			
				
			}elseif($flg=='D'){
				$msg['status'] = 0;
				$msg['msg'] = __('oops','Oops!! Something got wrong. Please try again later.');	
				
				return $msg;
			}
		}else{
			$msg['status'] = 0;
			$msg['msg'] = __('oops','Oops!! Something got wrong. Please try again later.');
			
			return $msg;
		}
		
		$data_milistone=array(
			"release_type" =>"P",
			"status" => "Y"
		);
		$mid=$this->auto_model->getFeild("id","milestone_payment","milestone_id",$milestone_id); 
        $this->myfinance_model->updateMilestone($data_milistone,$mid);
		
		$val['release_payment']='Y';
		$val['fund_release']='A';
		$where=array("id"=>$milestone_id);
		$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
		
		$return_row=$this->myfinance_model->checkproject_milestone($pid);
		if($return_row==0){
			$proj_data['status']='C';
			$this->myfinance_model->updateProject($proj_data,$pid);
		}
		
		$from=ADMIN_EMAIL;
		$to_id= $bidder_id;
		$title=$this->auto_model->getFeild('title','projects','project_id',$pid);
		$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
		$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
		$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
		$template='milestone_release_notification';
		$data_parse=array('name'=>$fname." ".$lname,
							'title'=>$title
							);
		$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
		
		$bidder_id=$to_id;
		$employer_id=$user[0]->user_id;
		$projects_title=$title;
		
		$notification = htmlentities("{you_have_successfully_release_milestone}: ".$milestone_title." {for_the_project} ".$projects_title);
		$link = "projectdashboard_new/employer/milestone/".$pid;
		$this->notification_model->log($employer_id, $employer_id, $notification, $link);
			
			
		$notification1 = htmlentities("{payment_received_for_milestone}: ".$milestone_title." {for_the_project}  ".$projects_title);
		
		$link1 = "projectdashboard_new/freelancer/milestone/".$pid;
		$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
		
		$msg['status'] = 1;
		
		return $msg;
		
	}
	
	public function deny_fixed_invoice($invoice_id='', $project_id=''){
		$this->load->model('myfinance/myfinance_model');
		$msg = array();
		$user=$this->session->userdata('user');
		$id = getField('id', 'project_milestone', 'invoice_id', $invoice_id);
		$pid = $this->auto_model->getFeild("project_id","project_milestone","id",$id);
		$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$id);
		$milestone_title = $this->auto_model->getFeild("title","project_milestone","id",$id);
		$employer_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
		$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$pid);
		$val['release_payment']='C';
		$val['invoice_id']=0;
		$where=array("id"=>$id);
		$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_deleted' => date('Y-m-d H:i:s')));
		$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
		if($upd){
			$from=ADMIN_EMAIL;
			$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
			$project_title= $this->auto_model->getFeild('title','projects','project_id',$pid);
			$template='payment_declined_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
			$notification = "{you_have_declined_the_payment_for_milestone}: ".$milestone_title." for project: ".$project_title;
			$link = "projectdashboard_new/employer/milestone/".$pid;
			$this->notification_model->log($employer_id, $employer_id, $notification, $link);
			
			$notification1 = "{payment_have_been_canceled_for_milestone}: ".$milestone_title." for the project ".$project_title;
			$link1 = "projectdashboard_new/freelancer/milestone/".$pid;
			$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
		}
		
		$msg['status'] = 1;
		
		return $msg;
	}
 
}
