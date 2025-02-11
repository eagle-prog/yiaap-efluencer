<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projectdashboard_new extends MX_Controller {
	
	public $min_deposit = 0;
  
    public function __construct() {
        $this->load->model('projectdashboard_model');
        parent::__construct();
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('notification/notification_model');
		$idiom = $this->session->userdata('lang');
		$this->lang->load('projectdashboard',$idiom);
		
		$this->load->helper('project');
		
		$this->min_deposit = getField('hourly_project_deposit', 'setting', 'id', 1);
		
		$this->_checkProjects();
		
    }

    public function index($project_id='') {
		$data = array();
		$this->layout->view('index','',$data,'normal');   
    }
	
	public function freelancer($fun='', $project_id='') {

		$data = array();
		if($fun == 'overview'){
			$this->freelancer_overview($project_id);
		}else if($fun == 'milestone'){
			$this->freelancer_milestone($project_id);
		}
		
		
    }
	
	public function employer($fun='', $project_id='') {
		$data = array();
		
		if($fun == 'overview'){
			$this->employer_overview($project_id);
		}else if($fun == 'milestone'){
			$this->employer_milestone($project_id);
		}
		
		
    }
	
	/* Freelancer */
	private function freelancer_overview($project_id=''){
	
		$data = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		
		if(!is_bidder($user_id, $project_id)){
			//show_404();
			redirect(VPATH.'pagenotfound');
			exit;
			return;
		}
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id);  // global use
		$data['project_type']= $project_type = $data['project_detail']['project_type']; // global use
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		$data['employer_detail'] = $this->db->where('user_id', $data['project_detail']['user_id'])->get('user')->row_array();
		//get_print($data, false);
		
		if($project_type == 'H'){
			$data['project_schedule'] = $this->projectdashboard_model->getProjectScheduleFreelancer($project_id, $user_id);
			$data['request'] = $this->projectdashboard_model->getProjectRequestFreelancer($project_id, $user_id);
			
			$data['is_scheduled'] = count($data['project_schedule']) > 0 ? TRUE : FALSE;
			$data['is_requested'] = count($data['request']) > 0 ? TRUE : FALSE;
			
		}else{
			
		}
		//get_print($data, false);
		
		$data['feedback'] = $this->projectdashboard_model->getProjectFeedback($project_id);
		$breadcrumb=array(
			array(
					'title'=>__('projectdashboard_project_overview','Project overview'),'path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('projectdashboard_project_overview','Project overview'));
		$data['active_tab'] = 'overview';
		if($project_type == 'H'){
			$this->layout->view('freelancer_overview_hourly','',$data,'normal');   
		}else{
			$this->layout->view('freelancer_overview_fixed','',$data,'normal');   
		}
		
	}
	
	private function freelancer_milestone($project_id=''){
		$data = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		
		if(!is_bidder($user_id, $project_id)){
			//show_404();
			redirect(VPATH.'pagenotfound');
			exit;
			return;
		}
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id);  // global use
		$data['project_type']= $project_type = $data['project_detail']['project_type']; // global use
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		$data['employer_detail'] = $this->db->where('user_id', $data['project_detail']['user_id'])->get('user')->row_array();
		
		$data['bid_detail'] = $this->db->where(array('project_id' => $project_id, 'bidder_id' => $user_id))->get('bids')->row_array(); // freelancer bid detail
		if($project_type == 'H'){
			
			$data['project_schedule'] = $this->projectdashboard_model->getProjectScheduleFreelancer($project_id, $user_id);
			$data['request'] = $this->projectdashboard_model->getProjectRequestFreelancer($project_id, $user_id);
			
			$data['is_scheduled'] = count($data['project_schedule']) > 0 ? TRUE : FALSE;
			$data['is_requested'] = count($data['request']) > 0 ? TRUE : FALSE;
			
			$data['tracker_details'] = $this->projectdashboard_model->getprojecttracker($project_id, $user_id);
			$data['manual_tracker_details']=$this->projectdashboard_model->getprojecttracker_manual($project_id);
			foreach($data['manual_tracker_details'] as $key =>$val){
				$data['manual_tracker_details'][$key]['acti']=$this->getActivity($val['activity']);
			}
		
		}else{
			$data['set_milestone_list']=$this->projectdashboard_model->getsetMilestone($project_id);
		
		}
		$breadcrumb=array(
			array(
					'title'=>__('projectdashboard_project_milestone','Project milestone'),'path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('projectdashboard_project_milestone','Project milestone'));
		$data['active_tab'] = 'milestone';
	
		if($project_type == 'H'){
			$this->layout->view('freelancer_milestone_hourly','',$data,'normal');   
		}else{
			$this->layout->view('freelancer_milestone_fixed','',$data,'normal');   
		}
		
	}
	
	public function getActivity($act=''){
		
		$res=array();
		if(!empty($act)){
			$res = $this->db->where("id IN($act)")->get('project_activity')->result_array();
		
		}
		return $res;
	
	}
			
	
	/* Employer */
	private function employer_overview($project_id=''){
		$data = array();
		$data['min_deposit'] = $this->min_deposit;
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		
		if(!is_employer($user_id, $project_id)){
			//show_404();
			redirect(VPATH.'pagenotfound');
			exit;
			return;
		}
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id);  // global use
		$data['project_type']= $project_type = $data['project_detail']['project_type']; // global use
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		if($project_type == 'H'){
			$data['project_schedule'] = $this->projectdashboard_model->getProjectSchedule($project_id);
			$data['request'] = $this->projectdashboard_model->getProjectRequest($project_id);
			
			$data['is_scheduled'] = count($data['project_schedule']) > 0 ? TRUE : FALSE;
			$data['is_requested'] = count($data['request']) > 0 ? TRUE : FALSE;
			
			$data['activity_list'] = $this->projectdashboard_model->getProjectActivity($project_id);
			
			
		}else{
			
			
		}
		
		$data['feedback'] = $this->projectdashboard_model->getProjectFeedback($project_id);
		
		//get_print($data);
		$breadcrumb=array(
			array(
					'title'=>__('projectdashboard_project_overview','Project overview'),'path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('projectdashboard_project_overview','Project overview'));
		$data['active_tab'] = 'overview';
		if($project_type == 'H'){
			$this->layout->view('employer_overview_hourly','',$data,'normal');   
		}else{
			$this->layout->view('employer_overview_fixed','',$data,'normal');   
		}
	}
	
	private function employer_milestone($project_id=''){
		$data = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		
		if(!is_employer($user_id, $project_id)){
			//show_404();
			redirect(VPATH.'pagenotfound');
			exit;
			return;
		}
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id); 
		$data['project_type']= $project_type = $data['project_detail']['project_type'];
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
			/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		$data['employer_detail'] = $this->db->where('user_id', $data['project_detail']['user_id'])->get('user')->row_array();
		
		//get_print($data, false);
		
		if($project_type == 'H'){
			
			$data['project_schedule'] = $this->projectdashboard_model->getProjectScheduleFreelancer($project_id, $user_id);
			$data['request'] = $this->projectdashboard_model->getProjectRequestFreelancer($project_id, $user_id);
			
			$data['is_scheduled'] = count($data['project_schedule']) > 0 ? TRUE : FALSE;
			$data['is_requested'] = count($data['request']) > 0 ? TRUE : FALSE;
			
			
			$data['tracker_details'] = $this->projectdashboard_model->getprojecttracker($project_id);
			
			$data['manual_tracker_details']=$this->projectdashboard_model->getprojecttracker_manual($project_id);
			
			foreach($data['manual_tracker_details'] as $key =>$val){
				$data['manual_tracker_details'][$key]['acti']=$this->getActivity($val['activity']);
			}
		
		}else{
			
			$data['set_milestone_list']=$this->projectdashboard_model->getsetMilestone($project_id);
			
			$data['outgoint_milestone_list']=$this->projectdashboard_model->getOutgoingMilestone($data['user_id']);
			$data['incoming_milestone_list']=$this->projectdashboard_model->getIncomingMilestone($data['user_id']);
		
		}
		
		//get_print($data, false);
		$breadcrumb=array(
			array(
					'title'=>__('projectdashboard_project_milestone','Project milestone'),'path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('projectdashboard_project_milestone','Project milestone'));
		$data['active_tab'] = 'milestone';
		
		if($project_type == 'H'){
			$this->layout->view('employer_milestone_hourly','',$data,'normal'); 
		}else{
			$this->layout->view('employer_milestone_fixed','',$data,'normal'); 
		}
		
	}
	
	
	public function request_date_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request()){
			$post = post();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('start_date', 'start date', 'required');
			$this->form_validation->set_rules('comment', 'comment', 'required');
			$this->form_validation->set_rules('project_id', 'project', 'required');
			
			if($this->form_validation->run()){
				$post['freelancer_id'] = $user_id;
				$post['status'] = 'P';
				
				$project_id = $post['project_id']; 
				$project_title = getField('title', 'projects', 'project_id', $project_id);
				$project_user = getField('user_id', 'projects', 'project_id', $project_id);
				$freelancer = getField('fname', 'user', 'user_id', $user_id);
				if(!empty($post['request_id'])){
					$req_id = $post['request_id'];
					unset( $post['request_id']);
					
					$ins['data'] = $post;
					$ins['where'] = array('request_id' => $req_id);
					$ins['table'] = 'project_start_request';
					
					update($ins);
					
					$notification = "$freelancer {updated_project_start_date_for} $project_title";
					$link = 'projectroom/employer/overview/'.$project_id;
					$this->notification_model->log($user_id, $project_user, $notification, $link);
					
					
				}else{
					$ins['data'] = $post;
					$ins['table'] = 'project_start_request';
					
					$req_id = insert($ins, TRUE);
					
					$notification = "$freelancer {request_a_project_start_date_for} $project_title";
					$link = 'projectroom/employer/overview/'.$project_id;
					$this->notification_model->log($user_id, $project_user, $notification, $link);
		 
				}
				
				
				$json['status'] = 1;
				$json['data']['request_id'] = $req_id;
			}else{
				$json['errors'] = validation_errors_array();
				$json['status'] = 0;
			}
			
			echo json_encode($json);
			
		}
	}
	
	public function confirm_request(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$req_id = post('request_id');
			$action = post('action');
			
			$req_row = $this->db->where('request_id', $req_id)->get('project_start_request')->row_array();
			
			if(!is_employer($user_id , $req_row['project_id'])){
				$json['status'] = 0;
				$json['errors']['request'] = 'Invalid Request';
				
			}else{
				
			
			
				if($action == 'A'){
					// request approved
					
					if(!empty($req_row)){
						$p_schedule = array(
							'project_id' => $req_row['project_id'],
							'freelancer_id' => $req_row['freelancer_id'],
							'project_start_date' => $req_row['start_date'],
							
						);
						
						$this->db->insert('project_schedule', $p_schedule);
						
						$json['status'] = 1;
						$json['data']['schedule_id'] = $this->db->insert_id();
						
						$this->db->where('request_id', $req_row['request_id'])->update('project_start_request', array('status' => 'A'));
						
						$project_title = getField('title', 'projects', 'project_id', $req_row['project_id']);
						$notification = "{you_request_for_project} $project_title {has_been_accepted}";
						$link = 'projectroom/freelancer/overview/'.$req_row['project_id'];
						
						$this->notification_model->log($user_id, $req_row['freelancer_id'], $notification, $link);
						
						$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $req_row['project_id']);
						
					}else{
						$json['status'] = 0;
						$json['errors']['request'] = 'Invalid Request';
					}
					
					
					
				}else{
					
					if(!empty($req_row)){
						
						$this->db->where('request_id', $req_row['request_id'])->update('project_start_request', array('status' => 'R'));
						$json['status'] = 1;
						
						$project_title = getField('title', 'projects', 'project_id', $req_row['project_id']);
						$notification = "{you_request_for_project} $project_title {has_been_rejected}";
						$link = 'projectdashboard_new/freelancer/overview/'.$req_row['project_id'];
						
						$this->notification_model->log($user_id, $req_row['freelancer_id'], $notification, $link);
						
						
					}else{
						$json['status'] = 0;
						$json['errors']['request'] = 'Invalid Request';
					}
					
				}
			}
			
			echo json_encode($json);
		}
	}
	
	private function _checkProjects(){
		$this->projectdashboard_model->startScheduledProject();
	}
	
	
	/* Add project fund */ 
	public function add_project_fund(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request()){
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('amount', 'amount', 'required');
			$this->form_validation->set_rules('project_id', 'project', 'required');
			
			if($this->form_validation->run()){
				
				$project_id = post('project_id');
				$amount = post('amount');
				
				$user_wallet_id = get_user_wallet($user_id);
				$wallet_balance = get_wallet_balance($user_wallet_id);
				
				if($amount > $wallet_balance){
					$json['errors']['balance'] = '<div class="info-error">'.__('you_do_not_have_enough_balance_in_your_wallet','You don\'t have enough balance in your wallet . ').'</div>';

					$json['status'] = 0;
					
				}else{
					// add fund
					$this->load->model('myfinance/transaction_model');
					
					$ref = json_encode(array('project_id' => $project_id, 'added_amount' => $amount));
					
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FUND_ADDED_DIRECT,  $user_id);
					
					
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $amount, 'ref' => $ref , 'info' => '{Project_fund_deposited} #'.$project_id));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'credit' => $amount, 'ref' => $ref , 'info' => '{Project_fund_deposited} #'.$project_id));
					
					wallet_less_fund($user_wallet_id,  $amount);
				
					wallet_add_fund(ESCROW_WALLET, $amount);
					
					check_wallet($user_wallet_id,  $new_txn_id);
					
					check_wallet(ESCROW_WALLET,  $new_txn_id);
					
					$project_txn = array(
						'project_id' => $project_id,
						'txn_id' => $new_txn_id,
					);
					
					$this->db->insert('project_transaction', $project_txn);
					
					$project_title = getField('title', 'projects', 'project_id', $project_id);
					
					$notification = "{fund_successfully_added_for_project} <b>$project_title </b>";
					$link = 'projectdashboard_new/employer/overview/'.$project_id; 
					$this->notification_model->log($user_id, $user_id, $notification, $link);
					
					
					$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $project_id);
					
					$json['status'] = 1;
				}
				
			}else{
				$json['errors'] = validation_errors_array();
				$json['status'] = 0;
			}
			
			echo json_encode($json);
		}
	}

	
	
	
	public function add_manual_hour($pid=''){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $bidder_id = $user[0]->user_id;
		$this->load->helper('invoice');
		if(post() && $this->input->is_ajax_request() && $user_id && $pid){
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('start_date', 'start date', 'required');
			$this->form_validation->set_rules('to_date', 'to date', 'required');
			$this->form_validation->set_rules('duration', 'duration', 'required|numeric');
			
			if($this->form_validation->run()){
				
				$act = $this->input->post("activity");   
				$post_data["project_id"]=  $pid;
				$post_data["worker_id"]=  $user_id;
				$post_data["start_time"]=  $this->input->post("start_date");
				$post_data["stop_time"]=  $this->input->post("to_date");
				$post_data["hour"]=  $this->input->post("duration");
				$post_data["minute"]=  $this->input->post("minute");
				/* $post_data["activity"] = !empty($act) ? implode(',', $act) : '' ; */
				$post_data["note"] = $this->input->post('comment');
				$post_data["is_manual"] = 1;
				
				$insert_r['data'] = $post_data;
				$insert_r['table'] = 'project_tracker';
				$insert = insert($insert_r);
				//$insert=  $this->projectdashboard_model->insertTrackerManual($post_data);
				$employer_id = $this->auto_model->getFeild('user_id','projects','project_id',$pid);
				$projects_title = $this->auto_model->getFeild('title','projects','project_id',$pid);
				
				/* $invoice['data'] = array(
					'project_id' => $pid,
					'project_type' => 'H',
					'created_date' => date('Y-m-d'),
					'milestone_id' => $insert,
					'payment_status' => 'NOT PAID',
					'hr' => $this->input->post("duration"),
				);
				
				$invoice['table'] = 'invoice';
				$invoice_id = insert($invoice, TRUE); */
				
				/* $user_info = get_row(array('select' => 'fname,lname,email,user_id','from' => 'user', 'where' => array('user_id' => $user_id)));
				
				$user_info2 = get_row(array('select' => 'fname,lname,email,user_id','from' => 'user', 'where' => array('user_id' => $employer_id)));
				
				$sender_info = array(
					'name' => $user_info['fname'].' '.$user_info['lname'],
					'address' => getUserAddress($user_id),
				);
				$receiver_info = array(
					'name' => $user_info2['fname'].' '.$user_info2['lname'],
					'address' => getUserAddress($employer_id),
				);
				
				$invoice_data = array(
					'sender_id' => $user_id,
					'receiver_id' => $employer_id,
					'invoice_type' => 1,
					'sender_information' => json_encode($sender_info),
					'receiver_information' => json_encode($receiver_info),
					'receiver_email' => $user_info2['email'],
				
				);
				
				$inv_id = create_invoice($invoice_data); // creating invoice
				
				$total_cost_new = 0;
				
				$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$pid,'bidder_id'=>$post_data['worker_id'])));
				 
				$client_amt = $data['total_amt'];
			
				
				$minute_cost_min = ($client_amt/60);
				$total_min_cost = $minute_cost_min *floatval($post_data["minute"]);
				$total_cost_new=(($client_amt*floatval($post_data['hour']))+$total_min_cost);
				$total_hours = floatval($post_data['hour']);
				$total_mins = floatval($post_data['minute']);
				$total_dur = ((($post_data['hour']*60)+$post_data['minute'])/60);
				
				$invoice_row_data = array(
					'invoice_id' => $inv_id,
					'description' => $projects_title,
					'per_amount' => $data['total_amt'],
					'unit' => 'Hour',
					'quantity' => $total_dur,
				);
				
				add_invoice_row($invoice_row_data); // adding invoice row
				
				add_project_invoice($pid, $inv_id);
				
				$this->db->where(array('id' => $insert))->update('project_tracker', array('invoice_id' => $inv_id)); */
				
				$postdata['to_id']=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
				$postdata['from_id']=$bidder_id;
				$title=$this->auto_model->getFeild('title','projects','project_id',$pid);
				$username=$this->auto_model->getFeild('username','user','user_id',$bidder_id);
				
				$notification = '{manual_hour_requested_by} '.$username.' {for_project} '.$title;
				$link = 'projectdashboard_new/employer/milestone/'.$pid;
				$this->notification_model->log($postdata['from_id'], $postdata['to_id'], $notification, $link);
				
				$from=ADMIN_EMAIL;
				$to=$this->auto_model->getFeild('email','user','user_id',$postdata['to_id']);
				$employer=$this->auto_model->getFeild('username','user','user_id',$postdata['to_id']);
				$template='manual_hour_request_freelancer';
				$data_parse=array('username'=>$employer,
								  'freelancer'=>$username,
								  'project'=>$title
								  );
				$this->auto_model->send_email($from,$to,$template,$data_parse);
				
				$json['status'] = 1;
				
				$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $pid);
				
			}else{
				$json['status'] = 0;
				$json['errors'] = validation_errors_array();
			}
			
			echo json_encode($json);
		}
		
	}
	
	public function hour_edit_request_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$post = post();
			
			$manual_tracker_id = post('manual_tracker_id');
			$type = post('hour_type');
			
			unset($post['manual_tracker_id']);
			unset($post['hour_type']);
			
			$upd['data'] = array(
				'employer_request' => json_encode($post)
			);
			$upd['where'] = array('id' => $manual_tracker_id);
			
			if($type == 'tracker'){
				$upd['table'] = 'project_tracker';
			}else{
				$upd['table'] = 'project_tracker_manual';
			}
			
			
			update($upd);
			
			$json['status'] = 1;
			
			set_flash('succ_msg', __('request_successfully_send','Request Successfully Send'));
			
			if($type == 'tracker'){
				$tracker_row = get_row(array('select' =>'*', 'from' => 'project_tracker' ,  'where' => array('id' => $manual_tracker_id)));
			}else{
				$tracker_row = get_row(array('select' =>'*', 'from' => 'project_tracker_manual' ,  'where' => array('id' => $manual_tracker_id)));
			}
			
			$pid = $tracker_row['project_id'];
			$f_user_id =  $tracker_row['worker_id'];
			$title = getField('title', 'projects', 'project_id', $pid);
			$employer = getField('fname', 'user', 'user_id', $user_id);
			
			$notification = "$employer {edit_request_for} $title";
			$link = 'projectdashboard_new/freelancer/milestone/'.$pid;
			$this->notification_model->log($user_id, $f_user_id, $notification, $link);
				
				
			echo json_encode($json);
			
		}
	}
	
	public function hour_edit_ajax(){
		$this->load->helper('invoice');
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$post = post();
			
			$manual_tracker_id = post('manual_tracker_id');
			
			unset($post['manual_tracker_id']);
			
			$upd['data'] = $post;
			$upd['where'] = array('id' => $manual_tracker_id);
			$upd['table'] = 'project_tracker_manual';
			
			update($upd);
			$json['status'] = 1;
			
			
			$tracker_row = get_row(array('select' =>'*', 'from' => 'project_tracker_manual' ,  'where' => array('id' => $manual_tracker_id)));
			
			$pid = $tracker_row['project_id'];
			
			$employer_id = getField('user_id', 'projects', 'project_id', $tracker_row['project_id']);
			
			$user_info = get_row(array('select' => 'fname,lname,email,user_id','from' => 'user', 'where' => array('user_id' => $tracker_row['worker_id'])));
				
			$user_info2 = get_row(array('select' => 'fname,lname,email,user_id','from' => 'user', 'where' => array('user_id' => $employer_id)));
			
			$sender_info = array(
				'name' => $user_info['fname'].' '.$user_info['lname'],
				'address' => getUserAddress($tracker_row['worker_id']),
			);
			$receiver_info = array(
				'name' => $user_info2['fname'].' '.$user_info2['lname'],
				'address' => getUserAddress($employer_id),
			);
			
			$invoice_data = array(
				'sender_id' => $tracker_row['worker_id'],
				'receiver_id' => $employer_id,
				'invoice_type' => 1,
				'sender_information' => json_encode($sender_info),
				'receiver_information' => json_encode($receiver_info),
				'receiver_email' => $user_info2['email'],
			
			);
			
			$inv_id = create_invoice($invoice_data); // creating invoice
			
			$total_cost_new = 0;
			
			$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$tracker_row['project_id'],'bidder_id'=>$tracker_row['worker_id'])));
			 
			$client_amt = $data['total_amt'];
		
			
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($post["minute"]);
			$total_cost_new=(($client_amt*floatval($post['hour']))+$total_min_cost);
			$total_hours = floatval($post['hour']);
			$total_mins = floatval($post['minute']);
			$total_dur = ((($post['hour']*60)+$post['minute'])/60);
			
			$projects_title =  getField('title', 'projects', 'project_id', $tracker_row['project_id']);
			$invoice_row_data = array(
				'invoice_id' => $inv_id,
				'description' => $projects_title,
				'per_amount' => $data['total_amt'],
				'unit' => 'Hour',
				'quantity' => $total_dur,
			);
			
			add_invoice_row($invoice_row_data); // adding invoice row
			
			add_project_invoice($pid, $inv_id);
			
			$this->db->where('invoice_id', $tracker_row['invoice_id'])->update('invoice_main', array('is_deleted' => date('Y-m-d H:i:s')));
			
			$this->db->where(array('id' => $manual_tracker_id))->update('project_tracker_manual', array('invoice_id' => $inv_id));
			
			
			$e_user_id = getField('user_id', 'projects', 'project_id', $pid);
			$title = getField('title', 'projects', 'project_id', $pid);
			$freelancer = getField('fname', 'user', 'user_id', $user_id);
			
			$notification = "$freelancer {edited_hour_for} $title ";
			$link = 'projectdashboard_new/employer/milestone/'.$pid;
			$this->notification_model->log($user_id, $e_user_id, $notification, $link);
			
			$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $pid);
			
			echo json_encode($json);
		}
	}
	
	public function release_manual_hour(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$id = post('id');
			
			$error = 0;
			
			$tracker_row = get_row(array('select' =>'*', 'from' => 'project_tracker_manual' ,  'where' => array('id' => $id)));
			
			$project_id = $tracker_row['project_id'];
			$freelancer_id = $tracker_row['worker_id'];
			$invoice_id = $tracker_row['invoice_id'];
			$invoice_number = $this->auto_model->getFeild("invoice_number","invoice_main","invoice_id",$invoice_id);
			$freelancer_wallet_id = get_user_wallet($freelancer_id);
			
			$total_cost_new = 0;
			$bid_row=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$tracker_row['worker_id'])));
			
			$client_amt = $bid_row['total_amt'];
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($tracker_row['minute']);
            $total_cost_new=(($client_amt*floatval($tracker_row['hour']))+$total_min_cost);
			$total_cost_new=round($total_cost_new , 2);
			$total_pay_amount=$total_cost_new;
			
			$total_deposit = get_project_deposit($project_id);
			$total_release = get_project_release_fund($project_id);
			$total_pending = get_project_pending_fund($project_id);
			$remaining_bal = $total_deposit - $total_release - $total_pending;
			
			$remaining_deposit = $total_deposit - $total_release;
			
			$commission = (($total_cost_new * SITE_COMMISSION) / 100) ; 
			$total_cost_new = $total_cost_new - $commission;
			
		
			/* $post_data['bider_to_pay']=$total_cost_new;
			$post_data['employer_id'] =$user_id;
            $post_data['project_id'] = $project_id;
			$post_data['milestone_id'] = 0;
			$post_data['worker_id'] = $freelancer_id;
			$post_data['payamount'] = $total_pay_amount;
            $post_data['commission'] = $commission;
            $post_data['tracker_id'] = $id;
            $post_data['status'] = 'Y';
            $post_data['release_type'] = 'P';
            $post_data['add_date'] = date('Y-m-d'); */
			
			if($remaining_deposit < $total_cost_new){
				//  employer has no enough balance in his deposit
				$json['errors']['fund'] = '<div class="info-error">'.__('not_enough_balance_in_your_project_deposit','Not enough balance in your project deposit').'</div>';
				$error++;
			}
		
			if($error == 0){
				$this->load->model('myfinance/transaction_model');
				$this->load->helper('invoice');
				
				$bidder_id = $tracker_row['worker_id'];
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
				
				add_project_invoice($project_id, $inv_id);
				
				$ref = json_encode(array('project_id' => $project_id, 'paid_amount' => $total_cost_new, 'commission' => $commission));
				
				// transaction insert
				$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user_id);
				
				
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $total_pay_amount, 'ref' => $ref , 'info' => '{Project_payment_to_freelancer} #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => ($total_cost_new+$commission), 'ref' => $ref , 'info' => '{Project_payment_received} #'.$project_id));
				
				
				$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $bidder_id, 'Y', $inv_id);
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $freelancer_wallet_id, 'debit' => $commission, 'ref' => $inv_id , 'info' => '{Commission_paid} #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $inv_id, 'info' => '{Commission_received}'));
				
				
				wallet_less_fund(ESCROW_WALLET,  $total_pay_amount);
			
				wallet_add_fund($freelancer_wallet_id, $total_cost_new);
				wallet_add_fund(PROFIT_WALLET, $commission);
				
				check_wallet($freelancer_wallet_id,  $new_txn_id);
				
				check_wallet(ESCROW_WALLET,  $new_txn_id);
				check_wallet(PROFIT_WALLET,  $new_txn_id);
				
				$this->db->where('id', $id)->update('project_tracker_manual', array('status' => 'Y', 'payment_status' => 'P', 'commission_invoice_id' => $inv_id));
				
				$project_txn = array(
					'project_id' => $project_id,
					'txn_id' => $new_txn_id,
				);
				
				$this->db->insert('project_transaction', $project_txn);
				
				$project_txn_id  = $this->db->insert_id();	
				
				$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
				$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
				
				// $this->db->insert('milestone_payment', $post_data);
				
				set_flash('succ_msg', __('projectdashboard_fund_successfully_released','Fund Successfully Released'));
				
				$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $project_id);
				
				$e_user_id = getField('user_id', 'projects', 'project_id', $project_id);
				$title = getField('title', 'projects', 'project_id', $project_id);
			
				$notification = "Payment received for $title";
				$link = 'projectdashboard_new/freelancer/milestone/'.$project_id;
				$this->notification_model->log($e_user_id, $freelancer_id, $notification, $link);
				
			
				$json['status'] = 1;
				
			}else{
				$json['status'] = 0;
			}
			
			
			echo json_encode($json);
		}
	}
	
	
	public function pause_freelancer(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			
			$schedule_id = post('schedule_id');
			$val = post('action');
			
			$this->db->where('schedule_id', $schedule_id)->update('project_schedule', array('is_project_paused' => $val));
			
			$json['status'] = 1;
			
			echo json_encode($json);
		}
	}
	
	public function freelancer_action_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			
			$schedule_id = post('schedule_id');
			$val = post('action');
			$field = post('col');
			
			$this->db->where('schedule_id', $schedule_id)->update('project_schedule', array($field => $val));
			
			$json['status'] = 1;
			
			echo json_encode($json);
		}
	}
	
	public function end_contract(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		$project_id = post('project_id');
		$freelancer_id = post('freelancer_id');
		
		if(post() && $this->input->is_ajax_request() && $user_id && $project_id && $freelancer_id){
			
			$public = post('public');
			$private = post('private');
			
			$error = 0;
			
			$freelancer_pending_payments = get_freelancer_payment($freelancer_id , $project_id , 'pending');
			
			if($freelancer_pending_payments > 0){
				
				$freelancer_wallet_id = get_user_wallet($freelancer_id);
				
				$project_deposit = get_project_deposit($project_id);
				
				$project_fund_released = get_project_release_fund($project_id);
				
				$project_balance = ($project_deposit - $project_fund_released);
				
				$commission = (($freelancer_pending_payments * SITE_COMMISSION) / 100) ; 
				
				$freelancer_to_pay = $freelancer_pending_payments - $commission ;
			
				if($project_balance < $freelancer_pending_payments){
					//  employer has no enough balance in his deposit
					$json['errors']['freelancer_payment_end'] = '<div class="info-error">'.__('not_enough_balance_in_your_project_deposit_to_clear','Not enough balance in your project deposit to clear freelancer payment . Please add fund to your deposit').'</div>';
					$error++;
					
				}else{
					$this->load->model('myfinance/transaction_model');
					
					$ref = json_encode(array('project_id' => $project_id, 'paid_amount' => $freelancer_to_pay, 'commission' => $commission));
					
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user_id);
					
					
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $freelancer_pending_payments, 'ref' => $ref , 'info' => '{Project_payment_to_freelancer} #'.$project_id));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => $freelancer_to_pay, 'ref' => $ref , 'info' => '{Project_payment_received} #'.$project_id));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $ref, 'info' => '{Commission_received}'));
					
					
					wallet_less_fund(ESCROW_WALLET,  $freelancer_pending_payments);
				
					wallet_add_fund($freelancer_wallet_id, $freelancer_to_pay);
					
					wallet_add_fund(PROFIT_WALLET, $commission);
					
					check_wallet($freelancer_wallet_id,  $new_txn_id);
					
					check_wallet(ESCROW_WALLET,  $new_txn_id);
					check_wallet(PROFIT_WALLET,  $new_txn_id);
					
					$this->db->where(array('worker_id' => $freelancer_id, 'project_id' => $project_id))->update('project_tracker_manual', array('status' => 'Y', 'payment_status' => 'P'));
					
					$this->db->where(array('worker_id' => $freelancer_id, 'project_id' => $project_id))->update('project_tracker', array('status' => 'Y', 'payment_status' => 'P'));
					
					$project_txn = array(
						'project_id' => $project_id,
						'txn_id' => $new_txn_id,
					);
					
					$this->db->insert('project_transaction', $project_txn);
						
					set_flash('succ_msg', __('projectdashboard_fund_successfully_released','Fund Successfully Released'));
					
					$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $project_id);
					
				}
				
				
			}
			
			if($error == 0){
				
				if(!empty($private['strength'])){
					$private['strength'] = json_encode($private['strength']);
				}else{
					$private['strength'] = '';
				}
				
				$private['feedback_by_user'] = $user_id;
				$private['feedback_to_user'] = $freelancer_id;
				$private['added_date'] = date('Y-m-d');
				$private['project_id'] = $project_id;
				
				$public['project_id'] = $project_id;
				$public['review_by_user'] = $user_id;
				$public['review_to_user'] = $freelancer_id;
				$public['added_date'] = date('Y-m-d');
				
				$feedback['data'] = $private;
				$feedback['table'] = 'feedback';
				insert($feedback);
				
				$rating['data'] = $public;
				$rating['table'] = 'review_new';
				insert($rating);
				
				$this->db->where(array('project_id' => $project_id, 'freelancer_id' => $freelancer_id))->update('project_schedule', array('is_contract_end' => 1));
				
				$all_ended = explode(',', trim(getField('ended_contractor', 'projects', 'project_id', $project_id)));
				
				if(!in_array($freelancer_id, $all_ended)){
					array_push($all_ended, $freelancer_id);
					$ended_str = trim(implode(',', $all_ended), ',');
					$this->db->where('project_id', $project_id)->update('projects', array('ended_contractor' => $ended_str));
				}
				
				$title = getField('title', 'projects', 'project_id' , $project_id);
				$notification = "{contract_ended_with} $title";
				$link = 'projectdashboard_new/freelancer/overview/'.$project_id;
				$this->notification_model->log($user_id, $freelancer_id, $notification, $link);
				
				$template='contract_end';
				$freelancer_name = getField('fname', 'user', 'user_id' , $freelancer_id);
				$to_mail = getField('email', 'user', 'user_id' , $freelancer_id);
				$project_title = $title;
				$data_parse=array( 'PROJECT'=>$project_title, 'FREELANCER' => $freelancer_name);
				send_layout_mail($template, $data_parse, $to_mail);
				
				$template='review_freelancer';
				$employer_uname = getField('username', 'user', 'user_id' , $user_id);
				$data_parse=array( 'EMPLOYER'=>$employer_uname, 'FREELANCER' => $freelancer_name);
				send_layout_mail($template, $data_parse, $to_mail);
			
				
				$json['status'] = 1;
			}else{
				$json['status'] = 0;
			}
			
			echo json_encode($json);
		}
	}
	
	public function upateReview(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		$project_id = post('project_id');
		$freelancer_id = post('freelancer_id');
		
		if(post() && $this->input->is_ajax_request() && $user_id && $project_id && $freelancer_id){
			
			$public = post('public');
			$private = post('private');
			
			$review_id = post('review_id');
			$feedback_id = post('feedback_id');
			
			$error = 0;

			if($error == 0){
				
				if(!empty($private['strength'])){
					$private['strength'] = json_encode($private['strength']);
				}else{
					$private['strength'] = '';
				}
				
				$private['feedback_by_user'] = $user_id;
				$private['feedback_to_user'] = $freelancer_id;
				$private['project_id'] = $project_id;
				
				$public['project_id'] = $project_id;
				$public['review_by_user'] = $user_id;
				$public['review_to_user'] = $freelancer_id;
				
				$feedback['data'] = $private;
				$feedback['table'] = 'feedback';
				
				if(!empty($feedback_id)){
					
					$feedback['where'] = array('feedback_id' => $feedback_id);
					update($feedback);
					
				}else{
					
					$feedback['data']['added_date'] = date('Y-m-d');
					insert($feedback);
					
				}
				
				
				$rating['data'] = $public;
				$rating['table'] = 'review_new';
				
				if(!empty($review_id)){
					
					$rating['data']['edited_date'] = date('Y-m-d');
					$rating['where'] = array('review_id' => $review_id);
					update($rating);
					
				}else{
					
					$rating['data']['added_date'] = date('Y-m-d');
					insert($rating);
					
				}
				
				$title = getField('title', 'projects', 'project_id' , $project_id);
				$notification = "{review_updated}";
				$link = 'projectdashboard_new/freelancer/overview/'.$project_id;
				$this->notification_model->log($user_id, $freelancer_id, $notification, $link);
				
				$template='review_freelancer';
				$employer_uname = getField('username', 'user', 'user_id' , $user_id);
				$freelancer_name = getField('fname', 'user', 'user_id' , $freelancer_id);
				$to_mail = getField('email', 'user', 'user_id' , $freelancer_id);
				$data_parse=array( 'EMPLOYER'=>$employer_uname, 'FREELANCER' => $freelancer_name);
				send_layout_mail($template, $data_parse, $to_mail);
				
				
				
				$json['status'] = 1;
			}else{
				$json['status'] = 0;
			}
			
			echo json_encode($json);
		}
	}
	
	public function update_review_employer(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		$project_id = post('project_id');
		$employer_id = post('employer_id');
		$review_to = $employer_id;
		if(post() && $this->input->is_ajax_request() && $user_id && $project_id && $employer_id){
			
			$public = post('public');
			//$private = post('private');
			
			$review_id = post('review_id');
			//$feedback_id = post('feedback_id');
			
			$error = 0;

			if($error == 0){
				
				/* if(!empty($private['strength'])){
					$private['strength'] = json_encode($private['strength']);
				}else{
					$private['strength'] = '';
				} 
				$private['feedback_by_user'] = $user_id;
				$private['feedback_to_user'] = $freelancer_id;
				$private['project_id'] = $project_id; */
				
				$public['project_id'] = $project_id;
				$public['review_by_user'] = $user_id;
				$public['review_to_user'] = $review_to;
				
				/* $feedback['data'] = $private;
				$feedback['table'] = 'feedback';
				
				if(!empty($feedback_id)){
					
					$feedback['where'] = array('feedback_id' => $feedback_id);
					update($feedback);
					
				}else{
					
					$feedback['data']['added_date'] = date('Y-m-d');
					insert($feedback);
					
				} */
				
				
				$rating['data'] = $public;
				$rating['table'] = 'review_new';
				
				if(!empty($review_id)){
					
					$rating['data']['edited_date'] = date('Y-m-d');
					$rating['where'] = array('review_id' => $review_id);
					update($rating);
					
				}else{
					
					$rating['data']['added_date'] = date('Y-m-d');
					insert($rating);
				}
				
				$title = getField('title', 'projects', 'project_id' , $project_id);
				
				if(!empty($review_id)){
					
					$notification = "{review_updated}";
				}else{
					$notification = "{new_review_given_to_you}";
				}
				
				$link = 'projectdashboard_new/employer/overview/'.$project_id;
				$this->notification_model->log($user_id, $review_to, $notification, $link);
				
				$template='review_employer';
				$freelancer_uname = getField('username', 'user', 'user_id' , $user_id);
				$employer_name = getField('fname', 'user', 'user_id' , $review_to);
				$to_mail = getField('email', 'user', 'user_id' , $review_to);
				$data_parse=array( 'EMPLOYER'=>$employer_name, 'FREELANCER' => $freelancer_uname);
				send_layout_mail($template, $data_parse, $to_mail);
				
				
				$json['status'] = 1;
			}else{
				$json['status'] = 0;
			}
			
			echo json_encode($json);
		}
	}
	
	
	public function send_remainder(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$milestone_id = post('milestone_id');
			$today = date('Y-m-d');
			$project_id = getField('project_id', 'project_milestone', 'id', $milestone_id);
			$project_user = getField('user_id', 'projects', 'project_id', $project_id);
			
			$fname = getField('fname', 'user', 'user_id', $user_id);
			
			$notification = "$fname {requested_for_payment}";
			$link = 'projectdashboard_new/employer/milestone/'.$project_id;
			$this->notification_model->log($user_id, $project_user, $notification, $link);
			
			$this->db->where('id', $milestone_id)->update('project_milestone', array('requested_date' => $today));
			
			$template = 'payment_remainder';
			$employer_email = getField('email', 'user', 'user_id', $project_user);
			$employer_name = getField('fname', 'user', 'user_id', $project_user);
			$freelancer_username = getField('username', 'user', 'user_id', $user_id);
			
			$to = $employer_email;
			$data_parse = array(
				'EMPLOYER' => $employer_name,
				'FREELANCER' => $freelancer_username,
			);
			send_layout_mail($template, $data_parse, $to);
			
			set_flash('succ_msg', __('request_successfully_send','Request Successfully Send'));
			
			$json['status'] = 1;
			echo json_encode($json);
			
		}
	}
	
	public function screenshot($tracker_id="",$limit_from=""){		
		$this->load->library('pagination');   
		
		$data = array();
		
		$data['tracker_id']=$tracker_id;
		$project_id=$data['pid']=getField('project_id','project_tracker','id',$data['tracker_id']);
		$data['project_id']  = $project_id;
		
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		$data['user_type'] = '';
		
		if(is_employer($user_id, $project_id)){
			$data['user_type'] = 'employer';
		}
		
		if(is_bidder($user_id, $project_id)){
			$data['user_type'] = 'freelancer';
		}
		
		
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id);  // global use
		$data['project_type']= $project_type = $data['project_detail']['project_type']; // global use
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		
		$config = array();
        $config["base_url"] = base_url().'projectdashboard_new/screenshot/'.$data['tracker_id'].'/';
        $config["total_rows"] = $this->projectdashboard_model->getscreenshot($data['tracker_id'], '', '', FALSE);		
        $config["per_page"] = 12;
		$config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;		
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li><a href='javascript:void(0)'><b>";
		$config['cur_tag_close'] = '</b></a></li>';
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt; Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';      
				
        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
            
      
		$data['project_name']=getField('title','projects','project_id',$data['pid']);
		
		$data['screenshot_date']=getField('start_time','project_tracker','id',$data['tracker_id']);
		
		$data['tracker_details']=$this->projectdashboard_model->getscreenshot($data['tracker_id'], $config['per_page'], $start);		
		//get_print($data, false);
		$breadcrumb=array(
			array(
					'title'=>'Screenshot','path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Screenshot');
		$data['active_tab'] = 'screenshot';
		$this->layout->view('screenshot','',$data,'normal'); 
		
	}
	
	public function hour_auto_edit_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$post = post();
			$post['employer_request'] = '';
			$tracker_id = post('tracker_id');
			
			unset($post['tracker_id']);
			
			$upd['data'] = $post;
			$upd['where'] = array('id' => $tracker_id);
			$upd['table'] = 'project_tracker';
			
			update($upd);
			$json['status'] = 1;
			
			$tracker_row = get_row(array('select' =>'*', 'from' => 'project_tracker' ,  'where' => array('id' => $tracker_id)));
			$pid = $tracker_row['project_id'];
			
			$e_user_id = getField('user_id', 'projects', 'project_id', $pid);
			$title = getField('title', 'projects', 'project_id', $pid);
			$freelancer = getField('fname', 'user', 'user_id', $user_id);
			
			$notification = "$freelancer edited hour for $title ";
			$link = 'projectdashboard_new/employer/milestone/'.$pid;
			$this->notification_model->log($user_id, $e_user_id, $notification, $link);
			
			$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $pid);
			
			echo json_encode($json);
		}
	}
	
	public function release_hour(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$id = post('id');
			
			$error = 0;
			
			$tracker_row = get_row(array('select' =>'*', 'from' => 'project_tracker' ,  'where' => array('id' => $id)));
			
			$project_id = $tracker_row['project_id'];
			$freelancer_id = $tracker_row['worker_id'];
			$freelancer_wallet_id = get_user_wallet($freelancer_id);
			
			$total_cost_new = 0;
			$bid_row=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$tracker_row['worker_id'])));
			
			$client_amt = $bid_row['total_amt'];
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($tracker_row['minute']);
            $total_cost_new=(($client_amt*floatval($tracker_row['hour']))+$total_min_cost);
			$total_cost_new=round($total_cost_new , 2);
			$total_pay_amount=$total_cost_new;
			
			$total_deposit = get_project_deposit($project_id);
			$total_release = get_project_release_fund($project_id);
			$total_pending = get_project_pending_fund($project_id);
			$remaining_bal = $total_deposit - $total_release - $total_pending;
			
			$remaining_deposit = $total_deposit - $total_release;
			
			$commission = (($total_cost_new * SITE_COMMISSION) / 100) ; 
			$total_cost_new = $total_cost_new - $commission;
			
			
			if($remaining_deposit < $total_cost_new){
				//  employer has no enough balance in his deposit
				$json['errors']['fund'] = '<div class="info-error">'.__('not_enough_balance_in_your_project_deposit','Not enough balance in your project deposit').'</div>';
				$error++;
			}
		
			if($error == 0){
				$this->load->model('myfinance/transaction_model');
				
				$ref = json_encode(array('project_id' => $project_id, 'paid_amount' => $total_cost_new, 'commission' => $commission));
				
				// transaction insert
				$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user_id);
				
				
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $total_pay_amount, 'ref' => $ref , 'info' => '{Project_payment_to_freelancer} #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => $total_cost_new, 'ref' => $ref , 'info' => '{Project_payment_received} #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $ref, 'info' => '{Commission_received}'));
				
				wallet_less_fund(ESCROW_WALLET,  $total_pay_amount);
			
				wallet_add_fund($freelancer_wallet_id, $total_cost_new);
				wallet_add_fund(PROFIT_WALLET, $commission);
				
				check_wallet($freelancer_wallet_id,  $new_txn_id);
				
				check_wallet(ESCROW_WALLET,  $new_txn_id);
				check_wallet(PROFIT_WALLET,  $new_txn_id);
				
				$this->db->where('id', $id)->update('project_tracker', array('status' => '1', 'payment_status' => 'P'));
				
				$project_txn = array(
					'project_id' => $project_id,
					'txn_id' => $new_txn_id,
				);
				
				$this->db->insert('project_transaction', $project_txn);
				
				$project_txn_id  = $this->db->insert_id();	
				
				// $this->db->insert('milestone_payment', $post_data);
				
				set_flash('succ_msg', 'Fund Successfully Released');
				
				$this->projectdashboard_model->checkProjectDeposit($this->min_deposit, $project_id);
				
				$e_user_id = getField('user_id', 'projects', 'project_id', $project_id);
				$title = getField('title', 'projects', 'project_id', $project_id);
			
				$notification = "{payment_received_for} $title";
				$link = 'projectdashboard_new/freelancer/milestone/'.$project_id;
				$this->notification_model->log($e_user_id, $freelancer_id, $notification, $link);
				
				$json['status'] = 1;
				
			}else{
				$json['status'] = 0;
			}
			
			
			echo json_encode($json);
		}
	}
	
	
	public function view_contract($project_id='', $freelancer_id=''){
		$data = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		$data['freelancer_id'] = $freelancer_id;
		
		if(!is_employer($user_id, $project_id) || empty($project_id) || empty($freelancer_id)){
			show_404();
			return;
		}
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id);  // global use
		$data['project_type']= $project_type = $data['project_detail']['project_type']; // global use
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		$data['employer_detail'] = $this->db->where('user_id', $data['project_detail']['user_id'])->get('user')->row_array();
		
		$data['bid_detail'] = $this->db->where(array('project_id' => $project_id, 'bidder_id' => $freelancer_id))->get('bids')->row_array(); 
		
		$data['schedule'] = $this->db->where(array('project_id' => $project_id, 'freelancer_id' => $freelancer_id))->get('project_schedule')->row_array();
		
		$this->layout->view('common_contract_view','',$data,'normal');   
	}
	
	
	public function change_bid_detail(){
		
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$field = post('field');
			$val =  (int) post('val');
			$project_id = post('project_id');
			$worker_id = post('wid');
			
			$json['status'] = 1;
			
			if(is_employer($user_id, $project_id)){
				
				
				if($field == 'bidder_amt'){
					
					$prev_row = $this->db->where(array('project_id' => $project_id, 'bidder_id' => $worker_id))->get('bids')->row_array();
					
					$prev_val = $prev_row['bidder_amt'];
					
					if($val >= $prev_val){
						
						$this->db->where(array('project_id' => $project_id, 'bidder_id' => $worker_id))->update('bids', array('total_amt' => $val));
						
						$this->db->where(array('project_id' => $project_id, 'bidder_id' => $worker_id))->update('bids', array($field => $val));
						
					}else{
						
						$json['errors']['bid_rate'] =  '<div class="info-error">'.__('projectdashboard_value_must_be_greater_than','Value must be greater than').' '.$prev_val.'</div>';
						$json['status'] = 0;
						
					}
					
					
				}else{
					
					$this->db->where(array('project_id' => $project_id, 'bidder_id' => $worker_id))->update('bids', array($field => $val));
					
				}	
				
				
				
			}
			
			echo json_encode($json);
		}
		
		
	}
	
	
	public function view_tracker($project_id='', $freelancer_id=''){
		$data = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		$data['freelancer_id'] = $freelancer_id;
		
		if(!is_employer($user_id, $project_id) || empty($project_id) || empty($freelancer_id)){
			show_404();
			return;
		}
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id);  // global use
		$data['project_type']= $project_type = $data['project_detail']['project_type']; // global use
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		$data['employer_detail'] = $this->db->where('user_id', $data['project_detail']['user_id'])->get('user')->row_array();
		
		$data['bid_detail'] = $this->db->where(array('project_id' => $project_id, 'bidder_id' => $freelancer_id))->get('bids')->row_array(); 
		
		$data['schedule'] = $this->db->where(array('project_id' => $project_id, 'freelancer_id' => $freelancer_id))->get('project_schedule')->row_array();
		
		/* ------------ [TRACKER DATA ] ---------------------*/
		$get = get();
		$today = strtotime(date('Y-m-d'));
		
		$show_date = '';
		if($get['show_date']){
			$show_date = $get['show_date'];
		}else{
			$show_date = $today;
		}
		
		$srch = array();
		$srch['project_id'] = $project_id;
		$srch['worker_id'] = $freelancer_id;
		$srch['show_date'] = $show_date;
		
		$data['tracker_detail'] = $this->projectdashboard_model->getTrackerDetail($srch);
		$t_group = array();
		if(count($data['tracker_detail']) > 0){
			foreach($data['tracker_detail'] as $k => $v){
				$curr_hour = date('g A', strtotime($v['project_work_snap_time']));
				$t_group[$curr_hour][] = $v;
			}
		}
		
		$prev_day = strtotime(date('Y-m-d', strtotime("-1 day", $show_date)));
		$next_day = strtotime(date('Y-m-d', strtotime("+1 day", $show_date)));
		
		$data['tracker_group'] = $t_group;
		$data['next_day'] = $next_day;
		$data['prev_day'] = $prev_day;
		$data['curr_day'] = $show_date;
		
		$this->layout->view('common_contract_view','',$data,'normal');   
	}
	
	public function upload_attachment(){
		
		$json = array();
		
		if(!empty($_FILES['file']['name']) && $this->input->is_ajax_request()){
			
			if(!is_dir('./assets/attachments')){
				mkdir('./assets/attachments');
			}
			
			$config['upload_path'] = './assets/attachments/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|txt|docx';
			$config['encrypt_name'] = TRUE;
			$config['file_ext_tolower'] = TRUE;
		
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('file')) {
				$json['errors']['file'] = $this->upload->display_errors();
				$json['status'] = 0;
				
			}else{
				$data = $this->upload->data();
				$file = array(
					'filename' => $data['file_name'],
					'org_filename' => $data['orig_name'],
					'file_size' => $data['file_size'],
					'file_type' => $data['file_ext'],
					
				);
				
				$json['data'] = $file;
				$json['data']['file_str'] = json_encode($file);
				$json['data']['file_path'] = base_url('assets/attachments').'/';
				$json['status'] = 1;
			}
			
			echo json_encode($json);
		}
	}
	
	
	public function milestone_request_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		if($this->input->is_ajax_request()){
			$f_user_id = $user[0]->user_id;
			$milestone_id = post('milestone_id');
			
			$attachment = array();
			
			$attachment = post('attachments');
			
			$comment = post('request_comment');
			
			$post_data = array(
				'attachments' => $attachment,
				'comments' => $comment
			);
			
			$post_str = json_encode($post_data);
		
			$ins['requested_data'] = $post_str ;
			
			$ins['approval'] = 'P';
			
			
			$this->db->where('id', $milestone_id)->update('project_milestone', $ins);
			
			$project_id = getField('project_id', 'project_milestone', 'id', $milestone_id);
			
			$e_user_id = getField('user_id', 'projects', 'project_id', $project_id);
			
			$project_title = getField('title', 'projects', 'project_id', $project_id);
			$notification = "{milestone_request_received_for} $project_title";
			
			$link = 'projectdashboard_new/employer/milestone/'.$project_id;
			$this->notification_model->log($f_user_id, $e_user_id, $notification, $link);

			$employer_email = getField('email', 'user', 'user_id',  $e_user_id);
			$freelancer_username = getField('username', 'user', 'user_id',  $f_user_id);
			$employer_name = getField('fname', 'user', 'user_id',  $e_user_id);
			
			
			$template = 'milestone_request_employer';
			$to = $employer_email;
			$data_parse = array(
				'EMPLOYER' => $employer_name,
				'FREELANCER' => $freelancer_username,
			);
			send_layout_mail($template, $data_parse, $to);
			
			$json['status'] = 1;
			echo json_encode($json);
		}
	}
	
	public function milestone_request_action(){
		$json = array();
		$user = $this->session->userdata('user');
		
		if($this->input->is_ajax_request() && $user){
			$e_user_id = $user[0]->user_id;
			$milestone_id = post('milestone_id');
			
			$approval = post('action');
			
			$this->db->where('id', $milestone_id)->update('project_milestone', array('approval' => $approval));
			
			$json['status'] = 1;
			
			$bid_id =  getField('bid_id', 'project_milestone', 'id', $milestone_id);
			$freelancer_id = getField('bidder_id', 'bids', 'id', $bid_id);
			
			if($approval == 'A'){
				$notification = "{milestone_request_approved}";
			}else{
				$notification = "{milestone_request_rejected}";
			}
			
			$project_id = getField('project_id', 'project_milestone', 'id', $milestone_id);
			$link = 'projectdashboard_new/freelancer/milestone/'.$project_id;
			$this->notification_model->log($e_user_id, $freelancer_id, $notification, $link);
			
			$project_title = getField('title', 'projects', 'project_id', $project_id);
		
			if($approval == 'A'){
				$template = 'milestone_request_accept';
			}else{
				$template = 'milestone_request_reject';
			}
				
			$freelancer_email = getField('email', 'user', 'user_id', $freelancer_id);
			$employer_username = getField('username', 'user', 'user_id', $e_user_id);
			$freelancer_name = getField('fname', 'user', 'user_id', $freelancer_id);
			
			$to = $freelancer_email;
			$data_parse = array(
				'EMPLOYER' => $employer_username,
				'FREELANCER' => $freelancer_name,
				'PROJECT_TITLE' => $project_title,
			);
			send_layout_mail($template, $data_parse, $to);
			
			echo json_encode($json);
		}
		
	}
	
	public function create_invoice_hourly(){
		$json = array();
		$user = $this->session->userdata('user');
		$this->load->helper('invoice');
		if($this->input->is_ajax_request() && $user){
			$f_user_id = $user[0]->user_id;
			$tracker_ids = post('tracker_id');
			$project_id = post('project_id');
			$e_user_id = getField('user_id', 'projects','project_id', $project_id);
			$employer_email = getField('email', 'user','user_id', $e_user_id);
			$projects_title = getField('title', 'projects','project_id', $project_id);
			
			$user_info = get_row(array('select' => 'fname,lname','from' => 'user', 'where' => array('user_id' => $f_user_id)));
			$user_info2 = get_row(array('select' => 'fname,lname','from' => 'user', 'where' => array('user_id' => $e_user_id)));
			
			$sender_info = array(
				'name' => $user_info['fname'].' '.$user_info['lname'],
				'address' => getUserAddress($f_user_id),
			);
			$receiver_info = array(
				'name' => $user_info2['fname'].' '.$user_info2['lname'],
				'address' => getUserAddress($e_user_id),
			);
			
			$invoice_data = array(
				'sender_id' => $f_user_id,
				'receiver_id' =>$e_user_id,
				'invoice_type' => 1,
				'sender_information' => json_encode($sender_info),
				'receiver_information' => json_encode($receiver_info),
				'receiver_email' => $employer_email,
			
			);
			
			$inv_id = create_invoice($invoice_data); // creating invoice
			
			$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$f_user_id)));
			
			$invoice_row_data = array();
			
			if(count($tracker_ids) > 0){
				foreach($tracker_ids as $k => $v){
					
					$tracker_row_detail = get_row(array('select' => '*', 'from' => 'project_tracker', 'where' => array('id'=> $v)));
					
					$total_dur = ((($tracker_row_detail['hour']*60)+$tracker_row_detail['minute'])/60);
					
					$dscr = $projects_title. '<div><i>'.$tracker_row_detail['start_time'].' to '.$tracker_row_detail['stop_time'].'</i></div>';
					
					$invoice_row_data[] = array(
						'invoice_id' => $inv_id,
						'description' => $dscr,
						'per_amount' => $data['total_amt'],
						'unit' => 'Hour',
						'quantity' => $total_dur,
					);
				}
				
				$this->db->insert_batch('invoice_row', $invoice_row_data); // adding invoice row
				
				$this->db->where_in('id', $tracker_ids)->update('project_tracker', array('payment_status' => 'I', 'invoice_id' => $inv_id));
				
				add_project_invoice($project_id, $inv_id);
			}
			
			$json['status'] = 1;
			
			$notification = "{$user_info['fname']} {send_you_a_invoice_for} $projects_title";
			$link = 'projectroom/invoices/'.$project_id;
			$this->notification_model->log($f_user_id, $e_user_id, $notification, $link);
			
			/*if($approval == 'A'){
				$notification = "Milestone request approved";
			}else{
				$notification = "Milestone request rejected";
			}
			
			 $project_id = getField('project_id', 'project_milestone', 'id', $milestone_id);
			$link = 'projectdashboard_new/freelancer/milestone/'.$project_id;
			$this->notification_model->log($e_user_id, $freelancer_id, $notification, $link);
			
			$project_title = getField('title', 'projects', 'project_id', $project_id);
		
			if($approval == 'A'){
				$template = 'milestone_request_accept';
			}else{
				$template = 'milestone_request_reject';
			}
				
			$freelancer_email = getField('email', 'user', 'user_id', $freelancer_id);
			$employer_username = getField('username', 'user', 'user_id', $e_user_id);
			$freelancer_name = getField('fname', 'user', 'user_id', $freelancer_id);
			
			$to = $freelancer_email;
			$data_parse = array(
				'EMPLOYER' => $employer_username,
				'FREELANCER' => $freelancer_name,
				'PROJECT_TITLE' => $project_title,
			);
			send_layout_mail($template, $data_parse, $to); */
			
			echo json_encode($json);
		}
		
	}
	
	public function invoices($project_id='', $limit_from=0){
		$data = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['user_id'] = $user_id ;
		$data['project_id'] =  $project_id;
		
		if(!is_bidder($user_id, $project_id) && !is_employer($user_id, $project_id)){
			//show_404();
			redirect(VPATH.'pagenotfound');
			exit;
			return;
		}
		
		/* ------------ [RIGHT PANEL DO NOT DELETE ] -------------------------*/
		
		$data['project_detail'] = $this->projectdashboard_model->getprojectdetails($project_id);  // global use
		$data['project_type']= $project_type = $data['project_detail']['project_type']; // global use
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_detail']['user_id']);
		$data['cityCountry'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/* ------------ [RIGHT PANEL END ] -------------------------*/
		
		$data['employer_detail'] = $this->db->where('user_id', $data['project_detail']['user_id'])->get('user')->row_array();
		
		$data['bid_detail'] = $this->db->where(array('project_id' => $project_id, 'bidder_id' => $user_id))->get('bids')->row_array(); // freelancer bid detail
		
		if($project_type == 'H'){
			
			$data['project_schedule'] = $this->projectdashboard_model->getProjectScheduleFreelancer($project_id, $user_id);
			$data['request'] = $this->projectdashboard_model->getProjectRequestFreelancer($project_id, $user_id);
			
			$data['is_scheduled'] = count($data['project_schedule']) > 0 ? TRUE : FALSE;
			$data['is_requested'] = count($data['request']) > 0 ? TRUE : FALSE;
			
			
		
		}
		$this->load->library('pagination');
		$srch = $this->input->get();
		$limit = $limit_from ? $limit_from : 0;
		$offset = 30;
		
		$srch['project_id'] = $project_id;
		$srch['user_id'] = $user_id;
		
		$data['invoice_list'] = $this->projectdashboard_model->getProjectInvoice($srch, $limit, $offset);
		$data['total_records'] = $this->projectdashboard_model->getProjectInvoice($srch, '', '', FALSE);
		
		/*Pagination Start*/
		$config['base_url'] = base_url('projectdashboard_new/invoices/'.$project_id);
		
		$config['total_rows'] = $data['total_records'];
		$config['per_page'] = $offset;
		$config["uri_segment"] = 4;
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');;
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = __('pagination_next','Next').' &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.__('pagination_previous','Previous');
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>'; 
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		/*Pagination End*/
		
		//get_print($data['invoice_list']);
		$breadcrumb=array(
			array(
					'title'=>__('projectdashboard_project_invoice','Project Invoice'),'path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('projectdashboard_project_invoice','Project Invoice'));
		$data['active_tab'] = 'invoices';
	
		if($project_type == 'H'){
			$this->layout->view('project_invoice_list','',$data,'normal');   
		}else{
			$this->layout->view('project_invoice_list','',$data,'normal');   
		}
		
	}
	
	public function process_invoice(){
		$json = array();
		$user = $this->session->userdata('user');
		$this->load->helper('invoice');
		if($this->input->is_ajax_request() && $user){
			$invoice_id = post('invoice_id');
			$project_type = post('project_type');
			$project_id = post('project_id');
			$cmd = post('cmd');
			
			$freelancer_id = getField('sender_id', 'invoice_main', 'invoice_id', $invoice_id);
			$invoice_number = getField('invoice_number', 'invoice_main', 'invoice_id', $invoice_id);
			
			if($cmd == 'accept'){
				
				if($project_type == 'H'){
					$json = $this->projectdashboard_model->pay_hourly_invoice($invoice_id, $project_id);
				}else{
					$json = $this->projectdashboard_model->pay_fixed_invoice($invoice_id, $project_id);
				}
				
				if($json['status'] == 1){
					
					$notification = "{invoice_number} #$invoice_number {has_been_paid}";
					$link = 'projectroom/invoices/'.$project_id;
					$this->notification_model->log($user[0]->user_id, $freelancer_id, $notification, $link);
				}
				
			}
			
			if($cmd == 'deny'){
				
				if($project_type == 'H'){
					$json = $this->projectdashboard_model->deny_hourly_invoice($invoice_id, $project_id);
				}else{
					$json = $this->projectdashboard_model->deny_fixed_invoice($invoice_id, $project_id);
				}
				$comment = htmlentities(trim(post('reason_comment')));
				if($json['status'] == 1){
					
					$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('comment' => $comment));
					
					$notification = "{invoice_number} #$invoice_number {has_been_rejected}";
					$link = 'projectroom/invoices/'.$project_id;
					$this->notification_model->log($user[0]->user_id, $freelancer_id, $notification, $link);
				
				}
			}
			
			if(!$json){
				$json['status'] = 1;
			}
			
			echo json_encode($json);
		}
	}
	
	
}
