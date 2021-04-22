<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Postjob_model extends BaseModel {

    public function __construct() {
		$this->load->model('notification/notification_model');
        return parent::__construct();

    }

   public function post_project() {
	$this->load->helper('date');
	 $this->load->library('MY_Validation');

		$i=0;
		if(!$this->session->userdata('user'))
		{
			$inf_type=$this->input->post('user_inf');
			if($inf_type=='s')
			{
				$fname=$this->input->post('fname');
				$lname=$this->input->post('lname');
				$regusername=$this->input->post('regusername');
				$email=$this->input->post('email');
				$cnfemail=$this->input->post('cnfemail');
				$regpassword=$this->input->post('regpassword');
				$cpassword=$this->input->post('cpassword');
				$country=$this->input->post('country');

				$city=$this->input->post('city');
			}
			elseif($inf_type=='l')
			{
				$lusername=$this->input->post('lusername');

				$lpassword=$this->input->post('lpassword');
			}
		}
		$captcha=trim(strtolower($this->input->post('captcha')));
        $subskill="";
        /*if($this->input->post('subskill')!=""){
          $subskill=implode(",", $this->input->post('subskill'));
        }*/
        $subskillarr=$this->input->post('subskill');
		if(count($subskillarr) > 0){
			$subskill=implode(',', $subskillarr);
		}

       // $subskill= rtrim($subskill,",");

		$ball="";
        $project_type=$this->input->post('project_type');
        $ball=$this->input->post('budgetall');
        $bmin=0;
        $bmax=0;
		$fixed_budeget=$this->input->post('fixed_budeget');
		  if($ball=='other'){
		  	$fixed_budget='Y';
		  }else{
		  	$fixed_budget='N';
		  }

        if($ball!="0" && $project_type=="F"){
			if($ball=='other'){
				$bmin=$this->input->post('fixed_budeget');
				$bmax=$this->input->post('fixed_budeget');

			}else{
				$b=explode("#",$this->input->post('budgetall'));
				$bmin=$b[0];
				$bmax=$b[1];
			}
        }
        else{

            $bmin=$this->input->post('budget_min');
            $bmax=$this->input->post('budget_max');
        }
        if($project_type=='H'){
			$multi_freelancer='Y';
			$no_of_freelancer=$this->input->post('no_of_freelancer');
		}else{
			$multi_freelancer='N';
			$no_of_freelancer='0';
		}
		$title=$this->input->post('title');
		$description=$this->input->post('description');
         $category=$this->input->post('category_id');


		$subcategory=$this->input->post('subcategory_id');
		//$subskill=$subskill;
		$project_type=$this->input->post('project_type');
		//$budget_min=$this->input->post('budget_min');
        //$budget_max=$this->input->post('budget_max');

	if(!$this->session->userdata('user'))
	{
		if($inf_type=='s')
		{
			if($fname==''){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='fname';
				$msg['errors'][$i]['message']=__('postjob_please_enter_first_name',"Please enter first name");
				$i++;
			}
			if($lname==''){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='lname';
				$msg['errors'][$i]['message']=__('postjob_please_enter_last_name',"Please enter last name");
				$i++;
			}
			if($regusername=='' || strlen($regusername)<4 || strlen($regusername)>20 || !preg_match('/^[a-zA-Z0-9]+$/',$regusername)){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='regusername';
				$msg['errors'][$i]['message']=__('postjob_username_must_be_4_to_20_characters_only_letters_andor_numbers',"Username must be 4 to 20 characters, only letters and/or numbers");
				$i++;
			}else{
				$this->db->where("username",$regusername);
				$un=$this->db->count_all_results('user');
				if($un>0){
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='regusername';
					$msg['errors'][$i]['message']=__('postjob_the_username_you_are_trying_to_use_already_exists_please_try_again','The username you are trying to use already exists please try again');
					$i++;
				}
			}
			if($email=='' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='email';
				$msg['errors'][$i]['message']=__('postjob_please_type_email_address',"Please type email address");
				$i++;
			}elseif($cnfemail=='' || $cnfemail!=$email){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='cnfemail';
				$msg['errors'][$i]['message']=__('postjob_confirm_email_not_match',"Confirm email not match");
				$i++;
			}else{
				$this->db->where("email",$email);
				$em=$this->db->count_all_results('user');
				if($em>0){
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='email';
					$msg['errors'][$i]['message']=__('postjob_this_email_is_already_in_use_please_enter_a_different_one',"This email is already in use. Please enter a different one");
					$i++;
				}
			}
			if($regpassword=='' || strlen($regpassword)<6 || strlen($regpassword)>12 || !preg_match('/^[a-zA-Z0-9]+$/',$regpassword)){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='regpassword';
				$msg['errors'][$i]['message']=__('postjob_regpassword',"Your password must be at least 6 characters and no longer than 12. Password can only contain numbers or letters or both - all other symbols are invalid");
				$i++;
			}elseif($cpassword=='' || $regpassword!=$cpassword){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='cpassword';
				$msg['errors'][$i]['message']=__('postjob_confirm_password_not_match',"Confirm password not match");
				$i++;
			}
			if($country==""){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='country';
			$msg['errors'][$i]['message']=__('postjob_select_your_country',"Select Your Country");
			$i++;
             }
		if($city==""){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='city';
			$msg['errors'][$i]['message']=__('postjob_select_your_city',"Select Your city");
			$i++;
             }
		}
		elseif($inf_type=='l')
		{

			if($lusername==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='lusername';

			$msg['errors'][$i]['message']=__('postjob_enter_username_or_email',"Enter username or email");

			$i++;

			}



			if($lpassword==''){

				$msg['status']='FAIL';

				$msg['errors'][$i]['id']='lpassword';

				$msg['errors'][$i]['message']=__('postjob_enter_password',"Enter password");

				$i++;

			}
		}
		}

		if($title==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='title';
			$msg['errors'][$i]['message']=__('postjob_please_enter_job_title','Please Enter Job Title');
			$i++;
		}
		if($description==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='description';
			$msg['errors'][$i]['message']=__('postjob_please_enter_description','Please Enter Description');
			$i++;
		}

        if($subskill==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='subskill_id';
			$msg['errors'][$i]['message']=__('postjob_please_select_skill','Please Select Skill');
			$i++;
		}

		if($project_type==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='project_type';
			$msg['errors'][$i]['message']=__('postjob_please_select_project_type','Please Select Project Type');
			$i++;
        }

		if($project_type=='F'){
            if($ball=="0"){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='budgetall';
				$msg['errors'][$i]['message']=__('postjob_please_select_your_budget','Please Select your Budget');
				$i++;
           	}elseif($ball=="other" && ($fixed_budeget=="0" || !preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $fixed_budeget))){

				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='budgetall';
				$msg['errors'][$i]['message']=__('postjob_please_enter_valid_amount','Please eneter valid amount');
				$i++;
			}
		}
		elseif($project_type=='H'){

		   $hr_per_week = $this->input->post('hr_per_week');

		   if(empty($hr_per_week) || !is_numeric($hr_per_week)){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='hr_per_week';
				$msg['errors'][$i]['message']=__('postjob_please_enter_hours','Please enter hours');
				$i++;
		   }

            if($bmax=="0" && $bmin=="0"){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='budgetmax';
				$msg['errors'][$i]['message']=__('postjob_please_select_enter_your_budget','Please Select/Enter your Budget');
				$i++;
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='budgetmin';
				$msg['errors'][$i]['message']=__('postjob_please_select_enter_your_budget','Please Select/Enter your Budget');
				$i++;
              }else{
				  if($bmax<3){
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='budgetmax';
					$msg['errors'][$i]['message']=__('postjob_miximum_budget','Miximum Budget');
					$i++;
				  }
				  if($bmin<3) {
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='budgetmin';
					$msg['errors'][$i]['message']=__('postjob_minimum_budget','Minimum Budget');
					$i++;
				  }
			  }
              if($multi_freelancer=='Y'){
				  if(($no_of_freelancer<1) || (!preg_match('/^[0-9]*$/', $no_of_freelancer))){
				  	$msg['status']='FAIL';
					$msg['errors'][$i]['id']='no_of_freelancer';
					$msg['errors'][$i]['message']=__('postjob_enter_your_valid_number','Enter your Valid number');
					$i++;
				  }
			  }
          }

		  $user=$this->session->userdata('user');
		  $user_wallet_id = get_user_wallet($user[0]->user_id);
		  $user_id = $user[0]->user_id;

		  if($this->input->post('featured')=="Y"){
			$balance=get_wallet_balance($user_wallet_id);

			if(($this->input->post('project_type')=="F" && $balance<FIXED_RATE) || ($this->input->post('project_type')=="H" && $balance<HOURLY_RATE)){

				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='fund';
				$msg['errors'][$i]['message']='You do not have enough fund. Please <a href="'.base_url('myfinance').'" target="_blank">add fund.</a>';
				$i++;

			}

		  }

        /* if($this->input->post('termsandcondition')!='Y'){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='termsandcondition';
			$msg['errors'][$i]['message']=__('postjob_please_check_terms_and_conditions','Please check terms and conditions');
			$i++;
		}
		  if (!$this->my_validation->recaptcha_matches()) {
        	$msg['status']='FAIL';
			$msg['errors'][$i]['id']='captcha';
			$msg['errors'][$i]['message']="Captcha is invalid";
			$i++;
    	  }
		 if ($i>0) {
        	$msg['status']='FAIL';
			$msg['errors'][$i]['id']='captcha';
			$msg['errors'][$i]['message']="Please click on the Recaptcha refresh button to display a new code";
			$i++;
    	  }	*/

            if($i==0){

			if(!$this->session->userdata('user')){
				if($inf_type=='s'){
					$new_data = array(
						'username' => $this->input->post('regusername'),
						'fname' => $this->input->post('fname'),
						'lname' => $this->input->post('lname'),
						'password' => md5($this->input->post('regpassword')),
						'email' => $this->input->post('email'),
						'country' => $this->input->post('country'),
						'city' => $this->input->post('city'),
						'v_stat' => 'Y',
						'status' => 'Y',
						'membership_plan' => '1',
						'membership_start' => date("Y-m-d"),
						'ip'=>$_SERVER['REMOTE_ADDR']
					);
					$this->db->set('reg_date', 'NOW()', FALSE);
					$this->db->set('edit_date', 'NOW()', FALSE);
					$this->db->set('ldate', 'NOW()', FALSE);
					parent::insert("user", $new_data);
					if ($this->db->insert('user', $new_data))
					{

					$user_id=$this->db->insert_id();
					$url=SITE_URL."/login/".base64_encode($user_id);
					if(EMAIL_VERI=='Y')
					{
						$link=$url;
					}else
					{
						$link=SITE_URL."/login/";
					}
					$from=ADMIN_EMAIL;
					$to=$email;
					$template='registration';
					$data_parse=array('USER'=>$regusername,
										'F_NAME'=>$fname,
										'L_NAME'=>$lname,
										'EMAIL'=>$email,
										'PASSWORD'=>$regpassword,
										'URL'=>$link
										);
							$msg['status']='OK';
							$this->auto_model->send_email($from,$to,$template,$data_parse);
						/*
						User login here
						*/
						$username = trim($this->input->post("regusername"));

						$password = $this->input->post("regpassword");

						$response = array();

						$this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance');

						$this->db->where("(email = '".$username."' OR username = '".$username."')");

						$this->db->where('password',md5($password));

						$this->db->where('status =', 'Y');

						$this->db->where('v_stat =', 'Y');

						$query=$this->db->get('user');



						//echo $this->db->last_query();die();

						$result = $query->result();



						if ($query->num_rows() == 1) {

							$msg['status'] = "OK";

							$this->session->set_userdata('user', $result);

							$data = array(

							   'ip' => $_SERVER['REMOTE_ADDR']

							);

							$this->db->set('ldate', 'NOW()', FALSE);

							$this->db->update('user', $data);



						}

					}
				}
				elseif($inf_type=='l')
				{


						$username = trim($this->input->post("lusername"));

						$password = $this->input->post("lpassword");

						$response = array();

						$this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance');

						$this->db->where("(email = '".$username."' OR username = '".$username."')");

						$this->db->where('password',md5($password));

						$this->db->where('status =', 'Y');

						$this->db->where('v_stat =', 'Y');

						$query=$this->db->get('user');



						$result = $query->result();


						if ($query->num_rows() == 1) {

							$msg['status'] = "OK";

							$this->session->set_userdata('user', $result);

							$user_id=$result[0]->user_id;

							$data = array(

							   'ip' => $_SERVER['REMOTE_ADDR']

							);

							$this->db->set('ldate', 'NOW()', FALSE);

							$this->db->update('user', $data);



						} else {

							$msg['status']='FAIL';

							$msg['errors'][$i]['id']='agree_terms';

							$msg['errors'][$i]['message']= 'Login failed! wrong username/email or password or your profile is not activated yet';

						}




				}
			}
			if($this->input->post('user_id'))
			{
				$user_id=$this->input->post('user_id');
			}
			$featured="N";
			if($this->session->userdata('user'))
			{
				$user=$this->session->userdata('user');
				/***** Plan wise project limit calculation Start ****/
				$project_plan_limit=$this->auto_model->getFeild('project','membership_plan','id',$user[0]->membership_plan);
				if($user[0]->membership_plan!='1')
				{
					$membership_start=$this->auto_model->getFeild('membership_start','user','user_id',$user[0]->user_id);
					$membership_end=$this->auto_model->getFeild('membership_end','user','user_id',$user[0]->user_id);
					$project_count=$this->projectCount($user[0]->user_id,$membership_start,$membership_end);
				}
				else
				{
					$project_count=$this->projectCount($user[0]->user_id,'','');
				}
				/***** Plan wise project limit calculation End ****/
				/***** Featured Job Balance Calculation Start ****/
		   		$user=$this->session->userdata('user');

				$user_wallet_id = get_user_wallet($user[0]->user_id);
				$user_id = $user[0]->user_id;
				if($this->input->post('featured')=="Y"){

			  	//$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

				$balance=get_wallet_balance($user_wallet_id);


				if(($this->input->post('project_type')=="F" && $balance<FIXED_RATE) || ($this->input->post('project_type')=="H" && $balance<HOURLY_RATE))
				{
					$msg['location']=VPATH.'myfinance/';
				}

			  	else if($this->input->post('project_type')=="F" && $balance>=FIXED_RATE){

						$this->load->helper('invoice');

						$this->load->model('myfinance/transaction_model');

						$inv_id = create_quick_invoice(0, $user_id, 5);

						add_quick_invoice_row($inv_id, 'Featured project',FIXED_RATE);

						$ref = json_encode(array( 'featured_fee' => FIXED_RATE));

						// transaction insert
						$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FEATURED,  $user_id, 'Y', $inv_id);



						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => FIXED_RATE, 'ref' => $ref , 'info' => '{Project_featured_fee}'));

						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => FIXED_RATE, 'ref' => $ref, 'info' => '{Project_featured_fee_received}'));

						wallet_less_fund($user_wallet_id,  FIXED_RATE);

						wallet_add_fund(PROFIT_WALLET, FIXED_RATE);

						check_wallet($user_wallet_id,  $new_txn_id);

						check_wallet(PROFIT_WALLET,  $new_txn_id);

						$featured="Y";

						$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));

				}elseif($this->input->post('project_type')=="H" && $balance>=HOURLY_RATE){

					$this->load->helper('invoice');

					$this->load->model('myfinance/transaction_model');

					$inv_id = create_quick_invoice(0, $user_id, 5);

					add_quick_invoice_row($inv_id, 'Featured project',HOURLY_RATE);

					$ref = json_encode(array( 'featured_fee' => HOURLY_RATE));

					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FEATURED,  $user_id , 'Y', $inv_id);



					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => HOURLY_RATE, 'ref' => $ref , 'info' => '{Project_featured_fee}'));

					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => HOURLY_RATE, 'ref' => $ref, 'info' => '{Project_featured_fee_received}'));

					wallet_less_fund($user_wallet_id,  HOURLY_RATE);

					wallet_add_fund(PROFIT_WALLET, HOURLY_RATE);

					check_wallet($user_wallet_id,  $new_txn_id);

					check_wallet(PROFIT_WALLET,  $new_txn_id);

					$featured="Y";

					$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));

						/* $data_transaction=array(
						"user_id" =>$this->input->post('user_id'),
						"amount" =>HOURLY_RATE,
						"profit" =>HOURLY_RATE,
						"transction_type" =>"DR",
						"transaction_for" => "Featured project",
						"transction_date" => date("Y-m-d H:i:s"),
						"status" => "Y"
					);

					$data_user=array(
						"acc_balance"=>($balance - HOURLY_RATE)
					);

					if($this->insertTransaction($data_transaction)){
						$this->updateUser($data_user,$this->input->post('user_id'));
						 $featured="Y";
					}	 */

				}
			}



		   /***** Featured Job Balance Calculation End ****/
			}
			elseif(!$this->session->userdata('user'))
			{
				//echo "pritam2";die();
				if($this->input->post('featured')=="Y"){

					$msg['location']=VPATH.'login/';
				}
			}

			 /*if($project_count < $project_plan_limit)*/
			 if($this->session->userdata('user') && true)
			 {
				$p_id_public = time();
					$data = array(
                            'project_id' => $p_id_public,
                            'title' => filter_data($this->input->post('title')),
                            'description' => filter_data($this->input->post('description')),
                           /*  'category' => $this->input->post('category_id'),
                            'sub_category' => $this->input->post('subcategory_id'), */
		 	    			'environment' => filter_data($this->input->post('environment')),
                            'project_type' => filter_data($this->input->post('project_type')),
                            'visibility_mode' => filter_data($this->input->post('visibility')),
                            'buget_min' => filter_data($bmin),
                            'buget_max' => filter_data($bmax),
                            'multi_freelancer' => filter_data($multi_freelancer),
                            'no_of_freelancer' => filter_data($no_of_freelancer),
                            'fixed_budget' => filter_data($fixed_budget),

                            'user_city'=>filter_data($this->auto_model->getFeild("city","user","user_id",$user_id)),
                            'user_country'=>filter_data($this->auto_model->getFeild("country","user","user_id",$user_id)),
                            'attachment' => ltrim($this->input->post('upload_file'),","),
                            'featured' =>  filter_data($featured),
                            'post_date' => date("Y-m-d"),
                            'post_time' => date("Y-m-d H:i:s"),

                            'expiry_date' => date("Y-m-d",  strtotime('+'.JOB_EXPIRATION.' day', strtotime(date("Y-m-d")))),
                            'user_id' => $user_id,
                            'status'=>'O',
							'hr_per_week' => filter_data($this->input->post('hr_per_week')),
							'project_status'=>'Y',
							'exp_level'=>filter_data($this->input->post('exp_level')),
			);
			parent::insert("projects", $data);
                        $this->db->insert('projects', $data);
                        $pid=$this->db->insert_id();

					/* Insert project questions */

					$qst = $this->input->post('questions');

					if(!empty($qst) && is_array($qst)){
						foreach($qst as $q){
							$q_array = array(
								'project_id' => $p_id_public,
								'question' => $q,
							);

							$this->db->insert('project_questions', $q_array);
						}
					}

					$freelancers = $this->input->post('freelancer');
					$p_name = getField('title','projects','id',$pid);
					$username = getField('username','user','user_id',$user_id);

					if(!empty($freelancers) AND count($freelancers) > 0){
						foreach($freelancers as $v){

							$notification = '{you_are_invited_for_the_project} :'.$p_name;
							$link = 'jobdetails/details/'.$p_id_public;
							$this->notification_model->log($user_id, $v, $notification, $link);

							$freelancer_fname = $this->auto_model->getFeild('fname' , 'user' , 'user_id' , $v);
							$inv = array(
								'employer_id' => $user_id,
								'freelancer_id' => $v,
								'project_id' => $p_id_public,
								'project_type' => $this->input->post('project_type'),
								'invitation_amount' => $bmin,
								'message' => "Hi $freelancer_fname, I noticed your profile and would like to offer you my project. We can discuss any details over chat.",
								'date' => date('Y-m-d'),

							);
							$this->db->insert('new_inviteproject', $inv);

							/* send mail here */

							$f_email = getField('email','user','user_id',$v);
							$mail_param = array(
								'name' => $freelancer_fname,
								'username' => $username,
								'project_name' => $p_name,
								'project_url' => base_url('jobdetails/details/'.$p_id_public),
								'copy_url' => base_url('jobdetails/details/'.$p_id_public),
							);

							send_layout_mail('invite_freelancer', $mail_param, $f_email);



						}
					}
			if ($pid) {
						if(count($subskillarr) > 0){
							$project_id = $this->auto_model->getFeild('project_id' , 'projects' , 'id' , $pid);
							foreach($subskillarr as $k => $v){
								$this->db->insert('project_skill' , array('project_id' => $project_id , 'skill_id' => $v));
							}
						}
                        $from=ADMIN_EMAIL;
						$to=ADMIN_EMAIL;
						$template='new_job_post';
						$data_parse=array('title'=>$this->input->post('title')
											);
					//	$this->auto_model->send_email($from,$to,$template,$data_parse);
                        $project_id=  $this->auto_model->getFeild("project_id","projects","id",$pid);
                         $msg['status']='OK';
			$msg['message']="<h3 class='postjob-alert-title'><span style='margin-right:10px'><i class='fa fa-check'></i></span>".__('postjob_job_post_success','Job Post Success')."</h3>
			<p> ".__('postjob_what_would_you_like_to_do_next','What would you like to do next')."?</p> <ul class='alert-choice'><li><a href='".VPATH."jobdetails/details/".$project_id."'>".__('postjob_preview_your_job','Preview your job')." </a></li> <li><a  href='".VPATH."postjob/editjob/".$pid."'> ".__('postjob_edit_your_job','Edit your job')." </a> </li>";


                         if($this->session->userdata('user')){

				$project_plan_limit=$this->auto_model->getFeild('project','membership_plan','id',$user[0]->membership_plan);
				if($user[0]->membership_plan!='1'){
					$membership_start=$this->auto_model->getFeild('membership_start','user','user_id',$user[0]->user_id);
					$membership_end=$this->auto_model->getFeild('membership_end','user','user_id',$user[0]->user_id);
					$project_count=$this->projectCount($user[0]->user_id,$membership_start,$membership_end);
				}
				else{
					$project_count=$this->projectCount($user[0]->user_id,'','');
				}

                             if($project_count < $project_plan_limit){
                                 $msg['message'].="<li><a href='".VPATH."postjob/'> ".__('postjob_post_another_job','Post another job')." </a></li>";
                             }
							 else
							 {

								$from=ADMIN_EMAIL;

									$to=$this->auto_model->getFeild('email','user','user_id',$user[0]->user_id);
									$fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
									$lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
									$template='job_post_limit_notification';
									$data_parse=array('name'=>$fname." ".$lname
														);
									//$this->auto_model->send_email($from,$to,$template,$data_parse);

							}
                         }


                        $msg['message'].="<li><a href='".VPATH."dashboard/profile_professional'> ".__('postjob_visit_your_profile_page','Visit your profile page')." </a></li></ul>";



			} else {
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='agree_terms';
				$msg['errors'][$i]['message']= 'dB error!';
			}
			}
			else
			{
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='limit_terms';
				$msg['errors'][$i]['message']= __('postjob_project_limit','You have exceeded the post project limit. Please upgrade your membership plan now to post more project.');
			}
		}
            unset($_POST);
            echo json_encode($msg);
	}

   public function updatepost_project() {

	$this->load->helper('date');
        $subskill="";
        if($this->input->post('subskill')!=""){
          $subskill=implode(",", $this->input->post('subskill'));
        }
        $subskillarr = $this->input->post('subskill');

       // $subskill= rtrim($subskill,",");


        $project_type=$this->input->post('project_type');
        $ball=$this->input->post('budgetall');
        $fixed_budeget=$this->input->post('fixed_budeget');
		  if($ball=='other'){
		  	$fixed_budget='Y';
		  }else{
		  	$fixed_budget='N';
		  }
        $bmin=0;
        $bmax=0;
        if($ball!="" && $project_type=="F"){

        if($ball=='other'){
			$bmin=$this->input->post('fixed_budeget');
            $bmax=$this->input->post('fixed_budeget');

		}else{
			$b=  explode("#",$this->input->post('budgetall'));
            $bmin=$b[0];
            $bmax=$b[1];
		}




        }
        else{
            $bmin=$this->input->post('budget_min');
            $bmax=$this->input->post('budget_max');
        }
        if($project_type=='H' && $this->input->post('multi_freelancer')=='Y'){
			$multi_freelancer=$this->input->post('multi_freelancer');
			$no_of_freelancer=$this->input->post('no_of_freelancer');
		}else{
			$multi_freelancer='N';
			$no_of_freelancer='0';
		}

		$i=0;
		$title=$this->input->post('title');
		$description=$this->input->post('description');
         $category=$this->input->post('category_id');


		$subcategory=$this->input->post('subcategory_id');
		//$subskill=$subskill;
		$project_type=$this->input->post('project_type');
		//$budget_min=$this->input->post('budget_min');
                //$budget_max=$this->input->post('budget_max');

		if($title==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='title';
			$msg['errors'][$i]['message']=__('postjob_please_enter_job_title','Please Enter Job Title');
			$i++;
		}
		if($description==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='description';
			$msg['errors'][$i]['message']=__('postjob_please_enter_description','Please Enter Description');
			$i++;
		}
               /*  if($category==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='category_id';
			$msg['errors'][$i]['message']="Please Select Category";
			$i++;
		}

                if($subcategory==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='subcategory_id';
			$msg['errors'][$i]['message']="Please Select Sub Category";
			$i++;
		}    */

                if($subskill==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='subskill_id';
			$msg['errors'][$i]['message']=__('postjob_please_select_skill','Please Select Skill');
			$i++;
		}

			if($project_type=='F')
			{
             	if($ball=="" || $ball=="0"){
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='budgetall';
					$msg['errors'][$i]['message']=__('postjob_please_select_your_budget','Please Select your Budget');
					$i++;
				}elseif($ball=="other" && ($fixed_budeget=="0" || !preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $fixed_budeget))){
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='budgetall';
					$msg['errors'][$i]['message']=__('postjob_please_select_your_budget','Please Select your Budget');
					$i++;
				}
        	}
			elseif($project_type=='H')
            {

                if($bmax=="" && $bmin==""){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='budget';
			$msg['errors'][$i]['message']=__('postjob_please_select_enter_your_budget','Please Select/Enter your Budget');
			$i++;
              }else{
				  if($bmax<3){
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='budget';
					$msg['errors'][$i]['message']="Minimum Budget $3";
					$i++;
				  }
				  if($bmin<3) {
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='budget';
					$msg['errors'][$i]['message']="Minimum Budget $3";
					$i++;
				  }
			  }
               if($multi_freelancer=='Y'){
				  if($no_of_freelancer<1){
				  	$msg['status']='FAIL';
					$msg['errors'][$i]['id']='no_of_freelancer';
					$msg['errors'][$i]['message']=__('postjob_enter_your_valid_number','Enter your Valid number');
					$i++;
				  }
			  }
          }

		    $featured="N";
		   	$featured=$this->auto_model->getFeild("featured","projects","id",$this->input->post("pid"));

		   $user=$this->session->userdata('user');
		   $user_wallet_id = get_user_wallet($user[0]->user_id);
		   $user_id = $user[0]->user_id;

		if($this->input->post('featured')=="Y" && $featured == "N"){
			$balance=get_wallet_balance($user_wallet_id);

			if(($this->input->post('project_type')=="F" && $balance<FIXED_RATE) || ($this->input->post('project_type')=="H" && $balance<HOURLY_RATE)){

				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='fund';
				$msg['errors'][$i]['message']='You do not have enough fund. Please <a href="'.base_url('myfinance').'" target="_blank">add fund.</a>';
				$i++;

			}

		}


                if($i==0){
                    $input_data="";

				/***** Featured Job Balance Calculation Start ****/
                            $featured="N";
		   		$featured=$this->auto_model->getFeild("featured","projects","id",$this->input->post("pid"));
                              if($featured=="N"){
                                   if($this->input->post('featured')=="Y"){
											$user_wallet_id = get_user_wallet($this->input->post('user_id'));

                                            //$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$this->input->post('user_id'));
                                            $balance=get_wallet_balance($user_wallet_id);

                                            if($this->input->post('project_type')=="F" && $balance>=FIXED_RATE){
													$this->load->helper('invoice');
													$this->load->model('myfinance/transaction_model');

													$inv_id = create_quick_invoice(0, $user_id, 5);

													add_quick_invoice_row($inv_id, 'Featured project',FIXED_RATE);


													$ref = json_encode(array( 'featured_fee' => FIXED_RATE));

													// transaction insert
													$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FEATURED,  $user_id, 'Y', $inv_id);



													$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => FIXED_RATE, 'ref' => $ref , 'info' => '{Project_featured_fee}'));

													$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => FIXED_RATE, 'ref' => $ref, 'info' => '{Project_featured_fee_received}'));

													wallet_less_fund($user_wallet_id,  FIXED_RATE);

													wallet_add_fund(PROFIT_WALLET, FIXED_RATE);

													check_wallet($user_wallet_id,  $new_txn_id);

													check_wallet(PROFIT_WALLET,  $new_txn_id);

													$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));

													$featured="Y";

                                                     /*  $data_transaction=array(
                                                            "user_id" =>$this->input->post('user_id'),
                                                            "amount" =>FIXED_RATE,
                                                            "profit" =>FIXED_RATE,
                                                            "transction_type" =>"DR",
                                                            "transaction_for" => "Featured project",
                                                            "transction_date" => date("Y-m-d H:i:s"),
                                                            "status" => "Y"
                                                    );

                                                    $data_user=array(
                                                            "acc_balance"=>($balance - FIXED_RATE)
                                                    );

                                                    if($this->insertTransaction($data_transaction)){
                                                            $this->updateUser($data_user,$this->input->post('user_id'));
                                                             $featured="Y";
                                                    }	 */
                                      }
                                      else if($this->input->post('project_type')=="H" && $balance>=HOURLY_RATE){
													$this->load->helper('invoice');
													$this->load->model('myfinance/transaction_model');

													$inv_id = create_quick_invoice(0, $user_id, 5);

													add_quick_invoice_row($inv_id, 'Featured project',HOURLY_RATE);

													$ref = json_encode(array( 'featured_fee' => HOURLY_RATE));

													// transaction insert
													$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FEATURED,  $user_id, 'Y', $inv_id);



													$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => HOURLY_RATE, 'ref' => $ref , 'info' => '{Project_featured_fee}'));

													$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => HOURLY_RATE, 'ref' => $ref, 'info' => '{Project_featured_fee_received}'));

													wallet_less_fund($user_wallet_id,  HOURLY_RATE);

													wallet_add_fund(PROFIT_WALLET, HOURLY_RATE);

													check_wallet($user_wallet_id,  $new_txn_id);

													check_wallet(PROFIT_WALLET,  $new_txn_id);

													$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));

													$featured="Y";

													/* $featured="Y";

                                                            $data_transaction=array(
                                                            "user_id" =>$this->input->post('user_id'),
                                                            "amount" =>HOURLY_RATE,
                                                            "profit" =>HOURLY_RATE,
                                                            "transction_type" =>"DR",
                                                            "transaction_for" => "Featured project",
                                                            "transction_date" => date("Y-m-d H:i:s"),
                                                            "status" => "Y"
                                                    );

                                                    $data_user=array(
                                                            "acc_balance"=>($balance - HOURLY_RATE)
                                                    );

                                                    if($this->insertTransaction($data_transaction)){
                                                            $this->updateUser($data_user,$this->input->post('user_id'));
                                                             $featured="Y";
                                                    }		 */

                                      }
                                    }

                              }




		   /***** Featured Job Balance Calculation End ****/



			$data = array(
                            'title' => filter_data($this->input->post('title')),
                            'description' => filter_data($this->input->post('description')),
                           /*  'category' => $this->input->post('category_id'),
                            'sub_category' => $this->input->post('subcategory_id'), */
							'environment' => filter_data($this->input->post('environment')),
                            'project_type' => filter_data($this->input->post('project_type')),
                            'visibility_mode' => filter_data($this->input->post('visibility')),
                            'hr_per_week' => filter_data($this->input->post('hr_per_week')),
                            'buget_min' => filter_data($bmin),
                            'buget_max' => filter_data($bmax),
                            'multi_freelancer' => filter_data($multi_freelancer),
                            'no_of_freelancer' => filter_data($no_of_freelancer),
                            'fixed_budget' => filter_data($fixed_budget),
                            //'skills' => $subskill,
                            'attachment' => ltrim($this->input->post('upload_file'),","),
                            'status' =>'O',
							'exp_level'=>filter_data($this->input->post('exp_level')),
                            'featured' =>  $featured
			);
			//parent::insert("projects", $data);
                        $id=  $this->input->post("pid");
                        $this->db->where('id', $id);


			if ($this->db->update('projects', $data)){
							$project_id = $this->auto_model->getFeild('project_id' , 'projects' , 'id' , $id);

							/* Insert project questions */

							$qst = $this->input->post('questions');
							$this->db->where('project_id', $project_id)->delete('project_questions');
							if(!empty($qst) && is_array($qst)){
								foreach($qst as $q){
									$q_array = array(
										'project_id' => $project_id,
										'question' => $q,
									);

									$this->db->insert('project_questions', $q_array);
								}
							}


							$this->db->where('project_id', $project_id)->delete('project_skill');
							if(count($subskillarr) > 0){
								foreach($subskillarr as $k => $v){
									$this->db->insert('project_skill' , array('project_id' => $project_id , 'skill_id' => $v));
								}
							}
                            $msg['status']='OK';

                            $project_id=  $this->auto_model->getFeild("project_id","projects","id",$id);
							$link=VPATH."jobdetails/details/".$project_id;
							$all_bidder=$this->getBidder($project_id);
							$from=ADMIN_EMAIL;
							foreach($all_bidder as $key=>$val)
							{
								$to=$this->auto_model->getFeild('email','user','user_id',$val['bidder_id']);
								$fname=$this->auto_model->getFeild('fname','user','user_id',$val['bidder_id']);
								$lname=$this->auto_model->getFeild('lname','user','user_id',$val['bidder_id']);
								$template='edit_job_notification';
								$data_parse=array('name'=>$fname." ".$lname,
													'title'=>$this->input->post('title'),
													'copy_url'=>$link,
													'url_link'=>$link
													);
								$this->auto_model->send_email($from,$to,$template,$data_parse);
							}

                            $msg['message']="<h4>".__('postjob_job_update_success','Job Update Success')."</h4><p>".__('postjob_what_would_you_like_to_do_next','What would you like to do next')."?</p><div class='spacer-20'></div><ul class='alert_list'><li><a href='".VPATH."jobdetails/details/".$project_id."'>".__('postjob_preview_your_job','Preview your job')."</a></li><li><a href='".VPATH."postjob/editjob/".$id."'>".__('postjob_edit_your_job','Edit your job')."</a></li><li><a href='".VPATH."dashboard/profile_professional'>".__('postjob_visit_your_profile_page','Visit your profile page')."</a></li></ul><div class='spacer-10'></div>";
			} else {
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='agree_terms';
				$msg['errors'][$i]['message']= 'dB error!';
			}
		}
		unset($_POST);
		echo json_encode($msg);
	}



    public function getpcatname($catname){
       return $catid=$this->auto_model->getFeild("parent_id","categories","cat_name",$catname);
    }

    public function getpskillname($skillname){
       return $catid=$this->auto_model->getFeild("cat_id","skills","skill_name",$skillname);
    }
	public function getProject($status='',$id='')
	  {

	  		$this->db->select("*");
            if($status=='')
			{
				$status='O';
			}

                        if($id!=""){
                            $this->db->where("id",$id);
                        }

                            $this->db->where("status",$status);

			$rs=$this->db->get('projects');
			//echo $Num=$rs->num_rows(); die;

			//echo $this->db->last_query();
			if( $rs->num_rows()=='0' ){


				$this->db->select("*");


                        if($id!=""){
                            $this->db->where("id",$id);
                        }

                            $this->db->where("status",'E');

			$rs=$this->db->get('projects');



			}

			$data=array();
			foreach($rs->result() as $row)
			{
				$data[]=array(
				'id'=>$row->id,
				'project_id'=>$row->project_id,
				'title'=>$row->title,
				'description'=>$row->description,
				'category'=>$row->category,
				'sub_category'=>$row->sub_category,
				'skills'=>$row->skills,
				'environment'=>$row->environment,
				'project_type'=>$row->project_type,
				'buget_min'=>$row->buget_min,
				'buget_max'=>$row->buget_max,
				'fixed_budget'=>$row->fixed_budget,
				'featured'=>$row->featured,
				'expiry_date'=>$row->expiry_date,
				'attachment'=>$row->attachment,
				'bidder_id'=>$row->bidder_id,
				'user_id'=>$row->user_id,
				'expiry_date_extend'=>$row->expiry_date_extend,
				'multi_freelancer'=>$row->multi_freelancer,
				'no_of_freelancer'=>$row->no_of_freelancer,
				'hr_per_week'=>$row->hr_per_week,
				'exp_level'=>$row->exp_level,
				'posted_date'=>$row->post_date
				);
			}
			return $data;
	  }
	   public function insertTransaction($data){
              return $this->db->insert('transaction', $data);
          }

          public function updateUser($data,$uid){
              $this->db->where('user_id', $uid);
              $this->db->update('user', $data);
          }
	  public function projectCount($user_id,$start='',$end='')
	  {
			$this->db->select('id');
			$this->db->where('user_id',$user_id);
			if($start!='' && $end!='')
			{
				$this->db->where("post_date BETWEEN ".$start." AND ".$end."");
			}
			$this->db->from('projects');
			return $this->db->count_all_results();
	 }

	 public function getBidder($project_id='')
	 {
			$this->db->select('bidder_id');
			$this->db->where('project_id',$project_id);
			$res=$this->db->get('bids');
			$data=array();
			foreach($res->result() as $row)
			{
				$data[]=array(
					'bidder_id'=>$row->bidder_id
				);
			}
			return $data;
	 }

	 public function getcatskill($pid){
        $this->db->select("id,skill_name");
        $con=array(
           "cat_id" => $pid,
           "status" => "Y"
        );
        $this->db->order_by("skill_name");
        $res=$this->db->get_where("skills",$con);
        $data=array();

        foreach ($res->result() as $row){
            $data[]=array(
               "id" => $row->id,
               "skill_name" => $row->skill_name
            );
        }

        return $data;
    }

	public function search_freelancer($term=''){
		$this->db->select('u.user_id,u.fname,u.lname,u.username,u.hourly_rate,u.logo')
			->from('user u')
			->where(array('account_type' => 'F', 'v_stat' => 'Y','status' => 'Y'))
			->like("CONCAT(u.fname, ' ',u.lname)", trim($term));


		$res = $this->db->order_by('u.fname', 'ASC')->get()->result_array();

		return $res;
	}
}
