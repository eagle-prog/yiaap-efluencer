<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Myfinance extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('myfinance_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        parent::__construct();
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('notification/notification_model');
		$idiom=$this->session->userdata('lang');
		$this->lang->load('dashboard', $idiom);
		$this->lang->load('myfinance', $idiom);
		$this->lang->load('form_validation', $idiom);
		$this->lang->load('transaction', $idiom);
    }

    public function index() {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{

			$user=$this->session->userdata('user');

			$data['user_id']=$user[0]->user_id;
				  
					
			$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$data['balance']=get_wallet_balance($user_wallet_id);
			// Get the Question  From model
			$data['question']=$this->myfinance_model->getUpdatedAnswer();

			$data['ldate']=$user[0]->ldate;

			$breadcrumb=array(
						array(
								'title'=>__('my_finance','My Finance'),'path'=>''
						)
					);

			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

			///////////////////////////Leftpanel Section start//////////////////

			$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

			$data['paypal_setting']=$this->auto_model->getFeild('withdrawl_method_paypal','setting');

			$data['wire_setting']=$this->auto_model->getFeild('withdrawl_method_wire_transfer','setting');
			
			$data['skrill_setting']=$this->auto_model->getFeild('method_skrill','setting');
					
	  
					
					
			if($logo==''){
				$logo="images/user.png";
			}else{
				if(file_exists('assets/uploaded/cropped_'.$logo)){
					$logo="uploaded/cropped_".$logo;
				}else{
					$logo="uploaded/".$logo;
				}
				
			}
			
			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

			$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

			///////////////////////////Leftpanel Section end//////////////////

			$head['current_page']='myfinance';
			$head['ad_page']='myfinance';

			$load_extra=array();

			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

			$this->layout->set_assest($head);

				  

		
			$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

			$lay['client_testimonial']="inc/footerclient_logo";

			$this->layout->view('details',$lay,$data,'normal');

		}        
    }

	// checkAnswerBeforePay  
	
	
	public function checkAnswerBeforePay(){
	
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;	  
		$this->auto_model->checkrequestajax();
		if($this->input->post()){	
		//Setting values for Table columns
		$data= array(
		'user_id' => $user_id,
		'answers' => $this->input->post('answer')
		);
		
		//Transfer  data to Model
		$reultStaus = $this->myfinance_model->checkAnswerBeforePayQuery($data);
		print $reultStaus; die; 
	   }     
		
	}
	
	
	
	
	
	
    public function payment_confirm(){
        $user=$this->session->userdata('user');

        $data['user_id']=$user[0]->user_id;


        $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

        $data['ldate']=$user[0]->ldate;

        $breadcrumb=array(
            array(
                    'title'=>__('my_finance','My Finance'),'path'=>''
            )
        );

        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

        ///////////////////////////Leftpanel Section start//////////////////

        $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

        if($logo==''){
                $logo="images/user.png";
        }else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

        $data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

        ///////////////////////////Leftpanel Section end//////////////////

        $head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);




        $this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

        $lay['client_testimonial']="inc/footerclient_logo";

        $user_id=$user[0]->user_id;        
        
        $pay_id=  $this->uri->segment(3);
      
        if($user_id!=$pay_id)
        {
            redirect(base_url(). "myfinance/wrong_entry");
        }
        else{
			
			$this->layout->view('thankyou',$lay,$data,'normal');           
        }
               
    }
    
    public function paypal_notify(){
		
        
		$this->load->model('transaction_model');
		
        $user_id=  $this->uri->segment(3);
		$msg = json_encode($this->input->post());
		
		file_put_contents('paypal.log', $msg);
		
		$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);
		
		$user_wallet_id = get_user_wallet($user_id);
		$acc_balance=get_wallet_balance($user_wallet_id);
		
        if($this->input->post('payment_status')=="Completed"){ 
            $post['status']="Y";
            $post['paypal_transaction_id']=$this->input->post('txn_id');
            $post['amount']=($this->input->post('mc_gross')-$this->input->post('payment_fee'));
            $post['transction_type']="CR";
            $post['transaction_for']="Add Fund";
            $post['user_id']=$user_id;
            $post['transction_date']=date("Y-m-d H:i:s");
         
           /*$id=$this->myfinance_model->insertTransaction($post);*/
		   
		   // transaction insert
		   $new_txn_id = $this->transaction_model->add_transaction(ADD_FUND_PAYPAL,  $user_id);
           
            if($user_id && $new_txn_id){ 
				
				/* $tot_balance=($acc_balance+$post['amount']);
                $this->myfinance_model->updateUser($tot_balance,$user_id); */
				
				// Affected transaction row and wallet
				
				$user_wallet_id = get_user_wallet($user_id);
				
				// credit main wallet 
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'credit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => '{Fund_added_through_paypal}'));
				
				// transfer money from main wallet to user wallet 
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'debit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => '{Fund_added_through_paypal}'));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => '{Fund_added_through_paypal}'));
				
				wallet_add_fund($user_wallet_id, $post['amount']);
				
				check_wallet($user_wallet_id,  $new_txn_id);
				
				//payment success email
				
				$user_name=$this->auto_model->getFeild('username','user','user_id',$user_id);

				$to=$this->auto_model->getFeild('email','user','user_id',$user_id);

				$from=ADMIN_EMAIL;

				$template='add_fund_client';
				$amount = $this->input->post('mc_gross');
				$paypalfee = $this->input->post('payment_fee');
				$rst_amt = floatval($amount - $paypalfee);

				$data_parse=array('name'=>$user_name,
					'amount'=>$amount,
					'paypalfee'=>$paypalfee,
					'rstamount'=>$rst_amt
				);

				send_layout_mail($template, $data_parse, $to, $from);
			
            }
            
        }
        else{ 
            
        }
        
       
    }
    
    public function payment_cancel(){ 

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");
        $lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('cancel',$lay,$data,'normal');        
        
        
        
        
        
        
 
      /*  $user=$this->session->userdata('user');

        $user_id=$user[0]->user_id;        
        
        $pay_id=  $this->uri->segment(3);
      
        if($claim_id!=$pay_id)
        {
            redirect(base_url(). "myfinance/wrong_entry");
        }
        else{ 
           $this->layout->view('cancel', '', "", 'normal', 'N');          
        }    */    
        
    }   
    
    public function wrong_entry(){ 
        $this->layout->view('wrong', '', "", 'normal', 'N');
    }        

    public function transaction($limit_from=''){ 
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                     'title'=>__('my_finance_txn_history','Transaction History'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='all_transaction';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		
                
                
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'myfinance/transaction/';
		if($this->input->post())
		{
			$from=$this->input->post('from_txt');
			$to=$this->input->post('to_txt');
			if($from && $to)
			{
				$total_rows=$this->myfinance_model->getfilterTransactionCount($user[0]->user_id,$from,$to);
			}
			else
			{
				$total_rows=$this->myfinance_model->getTransactionCount($user[0]->user_id);		
			}
		}
		else
		{
			$total_rows=$this->myfinance_model->getTransactionCount($user[0]->user_id);	
		}
		
                
				$config['total_rows'] =$total_rows;
				$config['per_page'] = 5; 
				$config["uri_segment"] = 3;
				$config['use_page_numbers'] = TRUE;  
                
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = '</ul>';
                $config['first_link'] = 'First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
                $config['cur_tag_close'] = '</a></li>';
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
                if ($page > 0) {
                    for ($i = 1; $i < $page; $i++) {
                        $start = $start + $per_page;
                    }
                }
		
         $data['transaction_count']=$total_rows;
         $data['links']=$this->pagination->create_links();       
         $this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		$data['tot_debit']=$this->myfinance_model->getAlldebit($user[0]->user_id);
		$data['tot_credit']=$this->myfinance_model->getAllcredit($user[0]->user_id); 
		$data['from']='';
		$data['to']='';
		if($this->input->post())
		{
			//print_r($this->input->post()); die();
			$data['from']=$from=$this->input->post('from_txt');
			$data['to']=$to=$this->input->post('to_txt');
			if($from && $to)
			{
				$data['transaction_list']=$this->myfinance_model->filterTransaction($user[0]->user_id,$from,$to,$config['per_page'],$start);	
			}
			else
			{
				$data['transaction_list']=$this->myfinance_model->getTransaction($user[0]->user_id,$config['per_page'],$start);	
			}	
		}
		else
		{
                
        	$data['transaction_list']=$this->myfinance_model->getTransaction($user[0]->user_id,$config['per_page'],$start);
		}
		//print_r($data);
		//die();
		
		/* -------------------New transaction history (Bishu) ------------------ */
		
		
		$page = ($limit_from) ? $limit_from : 0;
		$per_page = 5;
		$start = 0;
		if ($page > 0) {
			for ($i = 1; $i < $page; $i++) {
				$start = $start + $per_page;
			}
		}
		 
		$data['srch'] = $srch = $this->input->get();
		$wallet_id = get_user_wallet($user[0]->user_id);
		
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		$data['balance'] = get_wallet_balance($wallet_id);
		$data['all_data'] = $this->myfinance_model->getWalletTxn($srch,  $start, $per_page);
		
		$data['all_data_count'] = $this->myfinance_model->getWalletTxn($srch, '', '', FALSE);
		
		
		
		$data['debit_total'] = $this->myfinance_model->wallet_debit_balance($wallet_id);
		$data['credit_total'] = $this->myfinance_model->wallet_credit_balance($wallet_id);
		
		$config2['total_rows'] =$data['all_data_count'] ;
		$config2['per_page'] = $per_page; 
		$config2["uri_segment"] = 3;
		$config2['use_page_numbers'] = TRUE;  
		
		$config2['full_tag_open'] = "<ul class='pagination'>";
		$config2['full_tag_close'] = '</ul>';
		$config2['first_link'] = __('pagination_first','First');
		$config2['first_tag_open'] = '<li>';
		$config2['first_tag_close'] = '</li>';
		$config2['num_tag_open'] = '<li>';
		$config2['num_tag_close'] = '</li>';
		$config2['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config2['cur_tag_close'] = '</a></li>';
		$config2['last_link'] = __('pagination_last','Last');
		$config2['last_tag_open'] = "<li class='last'>";
		$config2['last_tag_close'] = '</li>';
		$config2['next_link'] = __('pagination_next','Next').' &gt;&gt;';
		$config2['next_tag_open'] = "<li>";
		$config2['next_tag_close'] = '</li>';
		$config2['prev_link'] = '&lt;&lt;'.__('pagination_previous','Previous');
		$config2['prev_tag_open'] = '<li>';
		$config2['prev_tag_close'] = '</li>';                 
		
		$this->pagination->initialize($config2); 
	    $data['links2']=$this->pagination->create_links(); 
		
		$this->layout->view('transaction_history',$lay,$data,'normal');      
        
        }
        
    }
    
    public function milestone($project_id=''){ 
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);
		
		$data['project_id']=$project_id;
		
		if($project_id!='')
		{
        
        	$data['set_milestone_list']=$this->myfinance_model->getsetMilestone($project_id);
		
		}

		$data['outgoint_milestone_list']=$this->myfinance_model->getOutgoingMilestone($user[0]->user_id);
		
		$data['incoming_milestone_list']=$this->myfinance_model->getIncomingMilestone($user[0]->user_id);                
		
		$breadcrumb=array(
			array(
					'title'=>__('my_milestone','My Milestone'),'path'=>''
			)
		);

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_milestone','My Milestone'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='milestone';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);
	
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
     
		$this->layout->view('milestone',$lay,$data,'normal');

	}          
    }

    public function workerDetails(){ 
        $pid=$this->input->post("pid");
        $wid= $this->auto_model->getFeild("bidder_id","projects","project_id",$pid);
		$ptype= $this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $wfname=$this->auto_model->getFeild("fname","user","user_id",$wid);
        $wlname=$this->auto_model->getFeild("lname","user","user_id",$wid);
        $total_bid_amount=$this->auto_model->getFeild("total_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
		 $bidder_amount=$this->auto_model->getFeild("bidder_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
        $paid_amount=$this->myfinance_model->getPaidAmount($pid,$wid);
        if($ptype=='F')
		{
        $result="<div class='acount_form'><p>".__('myfinance_provide_user','Provide User')." :</p><div id='mysubcat'>".$wfname." ".$wlname."<br>
            <input type='hidden' name='worker_id' value='".$wid."'>
			<input type='hidden' id='paid_amount' name='paid_amount' value='".$paid_amount."'>
			<input type='hidden' id='remaining_amount' name='remaining_amount' value='".($total_bid_amount-$paid_amount)."'>
			<input type='hidden' name='proj_type' id='proj_type' value='".$ptype."'/>
			
  <label id='displabel'>".__('myfinance_total_bid_amount','Total Bid Amount')." : ".CURRENCY." ".$total_bid_amount."</label><br>
  <p></p><label id='displabel'>".__('myfinance_remaining_payment','Remaining Payment')." : ".CURRENCY." ".($total_bid_amount-$paid_amount)."</label>	
</div>
<div class='acount_form'><p>".__('myfinance_how_much_money_would_you_like_to_transfer','How much money would you like to transfer')." ? ".CURRENCY."  :</p>
<input type='text' class='acount-input' onblur='valcheck(this.value)' id='payamount' size='15' name='payamount' title='".__('myfinance_enter_your_milestone_payment_amount','Enter your milestone payment amount')."' tooltipText='".__('myfinance_how_much_money_would_you_like_to_transfer','How much money would you like to transfer')." ?' />    
".form_error('payamount', '<div class="error-msg3">', '</div>')."
</div>";
		}
		else
		{
		$result="<div class='acount_form'><p>".__('myfinance_provide_user','Provide User')." :</p><div id='mysubcat'>".$wfname." ".$wlname."<br>
            <input type='hidden' name='worker_id' value='".$wid."'>
			<input type='hidden' id='paid_amount' name='paid_amount' value='".$paid_amount."'>
			<input type='hidden' id='hour_amount' name='hour_amount' value='".$total_bid_amount."'>
			<input type='hidden' name='proj_type' id='proj_type' value='".$ptype."'/>
			
  <label id='displabel'>".__('myfinance_hourly_rate','Hourly Rate')." : ".CURRENCY." ".$total_bid_amount."</label><br>	
</div>
<div class='acount_form'><p>".__('myfinance_enter_total_hour_of_payment','Enter Total Hour of Payment')."? :</p>
<input type='text' class='acount-input' id='total_hour' onblur='putval(this.value)' size='15' name='total_hour' title='".__('myfinance_enter_your_milestone_payment_hour','Enter your milestone payment hour')."' tooltipText='For ".__('myfinance_how_much_hour_would_you_like_to_transfer','How much hour would you like to transfer')." ?'/>    
".form_error('total_hour', '<div class="error-msg3">', '</div>')."
</div>
<div class='acount_form'><p>".__('myfinance_total_amount_will_be_transfer','Total Amount Will Be Transfer')." :".CURRENCY."  </p>
<input type='text' class='acount-input' id='payamount' size='15' name='payamount' title='".__('myfinance_enter_your_milestone_payment_amount','Enter your milestone payment amount')."' tooltipText='".__('myfinance_how_much_money_would_you_like_to_transfer','How much money would you like to transfer')." ?' readonly='readonly'/>    
".form_error('payamount', '<div class="error-msg3">', '</div>')."
</div>";	
		}
      echo $result;  
        
        
    }
    
    
    public function milestonepay(){ 
        
/* Page Details Start */
        
        $user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$acc_balance=$data['balance'];
                
                $data['project_list']=$this->myfinance_model->getProjectList($user[0]->user_id);

                $data['outgoint_milestone_list']=$this->myfinance_model->getOutgoingMilestone($user[0]->user_id);
                
                $data['incoming_milestone_list']=$this->myfinance_model->getIncomingMilestone($user[0]->user_id);                
		
                
                
		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='milestone';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);
	
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
/* Page Details End */        
        
       if($this->input->post("pay_btn")){ 
           
          
           $this->form_validation->set_rules('project_id', 'Project', 'required');
           $this->form_validation->set_rules('payamount', 'Transfer Amount', 'required|numeric');
           $this->form_validation->set_rules('reason_txt', 'Reason', 'required');
           if ($this->form_validation->run() == FALSE){ 
               $this->layout->view('milestone',$lay,$data,'normal');    
           }
           else{
			    
		   		$chk_escrow=$this->auto_model->getFeild('id',"escrow","project_id",$this->input->post('project_id'));
				$pln_id=$this->auto_model->getFeild('membership_plan','user','user_id',$user[0]->user_id);
                $bidwin_charge=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$pln_id);
				
                $post_data['bider_to_pay']=($this->input->post('payamount')-($this->input->post('payamount')*$bidwin_charge)/100);
                $post_data['employer_id'] =$user[0]->user_id;
                $post_data['project_id'] = $this->input->post('project_id');
                $post_data['worker_id'] = $this->input->post('worker_id');
                $post_data['payamount'] = $this->input->post('payamount');                
                $post_data['reason_txt'] = $this->input->post('reason_txt'); 
                $insert = $this->myfinance_model->insertMilestone($post_data);
                 
                if($insert){ 
                    
                    $data_transaction=array(
						"project_id" =>$this->input->post('project_id'),
                        "user_id" =>$user[0]->user_id,
                        "amount" =>$this->input->post('payamount'),
			            "profit" => ($this->input->post('payamount')*$bidwin_charge)/100,
                        "transction_type" =>"DR",
                        "transaction_for" => "Milestone Payment",
                        "transction_date" => date("Y-m-d H:i:s"),
                        "status" => "Y"
                    );

					if($chk_escrow>0)
					{
						$esc_balance=$this->auto_model->getFeild('payamount',"escrow","id",$chk_escrow);
						$balance=($esc_balance-$this->input->post('payamount'));	
					}
					else
					{
						$balance=($acc_balance-$this->input->post('payamount'));
					}
                    

                    if($this->myfinance_model->insertTransaction($data_transaction)){
					if($chk_escrow>0)
					{
						$this->myfinance_model->updateEscrow($balance,$chk_escrow);
						if($balance==0)
						{
							$status="I";
							$this->myfinance_model->update_Escrow($status,$chk_escrow);	
						} 
					}
					else
					{
						$this->myfinance_model->updateUser($balance,$user[0]->user_id);  
					}
					
					$from=ADMIN_EMAIL;
					$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$this->input->post('project_id'));
					$title=$this->auto_model->getFeild('title','projects','project_id',$this->input->post('project_id'));
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
					$template='milestone_set_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);	 
                    
                       $this->session->set_flashdata('succ_msg', __('myfinance_milestone_is_set_successfully_you_can_release_the_milestone_later','Milestone is set successfully.You can release the milestone later.'));
                       redirect(VPATH."myfinance/milestone");
                       
                    }              
                } 
                else{ 
                    $this->session->set_flashdata('error_msg', __('myfinance_milestone_payment_filed','Milestone Payment Filed'));
                    redirect(VPATH."myfinance/milestone");
                }
             $this->layout->view('milestone',$lay,$data,'normal');    
           }
           
       }
       else{ 
           $this->layout->view('milestone',$lay,$data,'normal');         
       }
    }

    public function releasepayment($milestone_id=''){
		 
     	$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
	    $mid=$this->auto_model->getFeild("id","milestone_payment","milestone_id",$milestone_id); 
		$milestone_title=$this->auto_model->getFeild("title","project_milestone","id",$milestone_id);
        $pid=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
        $wid=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		$ptype=$this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $bider_to_pay=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $worker_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$wid);
		
		$user_wallet_id = get_user_wallet($wid);
		$worker_balance=get_wallet_balance($user_wallet_id);
        
		$milestone_payment_status = $this->auto_model->getFeild("release_payment","project_milestone","id",$milestone_id); 
		
		$next = get('next');
		if($milestone_payment_status == 'Y'){
			if(!empty($next)){
				redirect(base_url($next));
			}
			redirect(VPATH."projectdashboard/milestone_employer/".$pid);
		}
		
      
		$data_milistone=array(
			"release_type" =>"P",
			"status" => "Y"
		);
        $this->myfinance_model->updateMilestone($data_milistone,$mid);	
		
		$val['release_payment']='Y';
		$val['fund_release']='A';
		$where=array("id"=>$milestone_id);
		$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
		
		$return_row=$this->myfinance_model->checkproject_milestone($pid);
		if($return_row==0)
		{
			$proj_data['status']='C';
			$this->myfinance_model->updateProject($proj_data,$pid);
		}
		
		$from=ADMIN_EMAIL;
		$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
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
		$employer_id=$data['user_id'];
		$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);
		
		$notification = htmlentities("{you_have_successfully_release_milestone}: ".$milestone_title." {for_the_project} ".$projects_title);
		$link = "projectdashboard_new/employer/milestone/".$pid;
		$this->notification_model->log($employer_id, $employer_id, $notification, $link);
			
			
		$notification1 = htmlentities("{payment_received_for_milestone}: ".$milestone_title." {for_the_project}  ".$projects_title);
		$link1 = "projectdashboard_new/freelancer/milestone/".$pid;
		$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
		
		$this->session->set_userdata('succ_msg',__('myfinance_you_have_successfully_release_this_milestone',"You have successfully release this milestone"));
		
		//redirect(VPATH."myfinance/milestone/".$pid);
		//redirect(VPATH."projectdashboard_new/milestone_employer/".$pid);
		if(!empty($next)){
			redirect(base_url($next));
		}
		redirect(VPATH."projectdashboard/milestone_employer/".$pid);
        
        
 
    }
    
    
    public function dispute($milestone_id=''){ 
		
		$mid=$this->auto_model->getFeild("id","milestone_payment","milestone_id",$milestone_id); 
		
		$milestone_title=$this->auto_model->getFeild("title","project_milestone","id",$milestone_id);       
        
		$project_id=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
		
		$project_title=$this->auto_model->getFeild("title","projects","project_id",$project_id);
        
        $disput_amt=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $employer_id=$this->auto_model->getFeild("employer_id","milestone_payment","id",$mid);
        
        $worker_id=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
        
        $data_dispute=array(
            "milestone_id" => $mid, 
            "employer_id" =>$employer_id,
            "worker_id" =>$worker_id,
            "disput_amt" =>$disput_amt,
            "add_date"=> date("Y-m-d"),
            "status"=>"N"
        );
        
        $did=$this->myfinance_model->insertDispute($data_dispute);
               
        if($did){          
            
            $data_milistone=array(
                "release_type" =>"D",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);    
            
            
            $data_dispute_discuss=array(            
                "disput_id" => $did,
                "employer_id" => $employer_id,
                "worker_id" => $worker_id,
                "employer_amt" => $disput_amt,
                "worker_amt" => "0.00",
                "accept_opt" => "W",
                "status" => "N",
            );      
            $this->myfinance_model->insertDisputDiscuss($data_dispute_discuss);
			
			$val['release_payment']='D';
			$where=array("id"=>$milestone_id);
			$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
			
			$post_data['from_id']=$employer_id;
			$post_data['to_id']=$worker_id;
			/*$post_data['notification']="One of your project: <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a> has been disputed. Please check your <a href='".VPATH."disputes/'>disputes list</a>.";
			$post_data['add_date']=date('Y-m-d');
			$post_data['read_status']='N';
			$this->dashboard_model->insert_Notification($post_data); */
			
			$notification = "{one_of_your_project}: ".$project_title." {has_been_disputed_please_check_your_disputes_list}.";
			$link = 'disputes/';
			$this->notification_model->log($employer_id, $worker_id, $notification, $link);
			
            $from=ADMIN_EMAIL;
			$to=ADMIN_EMAIL;
			$template='dispute_notification';
			$data_parse=array('title'=>$project_title
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);
			
			$from=ADMIN_EMAIL;
			$to_id= $worker_id;
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
			$template='milestone_dispute_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
		/*	$data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully dispute the milestone: <a href='".VPATH."myfinance/milestone/".$project_id."'>".$milestone_title."</a> for <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d"),
				   "read_status" =>'N'
				 );
				 
				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$worker_id,
				   "notification" =>"<a href='".VPATH."dashboard/MilestoneChart/".$project_id."'>Milestone: ".$milestone_title."</a> have been disputed for the project <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d"),
				   "read_status" =>'N'
				 );
				 
				 $this->myfinance_model->insert_notification($data_notification);
				 
				 $this->myfinance_model->insert_notification($data_notic); */
				 
				 
				 $notification = "{you_have_successfully_dispute_the_milestone}: ".$milestone_title." {for_the_project} ".$project_title;
				$link = "myfinance/milestone/".$project_id;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "{milestone}: ".$milestone_title." {have_been_disputed_for_the_project} ".$project_title;
				$link1 = "dashboard/MilestoneChart/".$project_id;
				$this->notification_model->log($employer_id, $worker_id, $notification1, $link1);
			
			$this->session->set_userdata('mile_succ',__('myfinance_you_have_successfully_dispute_this_milestone',"You have successfully dispute this milestone"));        
            
        }
        else{ 
            $this->session->set_userdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!!Something Got Wrong. Please Try Again Later."));
        }
		
		redirect(VPATH."myfinance/milestone/".$project_id);
        
        
                
    }    














    /*  public function check_balance(){ 
       $user=$this->session->userdata('user');       
       $balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
       if($balance>=$amt){
           return TRUE;
       } 
       else{ 
           $this->form_validation->set_message("check_balance", 'The %s field can not be the word "test"');
           return FALSE;
       }
    } */

	
	
	
	
	
	public function wire_setting(){
	
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id'] = $user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		///////////////////////////Leftpanel Section end//////////////////
		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");
		$lay['client_testimonial']="inc/footerclient_logo";
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);
		
	
		
		
		
		
		
		 if($this->input->post("save_wire")){ 
           
          
           $this->form_validation->set_rules('wire_account_no', 'Account Number', 'required');
           $this->form_validation->set_rules('wire_account_name', 'Account Name', 'required');
         /*  $this->form_validation->set_rules('wire_account_IFCI_code', 'IFCI code', 'required');*/
           $this->form_validation->set_rules('address', 'Address', 'required');
           $this->form_validation->set_rules('city', 'City', 'required');
		   $this->form_validation->set_rules('country', 'Country', 'required');
		   $this->form_validation->set_rules('wire_account_email', 'Email', 'required|valid_email');
		   if($this->form_validation->run() == FALSE){ 
		   
            $this->layout->view('wire_transfare',$lay,$data,'normal');    
           
		   }else{ 
          
			
		  
				$post_data['wire_account_no']= $this->input->post('wire_account_no');
                $post_data['user_id'] =  $user[0]->user_id;
                $post_data['wire_account_name'] = $this->input->post('wire_account_name');
                $post_data['wire_account_IFCI_code'] = $this->input->post('wire_account_IFCI_code');
                $post_data['city'] = $this->input->post('city');                
                $post_data['country'] = $this->input->post('country'); 
				$post_data['address'] = $this->input->post('address'); 
				$post_data['wire_account_email'] = $this->input->post('wire_account_email'); 
				
				$post_data['account_for'] = 'W';
				
				$post_data['status'] = 'Y';
				
				
                $insert = $this->myfinance_model->modify_account($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', __('myfinance_bank_account_is_set_successfully','Bank account is set successfully.'));
					
					}else{
					
					$this->session->set_flashdata('error_msg', __('myfinance_error_on_update_please_try_again','Error on update please try again'));
					
					}
					
					redirect(VPATH."myfinance/wire_setting");
		   
		   }
		   
	
		}else{
		
		$this->layout->view('wire_transfare',$lay,$data,'normal');      
        
		}
		
		
		
		
        }
	
	
	
	}
	
	
	
	public function paypal_setting(){
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('deposite_by_paypal_fees' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		 if($this->input->post("update")){ 
           $this->form_validation->set_rules('paypal_account', __('myfinance_paypal_account_no','PayPal Account Number'), 'required');
		   if($this->form_validation->run() == FALSE){ 
		   
				$this->layout->view('paypal_setting',$lay,$data,'normal');    
           
			}else{ 
		   
			
		   $post_data['paypal_account']= $this->input->post('paypal_account');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['account_for'] =  $this->input->post('account_for');
		   $post_data['status'] =  'Y';
		   
		   
		   $insert = $this->myfinance_model->modify_account($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', __('myfinance_detail_successfully_updated','Detail successfully updated'));
					
					}else{
					
					$this->session->set_flashdata('error_msg', __('myfinance_error_on_update_please_try_again','Error on update please try again'));
					
					}
					
					//redirect(VPATH."myfinance/paypal_setting");
					redirect(VPATH."myfinance/withdraw");
		   
		   
          
			 }
			}else{
			$this->layout->view('paypal_setting',$lay,$data,'normal');      
			}
       
	   }
	
	
	
	}
	public function skrill_setting(){
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('deposite_by_paypal_fees' ,'setting', 'id',1);
		$data['skrill_fees'] =$this->auto_model->getFeild('deposite_by_skrill_fees' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		 if($this->input->post("update")){ 
           $this->form_validation->set_rules('skrill_account', 'Skrill Account Number', 'required');
		   if($this->form_validation->run() == FALSE){ 
		   
				$this->layout->view('skrill_account',$lay,$data,'normal');    
           
			}else{ 
		   
			
		   $post_data['skrill_account']= $this->input->post('skrill_account');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['account_for'] =  $this->input->post('account_for');
		   $post_data['status'] =  'Y';
		   
		   
		   $insert = $this->myfinance_model->modify_account($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', __('myfinance_skrill_account_is_set_successfully','Skrill account is set successfully.'));
					
					}else{
					
					$this->session->set_flashdata('error_msg', __('myfinance_error_on_update_please_try_again','Error on update please try again'));
					
					}
					
					redirect(VPATH."myfinance/skrill_setting");
		   
		   
          
			 }
			}else{
			$this->layout->view('skrill_setting',$lay,$data,'normal');      
			}
       
	   }
	
	
	
	}
	public function transfer(){
	
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{
	

		$data['tras_type'] = $this->uri->segment(3);
	
		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=$balance=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('withdrawl_commission_paypal' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		$data['skrill_fees'] =$this->auto_model->getFeild('deposite_by_skrill_fees' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		
		
		
		
		if($this->input->post("save_wire")){ 
			
			$this->form_validation->set_rules('$balance', 'Total balance', '');
           $this->form_validation->set_rules('amount_transfer', 'Amount', 'required');
		   if($this->form_validation->run() == FALSE){ 
			$this->layout->view('transaction',$lay,$data,'normal');    
			}else{ 
			
			$post_data['transer_through'] =	$this->input->post('transfer_through'); 
		   
		   $post_data['admin_pay']= $this->input->post('total_amount');
		   $post_data['account_id']= $this->input->post('account_id');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['total_amount'] =  $this->input->post('amount_transfer');
		   $post_data['status'] =  'N';
		   if($post_data['total_amount']> $balance)
		   {
				  $this->session->set_flashdata('error_msg', __('myfinance_transfer_amount_should_not_be_greater_than_your_total_balance','Transfer amount should not be greater than your total balance')); 
				  redirect(VPATH."myfinance/transfer".strtolower($this->input->post('transfer_through')));
			}
			else
			{
		   
		   
				$insert = $this->myfinance_model->add_withdrawl($post_data);
				$withdraw_id = $this->db->insert_id();
				if($insert){
				
					$t_data['user_id'] =$user[0]->user_id;
					$t_data['amount'] = $this->input->post('amount_transfer');
					$t_data['profit'] = ($this->input->post('amount_transfer') - $this->input->post('total_amount'));
					$t_data['transction_type'] = "DR";
					$t_data['transaction_for'] = "Withdrawl";
					$t_data['transction_date'] = date('Y-m-d h:i:s');
					$t_data['status'] = 'N';
					
					$transation = $this->myfinance_model->add_transation($t_data);
					$txn_id = $this->db->insert_id();
					$this->db->where('withdrawl_id', $withdraw_id)->update('withdrawl', array('transaction_id' => $txn_id));
					
					
					$user_balance =  $this->input->post('user_balance');
					
					$updatet_balance = $user_balance - $this->input->post('amount_transfer');
					
					
					$this->myfinance_model->updateUser($updatet_balance,$user[0]->user_id);
					
					$fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
					
					$from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='withdrawl_request_notification';
					$data_parse=array('name'=>$fname." ".$lname
					);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
					
					$this->session->set_flashdata('succ_msg', __('myfinance_your_request_has_been_submitted','Your request has been submitted.'));

				}else{

				$this->session->set_flashdata('error_msg', __('myfinance_error_on_update_please_try_again','Error on update please try again'));

				}
				

				redirect(VPATH."myfinance/withdraw");
			   
			}
          
			}
		}else{
			
			$this->layout->view('transaction',$lay,$data,'normal');
			}
		
		
		
		

		
	
	
	}
	
	}
	
	
	public function send_withdraw_otp(){
		$this->load->library('mailtemplete');
		$user=$this->session->userdata('user');
		if($user){
			$user_id = $user[0]->user_id;
			$withdraw_amount = $this->input->post('total_amount');
			$otp = rand(1111111, 9999999);
			
			$expire_on = date('Y-m-d H:i:s', strtotime("+5 minutes"));
			
			$this->db->where('user_id', $user_id)->update('user', array('otp' => $otp, 'otp_expire_on' => $expire_on));
			// send mail to user
			
			$param = array(
				"{NAME}" => $this->auto_model->getFeild('fname', 'user', 'user_id', $user_id),
				"{AMOUNT}" => CURRENCY.$withdraw_amount,
				"{OTP}" => $otp,
			);
			$to_email = $this->auto_model->getFeild('email', 'user', 'user_id', $user_id);
			
			$contact = $this->auto_model->get_setting();
			$from = ADMIN_EMAIL;
			/* $ml=$this->mailtemplete->send_mail($from, $to_email, 'withdraw_otp', $param); */
			$template = 'withdraw_otp';
			send_layout_mail($template, $param, $to_email);
			
			$json['status'] = 1;
			$json['otp'] = $otp;
			$json['msg'] = __('myfinance_an_OTP_has_been_send_to_your_email_id_Enter_OTP_to_confirm_withdraw','An OTP has been send to your email id. Enter OTP to confirm withdraw');
			
			echo json_encode($json);
		}
		
	}
	
	public function transfer_ajax(){
		if($this->input->post()){
			$json = array();
			$user=$this->session->userdata('user');
			$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
			
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$balance=get_wallet_balance($user_wallet_id);
			
			$this->form_validation->set_rules('amount_transfer', 'Amount', 'required');
			
			if($this->form_validation->run()){
				
				$post_otp = $this->input->post('otp');
				
				$otp = $this->auto_model->getFeild('otp','user','user_id',$user[0]->user_id);
				$otp_expire_on = $this->auto_model->getFeild('otp_expire_on','user','user_id',$user[0]->user_id);
				
				$curr_time = time();
				
				if(strlen($otp) > 0 && $curr_time <= strtotime($otp_expire_on) && ($otp == $post_otp)){
					
					$post_data['transer_through'] =	$this->input->post('transfer_through'); 
					$post_data['admin_pay']= $this->input->post('total_amount');
					$post_data['account_id']= $this->input->post('account_id');
					$post_data['user_id'] =  $user[0]->user_id;
					$post_data['total_amount'] =  $this->input->post('amount_transfer');
					$post_data['status'] =  'N';
					
					if($post_data['total_amount']>$balance){
						
						$json['status'] = 0;
						$json['msg'] = __('myfinance_transfer_amount_should_not_be_greater_than_your_total_balance','Transfer amount should not be greater than your total balance');
						
						
					}else{
						
						$this->load->model('transaction_model');
						
						$user_account_detail = $this->db->where('account_id', $this->input->post('account_id'))->get('user_bank_account')->row_array();
						
						
						$insert = $this->myfinance_model->add_withdrawl($post_data);
						$withdraw_id = $this->db->insert_id();
						
						$new_txn_id = $this->transaction_model->add_transaction(WITHDRAW_WALLET_FUND,  $user[0]->user_id, 'P');
						
						if($insert && $new_txn_id){
							/* transaction new bishu */
							
							$user_wallet_id = get_user_wallet($user[0]->user_id);
							
							$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $this->input->post('amount_transfer'), 'info' => '{Fund_withdraw}', 'ref' => json_encode($user_account_detail)));
							
							
							/* No profit will be charged during withdraw */ 
							/* To enable profit just remove the comment from below line code */ 
							//$profit = ($this->input->post('amount_transfer') - $this->input->post('total_amount'));
							//$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $profit, 'info' => 'Withdraw fund fee'));
				
							
							/* end transaction new bishu */
							
							
							
							$fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
							$lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
							
							$from=ADMIN_EMAIL;
							$to=ADMIN_EMAIL;
							$template='withdrawl_request_notification';
							$data_parse=array('name'=>$fname." ".$lname
							);
							/* $this->auto_model->send_email($from,$to,$template,$data_parse); */
							send_layout_mail($template, $data_parse, $to);
							
							$template='withdrawl_request_user';
							$to = getField('email','user','user_id',$user[0]->user_id);
							send_layout_mail($template, $data_parse, $to);
							
							$this->session->set_flashdata('succ_msg', __('myfinance_your_request_has_been_submitted','Your request has been submitted.'));
							
							$json['status'] = 1;
							$json['msg'] = __('myfinance_your_request_has_been_submitted','Your request has been submitted.');
							
							$this->session->set_flashdata('succ_msg', __('myfinance_your_request_has_been_submitted','Your request has been submitted.'));
							
							
							$this->db->where('user_id', $user_id)->update('user', array('otp' => '', 'otp_expire_on' => '0000-00-00 00:00:00'));
							

						}else{
							
							$json['status'] = 0;
							$json['msg'] = __('myfinance_error_on_update_please_try_again','Error on update please try again');
						}
					}
					
				}else{
					
					$json['status'] = 0;
					$json['msg'] = __('myfinance_invalid_OTP','Invalid OTP');
					
				}
				
				
			}else{
				$json['status'] = 0;
				$json['msg'] = validation_errors();
			}
			
			echo json_encode($json);
		}
	}
   
    public function withdraw(){ 
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              // Get the Question  From model
		$data['question']=$this->myfinance_model->getUpdatedAnswer();
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('myfinance_withdraw_fund','Withdraw fund'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

                $data['paypal_setting']=$this->auto_model->getFeild('withdrawl_method_paypal','setting');

                $data['wire_setting']=$this->auto_model->getFeild('withdrawl_method_wire_transfer','setting');                 $data['skrill_setting']=$this->auto_model->getFeild('method_skrill','setting');
                  
                
		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('withdrawl_commission_paypal' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		$data['skill_fees'] =  $this->auto_model->getFeild('deposite_by_skrill_fees' ,'setting', 'id',1);
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		

		$this->layout->view('withdrawfund',$lay,$data,'normal');      
        
        }
        
    }
    public function exchagerate(){ 
        $amount=  $this->input->post("amt"); 
		$converted = $amount;
        /*$from="INR";
        $to="USD";
		
        $url  = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $data = file_get_contents($url);
		preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
		
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);*/
       echo round($converted, 3);
    }
	public function addFundWire()
	{
	
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id'] = $user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		///////////////////////////Leftpanel Section end//////////////////
		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");
		$lay['client_testimonial']="inc/footerclient_logo";

		
		 if($this->input->post("save_wire")){ 
           
          
           $this->form_validation->set_rules('trans_id', 'Transaction Id', 'required');
		   $this->form_validation->set_rules('amount', 'Amount', 'required');
           $this->form_validation->set_rules('payee_name', 'Payee name', 'required');
           $this->form_validation->set_rules('dep_bank', 'Bank name', 'required');
           $this->form_validation->set_rules('dep_date', 'transaction date', 'required');
           
		   if($this->form_validation->run() == FALSE){ 
		   
            $this->layout->view('add_wire',$lay,$data,'normal');    
           
		   }else{ 
          
			
		  
				$post_data['trans_id']= $this->input->post('trans_id');
				$post_data['amount']= $this->input->post('amount');
                $post_data['user_id'] =  $user[0]->user_id;
                $post_data['payee_name'] = $this->input->post('payee_name');
                $post_data['dep_bank'] = $this->input->post('dep_bank');
                $post_data['dep_date'] = $this->input->post('dep_date');                
                $post_data['dep_branch'] = $this->input->post('dep_branch'); 
				
                $insert = $this->myfinance_model->add_wirefund($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', __('myfinance_your_details_have_been','Your details have been submitted successfully. Your account will be credited after verification by Admin'));
					
					}else{
					
					$this->session->set_flashdata('error_msg', __('myfinance_error_on_submit_please_try_again','Error on submit please try again'));
					
					}
					
					redirect(VPATH."myfinance/addFundWire");
		   
		   }
		   
	
		}else{
		
		$this->layout->view('add_wire',$lay,$data,'normal');      
        
		}
		
		
		
		
        }
		
	}
	public function generateCSV()
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{

			$user=$this->session->userdata('user');
            $this->load->database();
			$this->db->select('id,amount,transction_type,transaction_for,activity,transction_date,status');
			$this->db->where('user_id',$user[0]->user_id);
            $query = $this->db->get('transaction');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Transaction_list_'.date("dMy").'.csv');
			
		}
	}
	
	public function generateCSV_new()
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{

			$user=$this->session->userdata('user');
			$wallet_id = get_user_wallet($user[0]->user_id);
            $this->load->database();
			$this->db->select("tr.txn_id,tr.debit,tr.credit,tr.info,tr.datetime,if(tn.status='Y', 'success', if(tn.status = 'P', 'pending', 'failed')) as status", false)
				->from('transaction_row tr')
				->join('transaction_new tn', 'tn.txn_id=tr.txn_id', 'LEFT');
				
			$this->db->where('tr.wallet_id', $wallet_id);
			
            $query = $this->db->get();
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Transaction_list_'.date("dMy").'.csv');
			
		}
	}
	
	
	public function ClientApproval($pid='',$st='')
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		elseif($pid=='' && $st=='')
		{
			redirect(VPATH."/dashboard/myproject_client/");	
		}
		else
		{
			$user=$this->session->userdata('user');
			$employer_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
			$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$pid);
			$val['client_approval']=$st;
			$where=array("project_id"=>$pid);
			$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
			if($upd)
			{
				if($st=='Y')
				{
					$from=ADMIN_EMAIL;
					$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$pid);
					$template='milestone_approved_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
					
					/* $data_notification=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$employer_id,
						   "notification" =>"You have approved the <a href='".VPATH."myfinance/milestone/".$pid."'>Milestone Chart</a> for project: <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$bidder_id,
						   "notification" =>"<a href='".VPATH."dashboard/MilestoneChart/".$pid."'>Milestone Chart</a> have been approved for the project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
				$notification = "{you_have_approved_the_Milestone_Chart_for_project}: ".$project_title;
				$link = "myfinance/milestone/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "{milestone_Chart_have_been_approved_for_the_project} ".$project_title;
				$link1 = "dashboard/MilestoneChart/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
					
					$this->session->set_flashdata('succ_msg',__('myfinance_congratulation_you_have_approved_the_milestone',"Congratulation!! You have approved the milestone."));	
				}
				if($st=='D')
				{
					$from=ADMIN_EMAIL;
					$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$pid);
					$template='milestone_decline_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
					
					/* $data_notification=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$employer_id,
						   "notification" =>"You have declined the <a href='".VPATH."myfinance/milestone/".$pid."'>milestone</a> for project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N',
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$bidder_id,
						   "notification" =>"<a href='".VPATH."dashboard/MilestoneChart/".$pid."'>Milestone</a> have been declined for the project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N',
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
				$notification = "{you_have_declined_the_milestone_for_project} ".$project_title;
				$link = "myfinance/milestone/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "{milestone_have_been_declined_for_the_project} ".$project_title;
				$link1 = "dashboard/MilestoneChart/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
					
					$this->session->set_flashdata('succ_msg',__('myfinance_congratulation_you_have_declined_the_milestone',"Congratulation!! You have declined the milestone."));	
				}
			}
			else
			{
				$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!!Something got wrong.Please Try Again."));	
			}
			if($request_by=='F')
			{
				redirect(VPATH."myfinance/milestone/".$pid);
			}
			else
			{
				redirect(VPATH."dashboard/MilestoneChart/".$pid);	
			}
		}
		
	}
	
	public function releaseFund($milestone_id='',$st=''){
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else
		{
			$this->load->model('transaction_model');
			$this->load->helper('invoice');
			$flg="";
			$user=$this->session->userdata('user');
			$project_id = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
			
			$milestone_title = $this->auto_model->getFeild("title","project_milestone","id",$milestone_id);
			
			if($st=='A')
			{
				
				$user_wallet_id = get_user_wallet($user[0]->user_id);
				
				$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
				
				$acc_balance=get_wallet_balance($user_wallet_id);
				
				
				$pln_id=$this->auto_model->getFeild('membership_plan','user','user_id',$user[0]->user_id);
				
                $bidwin_charge=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$pln_id);
				
				$bid_id = $this->auto_model->getFeild("bid_id","project_milestone","id",$milestone_id);
				
				$bidder_id = $this->auto_model->getFeild("bidder_id","bids","id",$bid_id);
				$pid = $this->auto_model->getFeild("project_id","bids","id",$bid_id);
				$employer_id = $this->auto_model->getFeild("user_id","projects","project_id",$pid);
				
				$milestone_amount = $this->auto_model->getFeild("amount","project_milestone","id",$milestone_id);
				 
				$commission = (($milestone_amount * SITE_COMMISSION) / 100) ; 
				
				$bidder_to_pay = $milestone_amount - $commission;
				
				$post_data['bider_to_pay']=$bidder_to_pay;
				
                //$post_data['employer_id'] =$this->auto_model->getFeild("employer_id","project_milestone","id",$milestone_id);
                $post_data['employer_id'] =$employer_id;
                $post_data['project_id'] = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
				$post_data['milestone_id'] = $milestone_id;
				
               // $post_data['worker_id'] = $this->auto_model->getFeild("bidder_id","project_milestone","id",$milestone_id);
                $post_data['worker_id'] = $bidder_id;
                //$post_data['payamount'] = $post_data['bider_to_pay']*(1+($bidwin_charge/100));
                $post_data['payamount'] = $milestone_amount;
                $post_data['commission'] = $commission;
			  
                $post_data['reason_txt'] = $this->auto_model->getFeild("description","project_milestone","id",$milestone_id); 
				
				$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$milestone_id);
				$invoice_number = $this->auto_model->getFeild("invoice_number","invoice_main","invoice_id",$invoice_id);
				
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
					$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); // commission invoice mark as paid
					
					if($upd){
						
						$flg="S";	
						
					}else{
						
						$flg="D";	
					}
					
				}else{
					
					if($acc_balance >= $post_data['payamount']){
						$insert = $this->myfinance_model->insertMilestone($post_data);
						
						if($insert){ 
							
						
							//if($this->myfinance_model->insertTransaction($data_transaction)){
							
								//$this->myfinance_model->updateUser($balance,$user[0]->user_id);  
							
								$milestone_pay_amount = $milestone_amount;
								// pay freelancer through employer wallet 
								
								$bidder_wallet_id = get_user_wallet($bidder_id);
					
								// transaction insert
								$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_DIRECT,  $user[0]->user_id);
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $milestone_pay_amount, 'ref' => $milestone_id, 'info' => '{Project_payment_to_freelancer}'));
								
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $bidder_wallet_id, 'credit' => $milestone_pay_amount, 'ref' => $milestone_id, 'info' => '{Project_payment_received}#'.$pid));
								
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
					
								
								/*	$from=ADMIN_EMAIL;
								$to_id=$post_data['worker_id'];
								$title=$this->auto_model->getFeild('title','projects','project_id',$post_data['project_id']);
								$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
								$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
								$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
								$template='milestone_set_notification';
								$data_parse=array('name'=>$fname." ".$lname,
													'title'=>$title
													);
								$this->auto_model->send_email($from,$to_mail,$template,$data_parse);*/
							  
							//}              
						} 
						
						$val['fund_release']=$st;
						$val['commission_invoice_id']=$inv_id;
						$where=array("id"=>$milestone_id);
						$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
						
						//$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$milestone_id);
					
						$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
					
						$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); // commission invoice mark as paid
					
						//$this->db->where(array('milestone_id' => $milestone_id))->update('invoice', array('payment_status' => 'PAID', 'commission_amount' => $commission));
						
						if($upd){
							$flg="S";	
						}else{
							$flg="D";	
						}
						
					}else{
						$flg="I";	
					}
				
				}
				
				
			}elseif($st=='P'){
				$val['fund_release']=$st;
				$where=array("id"=>$milestone_id);
				$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
				if($upd)
				{
					$flg="P";	
				}
				else
				{
					$flg="D";	
				}
			}
			
			/////Set Success//////////
			if($flg)
			{
				if($flg=='S')
				{
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
					/* $this->auto_model->send_email($from,$to_mail,$template,$data_parse); */
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
					
					
					$post_data['employer_id'] =$employer_id;
						/*	$data_notification=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$post_data['employer_id'],
						   "notification" =>"Fund added in Escrow Successfully for milestone: <a href='".VPATH."myfinance/milestone/".$project_id."'>".$milestone_title."</a> for the project: <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$bidder_id,
						   "notification" =>"Fund added in Escrow for milestone: <a href='".VPATH."dashboard/MilestoneChart/".$project_id."'>".$milestone_title."</a> for the project <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
					/*$notification = "Fund added in Escrow Successfully for milestone: ".$milestone_title." for the project: ".$project_title;
					$link = "myfinance/milestone/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
					
					$notification1 = "Fund added in Escrow for milestone: ".$milestone_title." for the project ".$project_title;
					$link1 = "dashboard/MilestoneChart/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $bidder_id, $notification1, $link1);*/
						
						$this->session->set_flashdata('succ_msg',__('myfinance_congratulation_fund_added_in_escrow_successfully',"Congratulation!! Fund added in Escrow Successfully."));
						
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
					/* $data_notification=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$post_data['employer_id'],
						   "notification" =>"You have declined the Fund request for milestone: <a href='".VPATH."myfinance/milestone/".$project_id."'>".$milestone_title."</a> for project <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$bidder_id,
						   "notification" =>"Your Fund request declined for milestone: <a href='".VPATH."dashboard/MilestoneChart/".$project_id."'>".$milestone_title."</a> for the project <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
						 
					$notification = "{you_have_declined_the_Fund_request_for_milestone}: ".$milestone_title." {for_the_project} ".$project_title;
					$link = "projectdashboard_new/employer/milestone/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
					
					$notification1 = "{your_Fund_request_declined_for_milestone}: ".$milestone_title." {for_the_project} ".$project_title;
					$link1 = "projectdashboard_new/freelancer/milestone/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $bidder_id, $notification1, $link1);
				
					
					$this->session->set_flashdata('succ_msg',__('myfinance_congratulation_you_have_declined_the_request',"Congratulation!! You have declined the request."));	
				}elseif($flg=='I'){
					
					$this->session->set_flashdata('error_msg',__('myfinance_oops_you_have_insufficient_fund_in_your_wallet_please_add_fund_in_your_wallet',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet."));	
					
				}elseif($flg=='D'){
					$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!! Something got wrong. Please try again later."));	
				}
			}
			else
			{
				$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!! Something got wrong. Please try again later."));		
			}
			$next = get('next');
			//redirect(VPATH."myfinance/milestone/".$project_id);
			if(!empty($next)){
				redirect(VPATH."myfinance/releasepayment/".$milestone_id.'?next='.$next);
			}
			redirect(VPATH."myfinance/releasepayment/".$milestone_id);
		}
	}
	
	public function cancelpayment($id='')
    {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		elseif($id=='')
		{
			redirect(VPATH."/dashboard/myproject_client/");	
		}
		else
		{
			$user=$this->session->userdata('user');
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
			if($upd)
			{
				
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
					
					/* $data_notification=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$employer_id,
						   "notification" =>"You have declined the payment for milestone: <a href='".VPATH."myfinance/milestone/".$pid."'>".$milestone_title."</a> for project: <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" => "N"
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$bidder_id,
						   "notification" =>"Payment have been canceled for milestone: <a href='".VPATH."dashboard/MilestoneChart/".$pid."'>".$milestone_title."</a> for the project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>"N"
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
				$notification = "{you_have_declined_the_payment_for_milestone}: ".$milestone_title." {for_the_project}: ".$project_title;
				$link = "projectdashboard_new/employer/milestone/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "{payment_have_been_canceled_for_milestone}: ".$milestone_title." {for_the_project} ".$project_title;
				$link1 = "projectdashboard_new/freelancer/milestone/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
				
				
					$this->session->set_flashdata('succ_msg',__('myfinance_congratulation_you_have_canceled_the_payment',"Congratulation!! You have Canceled the payment."));	
				
			}
			else
			{
				$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!!Something got wrong.Please Try Again."));	
			}
			
			$ref = $this->input->server('HTTP_REFERER');
			if($ref){
				redirect($ref);
			}else{
				redirect(VPATH."myfinance/milestone/".$pid);
			}
			
			
		}	
	}
	
	public function releasefund_hourly($tracker_id="")
	{
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else
		{
			$flg="";
			$user=$this->session->userdata('user');
			$project_id = $this->auto_model->getFeild("project_id","project_tracker","id",$tracker_id);
			$worker_id = $this->auto_model->getFeild("worker_id","project_tracker","id",$tracker_id);
			$start_time = $this->auto_model->getFeild("start_time","project_tracker","id",$tracker_id);
			$stop_time = $this->auto_model->getFeild("stop_time","project_tracker","id",$tracker_id);
			$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
			$freelancer_amt=$this->auto_model->getFeild("bidder_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
				
			$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
			
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$acc_balance=get_wallet_balance($user_wallet_id);
			
			$seconds_new = strtotime($stop_time) - strtotime($start_time);
			if($seconds_new<1){
				$seconds_new=0;
				}
			$days_new    = floor($seconds_new / 86400);
			$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
			$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
			$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
			$total_cost_client=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
			$total_cost_bidder=$freelancer_amt*(($days_new*24)+$hours_new+$minutes_new/60);
	
			
			$post_data['bider_to_pay']=$total_cost_bidder;
			$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
			$post_data['project_id'] = $project_id;
			$post_data['milestone_id'] = '0';
			if($post_data['employer_id']!=$user[0]->user_id){
				redirect(VPATH);
				exit();
			}
			
			$post_data['worker_id'] = $worker_id;
			$post_data['payamount'] = $total_cost_client;
							
			$post_data['reason_txt'] = "Hourly job paid"; 
			
			$post_data['tracker_id'] = $tracker_id; 
			if($acc_balance >= $post_data['payamount'])
			{
				$insert = $this->myfinance_model->insertMilestone($post_data);
				 
				if($insert){ 
					
					$data_transaction=array(
						"user_id" =>$user[0]->user_id,
						"amount" =>$post_data['payamount'],
						"profit" => ($post_data['payamount']-$post_data['bider_to_pay']),
						"transction_type" =>"DR",
						"transaction_for" => "Add Fund To Escrow",
						"transction_date" => date("Y-m-d H:i:s"),
						"status" => "Y"
					);

					$balance=($acc_balance-$post_data['payamount']);
					
					

					if($this->myfinance_model->insertTransaction($data_transaction)){
					
					$this->myfinance_model->updateUser($balance,$user[0]->user_id);  
					
					
				/*	$from=ADMIN_EMAIL;
					$to_id=$post_data['worker_id'];
					$title=$this->auto_model->getFeild('title','projects','project_id',$post_data['project_id']);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
					$template='milestone_set_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);*/
					  
					}              
				} 
				
				$val['escrow_status']='Y';
				$where=array("id"=>$tracker_id);
				$upd=$this->myfinance_model->updateProjectTracker($val,$where);
				if($upd)
				{
					$flg="S";	
				}
				else
				{
					$flg="D";	
				}
			}
			else
			{
				$flg="I";	
			}
			
			
			
			/////Set Success//////////
			if($flg)
			{
				if($flg=='S')
				{
					$from=ADMIN_EMAIL;
					$bidder_id= $worker_id;
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$worker_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$worker_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$worker_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
					$template='fund_approved';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title,
										'amount'=>$post_data['bider_to_pay']
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
					
					$from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='add_fund_escrow';
					$data_parse=array('title'=>$project_title
					);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
					$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
					/* $data_notification=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$post_data['employer_id'],
						   "notification" =>"Fund added in Escrow Successfully for hourly job for the project: <a href='".VPATH."projecthourly/employer/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$worker_id,
						   "notification" =>"Fund added in Escrow for hourly job for the project <a href='".VPATH."projecthourly/freelancer/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status"=>'N'
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
				$notification = "{fund_added_in_Escrow_Successfully_for_hourly_job_for_the_project}: ".$project_title;
				$link = "projectdashboard_new/hourly_employer/".$project_id;
				$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
				
				$notification1 = "{fund_added_in_Escrow_for_hourly_job_for_the_project} ".$project_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$project_id;
				$this->notification_model->log($post_data['employer_id'], $worker_id, $notification1, $link1);
					
					$this->session->set_flashdata('succ_msg',__('myfinance_congratulation_fund_added_in_escrow_successfully',"Congratulation!! Fund added in Escrow Successfully."));	
				}
				elseif($flg=='I')
				{
					$this->session->set_flashdata('error_msg',__('myfinance_oops_you_have_insufficient_fund_in_your_wallet_please_add_fund_in_your_wallet',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet."));	
				}	
				elseif($flg=='D')
				{
					$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!! Something got wrong. Please try again later."));	
				}
			}
			else
			{
				$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!! Something got wrong. Please try again later."));		
			}
			redirect(VPATH."projecthourly/employer/".$project_id);
		}
		
	}
	
	public function releasepayment_hourly($tracker_id='')
	{
		
		 
     	$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
	    $mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id); 
        $pid=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
        $wid=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		$ptype=$this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $bider_to_pay=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $worker_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$wid);
		
		$user_wallet_id = get_user_wallet($wid);
		$worker_balance=get_wallet_balance($user_wallet_id);
        
        $pay_amt=($worker_balance+$bider_to_pay);
        
            $data_transaction=array(
                "user_id" =>$wid,
                "amount" =>$bider_to_pay,
                "transction_type" =>"CR",
                "transaction_for" => "Milestone Payment",
                "transction_date" => date("Y-m-d H:i:s"),
                "status" => "Y"
            );         
          if($this->myfinance_model->insertTransaction($data_transaction)){ 
             
              $this->myfinance_model->updateUser($pay_amt,$wid); 
           
            $data_milistone=array(
                "release_type" =>"P",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);
			
			if($ptype=='F')
			{
			
				$total_bid_amount=$this->auto_model->getFeild("bidder_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
				$paid_amount=$this->myfinance_model->getPaidAmount($pid,$wid);
				if($total_bid_amount==$paid_amount)
				{
					$proj_data['status']='C';
					$this->myfinance_model->updateProject($proj_data,$pid);	
				}
			}
			
			$val['payment_status']='P';
			$where=array("id"=>$tracker_id);
			$upd=$this->myfinance_model->updateProjectTracker($val,$where);
			
			$from=ADMIN_EMAIL;
			$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
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
			$employer_id=$data['user_id'];
			$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);
			
			/* $data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully release hourly job payment for <a href='".VPATH."projecthourly/employer/".$pid."'>".$projects_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$bidder_id,
				   "notification" =>"Payment received for hourly job payment for the project <a href='".VPATH."projecthourly/freelancer/".$pid."'>".$projects_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $this->myfinance_model->insert_notification($data_notification);
				 
				 $this->myfinance_model->insert_notification($data_notic); */
				 
				$notification = "{you_have_successfully_release_hourly_job_payment_for} ".$projects_title;
				$link = "projectdashboard_new/hourly_employer/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "{payment_received_for_hourly_job_payment_for_the_project} ".$projects_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
			
			$this->session->set_flashdata('succ_msg',__('myfinance_you_have_successfully_release_this_payment',"You have successfully release this payment"));
            
        }
        else{ 
            $this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!!Something Got Wrong. Please Try Again Later."));
        }
		
		redirect(VPATH."projecthourly/employer/".$pid);
        
        
	}
	
	public function dispute_hourly($tracker_id="")
	{
		 
		
		$mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id); 
		      
        
		$project_id=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
		
		$project_title=$this->auto_model->getFeild("title","projects","project_id",$project_id);
        
        $disput_amt=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $employer_id=$this->auto_model->getFeild("employer_id","milestone_payment","id",$mid);
        
        $worker_id=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
        
        $data_dispute=array(
            "milestone_id" => $mid, 
            "employer_id" =>$employer_id,
            "worker_id" =>$worker_id,
            "disput_amt" =>$disput_amt,
            "add_date"=> date("Y-m-d"),
            "status"=>"N"
        );
        
        $did=$this->myfinance_model->insertDispute($data_dispute);
               
        if($did){          
            
            $data_milistone=array(
                "release_type" =>"D",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);    
            
            
            $data_dispute_discuss=array(            
                "disput_id" => $did,
                "employer_id" => $employer_id,
                "worker_id" => $worker_id,
                "employer_amt" => $disput_amt,
                "worker_amt" => "0.00",
                "accept_opt" => "W",
                "status" => "N",
            );      
            $this->myfinance_model->insertDisputDiscuss($data_dispute_discuss);
			
			$val['payment_status']='D';
			$where=array("id"=>$tracker_id);
			$upd=$this->myfinance_model->updateProjectTracker($val,$where);
			
			/*$post_data['from_id']=$employer_id;
			$post_data['to_id']=$worker_id;
			$post_data['notification']='One of your project has been disputed. Please check you disputes list.';
			$post_data['add_date']=date('Y-m-d');
			$this->dashboard_model->insert_Notification($post_data);*/
			
            $from=ADMIN_EMAIL;
			$to=ADMIN_EMAIL;
			$template='dispute_notification';
			$data_parse=array('title'=>$project_title
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);
			
			$from=ADMIN_EMAIL;
			$to_id= $worker_id;
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
			$template='milestone_dispute_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
		/*	$data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully dispute the hourly job payment for <a href='".VPATH."projecthouly/employer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$worker_id,
				   "notification" =>"Hourly Job payment have been disputed for the project <a href='".VPATH."projecthourly/freelancer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $this->myfinance_model->insert_notification($data_notification);
				 
				 $this->myfinance_model->insert_notification($data_notic); */
				 
				 $notification = "{you_have_successfully_dispute_the_hourly_job_payment_for} ".$project_title;
				$link = "projectdashboard_new/hourly_employer/".$project_id;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "{hourly_job_payment_have_been_disputed_for_the_project} ".$project_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$project_id;
				$this->notification_model->log($employer_id, $worker_id, $notification1, $link1);
			
			$this->session->set_flashdata('succ_msg',__('myfinance_you_have_successfully_dispute_this_milestone',"You have successfully dispute this milestone"));        
            
        }
        else{ 
            $this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!!Something Got Wrong. Please Try Again Later."));
        }
		
		redirect(VPATH."projecthourly/employer/".$project_id);
	}
	
	
	///////////////////////For Manual hourly Payment///////////////////
	
	public function releasefund_hourly_manual($tracker_id="")
	{		

		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else
		{
			$flg="";
			$user=$this->session->userdata('user');
			$project_id = $this->auto_model->getFeild("project_id","project_tracker_manual","id",$tracker_id);
			$worker_id = $this->auto_model->getFeild("worker_id","project_tracker_manual","id",$tracker_id);
			$hour = $this->auto_model->getFeild("hour","project_tracker_manual","id",$tracker_id);			
			$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
			$freelancer_amt=$this->auto_model->getFeild("bidder_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
			$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
			
			$this->load->model('transaction_model');
			
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$acc_balance=get_wallet_balance($user_wallet_id);
			
			$total_cost_client=$client_amt*floatval($hour);
			$total_cost_bidder=$freelancer_amt*floatval($hour);
			
			$post_data['bider_to_pay']=$total_cost_bidder;
			$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
			$post_data['project_id'] = $project_id;
			$post_data['milestone_id'] = '0';
			$post_data['worker_id'] = $worker_id;
			$post_data['payamount'] = $total_cost_client;
			$post_data['reason_txt'] = "Hourly job paid";
			$post_data['tracker_id'] = $tracker_id; 
			if($acc_balance >= $post_data['payamount'])
			{
				$insert = $this->myfinance_model->insertMilestone($post_data);
				$milestone_ins_id = $this->db->insert_id();
				if($insert){
					
					
				
					/* $data_transaction=array(
						"user_id" =>$user[0]->user_id,
						"amount" =>$post_data['payamount'],
						"profit" => ($post_data['payamount']-$post_data['bider_to_pay']),
						"transction_type" =>"DR",
						"transaction_for" => "Add Fund To Escrow",
						"transction_date" => date("Y-m-d H:i:s"),
						"status" => "Y"
					);
					$balance=($acc_balance-$post_data['payamount']);
					 */
					// fund added to escrow	

					$ins['data'] = array(
						'milestone_id' => $milestone_ins_id,
						'amount' => $post_data['payamount'],
						'project_id' => $project_id,
						'status' => 'P',
					);
					
					$ins['table'] = 'escrow_new';
					
					insert($ins);
					
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(PROJECT_PAYMENT_ESCROW,  $user[0]->user_id);
					
					$ref1 = json_encode(array('manual_traker_id' => $tracker_id, 'project_type' => 'H', 'project_id' => $project_id, 'milestone_payment_id' => $milestone_ins_id));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $post_data['payamount'], 'ref' => $ref1, 'info' => '{Hourly_project_fund_added_to_escrow}'));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'credit' => $post_data['payamount'], 'ref' => $ref1, 'info' => '{Hourly_project_fund_added_to_escrow}'));
					
					wallet_less_fund($user_wallet_id, $post_data['payamount']);
					
					wallet_add_fund(ESCROW_WALLET,$post_data['payamount']);
					
					check_wallet($user_wallet_id,  $new_txn_id);
					
					check_wallet(ESCROW_WALLET,  $new_txn_id);
					
					
					/* if($this->myfinance_model->insertTransaction($data_transaction)){	
					$this->myfinance_model->updateUser($balance,$user[0]->user_id); 				  

					}   */  


				} 		

				$val['escrow_status']='Y';
				$where=array("id"=>$tracker_id);
				$upd=$this->myfinance_model->updateProjectTracker_manual($val,$where);
				
				if($upd){
					
					$flg="S";
					
				}else{
					
					$flg="D";
					
				}
				
			}else{
				$flg="I";	
			}

			/////Set Success//////////

			if($flg){
				
				if($flg=='S'){

					$from=ADMIN_EMAIL;
					$bidder_id= $worker_id;
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
					$template='fund_approved';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title,
										'amount'=>$post_data['bider_to_pay']
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);			

					$from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='add_fund_escrow';
					$data_parse=array('title'=>$project_title
					);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
					$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
				
					$notification = "{fund_added_in_Escrow_Successfully_for_hourly_job_for_the_project}: ".$project_title;
					$link = "projectdashboard/hourly_employer/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
					
					$notification1 = "{fund_added_in_Escrow_for_hourly_job_for_the_project} ".$project_title;
					$link1 = "projectdashboard/hourly_freelancer/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $bidder_id, $notification1, $link1);						 

					$this->session->set_flashdata('succ_msg',__('myfinance_congratulation_fund_added_in_escrow_successfully',"Congratulation!! Fund added in Escrow Successfully."));	

				}elseif($flg=='I'){
					
					$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet."));	
					
				}elseif($flg=='D'){
					
					$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet."));	
					
				}
			}else{
				$this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet."));
			}
			
			//redirect(VPATH."projectdashboard/employer/".$project_id);
			redirect(VPATH.get('next'));
		}		

	}

	

	public function releasepayment_hourly_manual($tracker_id=''){
		
		$this->load->model('transaction_model');
		
     	$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
	    $mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id); 
        $pid=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
        $wid=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		$ptype=$this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $bider_to_pay=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid); 
        $worker_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$wid); 
			
		$user_wallet_id = get_user_wallet($wid);
		$worker_balance=get_wallet_balance($user_wallet_id);
		
		// transaction insert
		
		$escrow_row_check = $this->db->where(array('project_id' => $pid, 'milestone_id' => $mid, 'status' => 'P'))->get('escrow_new')->row_array();
		
		if(!empty($escrow_row_check)){
			
			$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user[0]->user_id);
		
			$ref1 = json_encode(array('manual_tracker_id' => $tracker_id, 'project_type' => 'H', 'milestone_payment_id' => $mid, 'project_id' => $pid));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $bider_to_pay, 'ref' => $ref1, 'info' => '{Freelancer_payment_through_escrow_wallet}'));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' =>  $bider_to_pay, 'ref' => $ref1, 'info' => '{Hourly_project_payment_through_escrow}'));
			
			wallet_less_fund(ESCROW_WALLET,$bider_to_pay);

			wallet_add_fund($user_wallet_id, $bider_to_pay);

			check_wallet($user_wallet_id,  $new_txn_id);
			
			check_wallet(ESCROW_WALLET,  $new_txn_id);
			
			$this->db->where('escrow_id', $escrow_row_check['escrow_id'])->update('escrow_new', array('status' => 'R'));
		}
		
		

		
        /* $pay_amt=($worker_balance+$bider_to_pay);   
		$activity = $this->auto_model->getFeild("activity","project_tracker_manual","id",$tracker_id); 
		if($activity){
			$act_arr = array();
			$act = $this->db->where("id IN ($activity)")->get('project_activity')->result_array();
			if(count($act) > 0){
				foreach($act as $k => $v){
					$act_arr[] = $v['task'];
				}
			}
			$act_str = implode(',', $act_arr);
		}else{
			$act_str = '';
		}
            $data_transaction=array(
                "user_id" =>$wid,
                "amount" =>$bider_to_pay,
                "transction_type" =>"CR",
                "transaction_for" => "Milestone Payment",
                "transction_date" => date("Y-m-d H:i:s"),
				"activity" => $act_str,
                "status" => "Y"
            );    */
			
		$data_milistone=array(
			"release_type" =>"P",
			"status" => "Y"
		);
        $this->myfinance_model->updateMilestone($data_milistone,$mid);
		
		$val['payment_status']='P';
		$where=array("id"=>$tracker_id);
		$upd=$this->myfinance_model->updateProjectTracker_manual($val,$where);	
		
		$from=ADMIN_EMAIL;
		$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
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
		$employer_id=$data['user_id'];
		$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);		

		


		$notification = "{you_have_successfully_release_hourly_job_payment_for} ".$projects_title;
		$link = "projectdashboard/hourly_employer/".$pid;
		$this->notification_model->log($employer_id, $employer_id, $notification, $link);
		
		$notification1 = "{payment_received_for_hourly_job_payment_for_the_project} ".$projects_title;
		$link1 = "projectdashboard/hourly_freelancer/".$pid;
		$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
	
		$this->session->set_flashdata('succ_msg',__('myfinance_you_have_successfully_release_this_payment',"You have successfully release this payment"));
			
		/*if($this->myfinance_model->insertTransaction($data_transaction)){   
              $this->myfinance_model->updateUser($pay_amt,$wid); 
            

			 if($ptype=='F')
			{		

				$total_bid_amount=$this->auto_model->getFeild("bidder_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
				$paid_amount=$this->myfinance_model->getPaidAmount($pid,$wid);
				if($total_bid_amount==$paid_amount)
				{
					$proj_data['status']='C';
					$this->myfinance_model->updateProject($proj_data,$pid);	
				}
			}		

			
			  
        }else{ 
            $this->session->set_flashdata('error_msg',"Oops!!Something Got Wrong. Please Try Again Later.");
        } */		
		
		/* if(get('next')){
			
			$next = get('next');
		} */
		//redirect(VPATH."projecthourly/employer/".$pid);            
		//redirect(VPATH."projectdashboard/employer/".$pid);   
		
		redirect(VPATH.get('next'));      
		

	}

	

	public function dispute_hourly_manual($tracker_id="")
	{	

		$mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id);  
		$project_id=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
		$project_title=$this->auto_model->getFeild("title","projects","project_id",$project_id);
        $disput_amt=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        $employer_id=$this->auto_model->getFeild("employer_id","milestone_payment","id",$mid);
        $worker_id=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		
		$this->db->where(array('milestone_id' => $mid, 'project_id' => $project_id))->update('escrow_new', array('status' => 'D'));
		
        $data_dispute=array(
            "milestone_id" => $mid, 
            "employer_id" =>$employer_id,
            "worker_id" =>$worker_id,
            "disput_amt" =>$disput_amt,
            "add_date"=> date("Y-m-d"),
            "status"=>"N"
        );      

        $did=$this->myfinance_model->insertDispute($data_dispute);
        if($did){
            $data_milistone=array(
                "release_type" =>"D",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);  
			
            $data_dispute_discuss=array( 
                "disput_id" => $did,
                "employer_id" => $employer_id,
                "worker_id" => $worker_id,
                "employer_amt" => $disput_amt,
                "worker_amt" => "0.00",
                "accept_opt" => "W",
                "status" => "N",
            );      
            $this->myfinance_model->insertDisputDiscuss($data_dispute_discuss);	

			$val['payment_status']='D';
			$where=array("id"=>$tracker_id);
			$upd=$this->myfinance_model->updateProjectTracker_manual($val,$where);

            $from=ADMIN_EMAIL;
			$to=ADMIN_EMAIL;
			$template='dispute_notification';
			$data_parse=array('title'=>$project_title
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);		

			$from=ADMIN_EMAIL;
			$to_id= $worker_id;
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
			$template='milestone_dispute_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
			/* $data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully dispute the hourly job payment for <a href='".VPATH."projecthouly/employer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );		 

				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$worker_id,
				   "notification" =>"Hourly Job payment have been disputed for the project <a href='".VPATH."projecthourly/freelancer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );	 

				 $this->myfinance_model->insert_notification($data_notification);	
				 $this->myfinance_model->insert_notification($data_notic);	*/		
				
				$notification = "{you_have_successfully_dispute_the_hourly_job_payment_for} ".$project_title;
				$link = "projectdashboard_new/hourly_employer/".$project_id;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "{hourly_job_payment_have_been_disputed_for_the_project} ".$project_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$project_id;
				$this->notification_model->log($employer_id, $worker_id, $notification1, $link1);
				
				
				
			$this->session->set_flashdata('succ_msg',__('myfinance_you_have_successfully_dispute_this_milestone',"You have successfully dispute this milestone"));  
        }
        else{ 
            $this->session->set_flashdata('error_msg',__('myfinance_oops_something_got_wrong_please_try_again_later',"Oops!!Something Got Wrong. Please Try Again Later."));
        }
		/* if(get('next')){
			$next = get('next');
		} */
		//redirect(VPATH."projecthourly/employer/".$project_id);
		redirect(VPATH.get('next'));
	}
	
	///////////////////////For Manual hourly Payment///////////////////

    
	public function migrate_wallet_balance(){
		/*$this->load->model('transaction_model');
		
		$users = $this->db->get('user')->result_array();
		foreach($users as $user){
			$user_wallet_id = get_user_wallet($user['user_id']);
			$prev_balance = $user['acc_balance'];
			
			// transaction insert
			$new_txn_id = $this->transaction_model->add_transaction(ADD_FUND_MANUAL,  $user['user_id']);
		
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $prev_balance, 'ref' => '', 'info' => 'Fund added by admin'));
				
			wallet_add_fund($user_wallet_id, $prev_balance);
			
			check_wallet($user_wallet_id,  $new_txn_id);
		
		}*/
	}
	
	/* ----------------------- Milestone dispute function  ------------------------------*/
	
	public function disputeMilestone($milestone_id='', $project_id=''){
		
		if(!$milestone_id != ''){
			return false;
		}
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}else{
			
			$user = $this->session->userdata('user');
			$user_id = $user[0]->user_id;
			//$project_id = getField('project_id', 'project_milestone', 'id', $milestone_id);
			$owner_id = getField('user_id', 'projects', 'project_id', $project_id);
			$bid_id = getField('bid_id', 'project_milestone', 'id', $milestone_id);
			$worker_id = getField('bidder_id', 'bids', 'id', $bid_id);
			$project_title  = getField('title', 'projects', 'project_id', $project_id);
			
			if($owner_id == $user_id){
				
				// update status as D in escrow_new table
				
				$this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id, 'status' => 'P'))->update('escrow_new', array('status' => 'D'));
				
				// update release_payment status as D in project_milestone table
				
				$this->db->where(array('id' => $milestone_id, 'release_payment' => 'R', 'project_id' => $project_id))->update('project_milestone', array('release_payment' => 'D'));
				
				$notification = "{you_have_successfully_dispute_the_payment_for} ".$project_title;
				$link = "projectroom/employer/milestone/".$project_id;
				$this->notification_model->log($owner_id, $owner_id, $notification, $link);
				
				
				$notification1 = "{payment_have_been_disputed_for_the_project} ".$project_title;
				$link1 = "projectroom/freelancer/milestone/".$project_id;
				$this->notification_model->log($owner_id, $worker_id, $notification1, $link1);
				
			}
			
			$ref = $this->input->server('HTTP_REFERER');
			if($ref){
				redirect($ref);
			}else{
				redirect(VPATH."projectdashboard/milestone_employer/".$project_id);
			}
		}
	}
	
	
	public function project_all_transaction($project_id='', $limit_from=0){
		
		if(empty($project_id)){
			return false;
		}
		$this->load->library('pagination');
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 40;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['project_id'] = $srch['project_id'] = $project_id; 
		$data['project_title'] = getField('title', 'projects', 'project_id', $project_id);
		
		$data['all_data'] = $this->myfinance_model->getProjectAllTxn($srch,  $start, $per_page);
		$data['all_data_count'] = $this->myfinance_model->getProjectAllTxn($srch, '', '', FALSE);
		
		
		$config["base_url"] = base_url()."myfinance/project_all_transaction/".$project_id;
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;
		
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt; Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';                 
		
		$this->pagination->initialize($config); 
		
		$data['links']=$this->pagination->create_links(); 
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('project_all_txn', $lay, $data, 'normal'); 
	}
	
	public function checkmail($user_id=''){
		
		$user_name=$this->auto_model->getFeild('username','user','user_id',$user_id);

		$to=$this->auto_model->getFeild('email','user','user_id',$user_id);

		$from=ADMIN_EMAIL;

		$template='add_fund_client';
		echo $amount = intval(200);
		echo '<br>'.$amt = floatval($amount * intval(5))/100;
		echo '<br>'.$rst_amt = floatval($amount - $amt);

		$data_parse=array('name'=>$user_name,
			'amount'=>$amount,
			'rstamount'=>$rst_amt
		);

		if(send_layout_mail($template, $data_parse, $to, $from))
		{
			echo 'done';
		}
		else{
			echo 'not done';
		}
		
	}
	
}
