<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_login extends MX_Controller {

   
    public function __construct() {
       
        parent::__construct();
		
		$this->load->model('api_login_model');
	}

	
	public function google_login(){
		$json = array();
		
		if(post()){
			
			$google_user_id = post('id'); // id, first_name, last_name, email
			
			if($google_user_id){
				
				$count_google_user = $this->db->where(array('google_user_id' => $google_user_id, 'email' => post('email')))->count_all_results('user');
				
				if($count_google_user > 0){
					
					$this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance,account_type')
					->from('user')
					->where(array('google_user_id' => $google_user_id, 'email' => post('email')));
					
					$result = $this->db->get()->result();
					
					if($result){
						$this->session->set_userdata('user', $result);
					}
					
					
					$json['status'] = 1;
					
				}else{
					
					$username = $this->generateUserName(post('first_name'));
					$token = md5($username.'_#$*(#$_'.time());
					$user_data = array(
						'fname' => post('first_name'),
						'lname' => post('last_name'),
						'account_type' => 'E',
						'username' => $username,
						'email' => post('email'),
						'v_stat' => 'Y',
						'status' => 'Y',
						'verify' =>'Y',
						'membership_plan' => '1',
						'membership_start' => date("Y-m-d"),                           
						'ip'=>$_SERVER['REMOTE_ADDR'],
						'reg_date'=>date('Y-m-d H:i:s'),
						'edit_date'=>date('Y-m-d H:i:s'),
						'ldate'=>date('Y-m-d H:i:s'),
						'google_user_id'=>$google_user_id,
						'token'=>$token,
					);
					
					$this->db->insert('user', $user_data);
					$user_id = $this->db->insert_id(); 
					
					$this->db->insert('wallet', array('user_id' => $user_id, 'title' => $user_data['fname'].' '.$user_data['lname'], 'balance' => 0));
					
					$this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance,account_type')
					->from('user')
					->where('user_id', $user_id);
					
					$result = $this->db->get()->result();
					
					$this->session->set_userdata('user', $result);
					
					$json['status'] = 1;
					$json['next'] = base_url('user/set_account_type/'.$token);
					
				}
			}else{
				$json['status'] = 0;
			}
			
			
			echo json_encode($json);
			
		}
	}
	
	private function generateUserName($fname=''){
		$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
		shuffle($seed);
		$rand = '';
		foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
		
		$unique_code = $rand;
		$username = $fname.'_'.$unique_code;
		while(!$this->checkUserName($username)){
			$this->generateUserName($fname);
		}
		
		return $username;
		
	}
	
	private function checkUserName($username=''){
		$count = $this->api_login_model->checkUser($username);
		
		if($count > 0){
			return false;
		}
		else{
			return true;
		}
	}
	
	public function facebook_check(){
		$res = array();
		if(post()){
			$email = post('email');
			$post_data = post();
			$row_count = $this->db->where(array('email' => $email))->get('users')->row_array();
			if(!empty($row_count['user_id'])){
				set_session('uid', $row_count['user_id']);
				set_session('is_verified', $row_count['email_verified']);
				set_session('is_mail_send', 'N');
				
				
			}else{
				if(!empty($post_data['dob'])){
					$post_data['dob'] = date('Y-m-d', strtotime($post_data['dob']));
				}
				$post_data['registered_on'] = date('Y-m-d H:i:s');
				$ins['table'] = 'users';
				$ins['data'] = $post_data;
				$uid = insert($ins, TRUE);
				set_session('uid', $uid);
				set_session('is_verified', 'N'); 
				set_session('is_mail_send', 'N');
				
				set_session('show_pic_upload_modal', 1);
				
				if(!empty($post_data['gender']) && $post_data['gender'] == 'M'){
					$looking_for = 'F';
				}else{
					$looking_for = 'M';
				}
				
				$match_data['data'] = array('user_id' => $uid, 'looking_for' => $looking_for);
				$match_data['table'] = 'users_match';
				insert($match_data);
					
			}
			$res['status'] = 1;
			echo json_encode($res);
		}
	}
	
}


