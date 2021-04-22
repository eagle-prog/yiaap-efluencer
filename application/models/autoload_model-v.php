<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class autoload_model extends BaseModel {

	

    public function __construct() {
	
        return parent::__construct();
		
    }
    
    public function getsitemetasetting($tablename='',$by='',$value='')
    {
	
	if($tablename!=''){
	$dat=array($by=>$value);
	
		$query = $this->db->select('meta_title,meta_keys,meta_desc');
		$query = $this->db->get_where( $tablename,$dat );
		foreach( $query->result() as $filed=>$val ){
			define('SITE_TITLE', $val->meta_title); 
			define('SITE_KEY', $val->meta_keys); 
			define('SITE_DESC', $val->meta_desc); 

		}
	if(count($query->result())==0){
	
		$query = $this->db->select('site_title,meta_keys,meta_desc');
		$query = $this->db->get( 'setting' );
		foreach( $query->result() as $filed=>$val ){
			define('SITE_TITLE', $val->site_title); 
			define('SITE_KEY', $val->meta_keys); 
			define('SITE_DESC', $val->meta_desc); 
	
		}
	}
	}else{
	
	
		$query = $this->db->select('site_title,meta_keys,meta_desc');
		$query = $this->db->get( 'setting' );
		foreach( $query->result() as $filed=>$val ){
			define('SITE_TITLE', $val->site_title); 
			define('SITE_KEY', $val->meta_keys); 
			define('SITE_DESC', $val->meta_desc); 

		}
	}
    }
	
	public function getFeild($select,$table,$feild,$value){
		$this->db->select($select);	
		$rs = $this->db->get_where($table,array($feild=>$value));
		 $data = '';
		 foreach ($rs->result() as $row){
		  $data = $row->$select;
		 }
		 return $data;
		
	}
	public function getalldata($attr,$table,$by,$value){
	$this->db->select($attr);	
	$rs = $this->db->get_where($table,array($by=>$value));
	 $data = '';
	 
	 foreach ($rs->result() as $key=>$row){
	  $data["'".$key."'"] = $row;
	 }
	
	 return $data;
	
	}
	public function load_css_js($load_extra){
	$js='';
	$css='';
	$loadfile='';
	
	if(count($load_extra)>0){
	
		foreach($load_extra as $key=>$val){
		
			if($key=="css_to_load"){
				foreach($val as $sr){
				
				 $loadfile.='<link href="'.CSS.$sr.'" rel="stylesheet" type="text/css" />';
					
				}
			}
			if($key=="js_to_load"){
				foreach($val as $j){
					$loadfile.='<script type="text/javascript" src="'.JS.$j.'"></script>';
				}
			}
		}
	}
	
	 return $loadfile;
	
	}
	public function getprojectcountbyid($id){
	
	 //$rs = $this->db->where_in($id, 'skills');
		$this->db->where("FIND_IN_SET('".$id."',`skills`)!=", 0);
		 $rs = $this->db->count_all_results('projects');
	//echo $this->db->last_query();
	
	 
	 return $rs;
	
	}
	public function breadcrumb($breadcrumb,$title){
		
		
		$b=' <div class="breadcrumb-wrapper">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <h2 class="title">'.$title.'</h2>
                     </div>
					 
                     <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                        <div class="breadcrumbs pull-right">
                           <ul>
								<li>You are here:</li>
								<li><a href="'.VPATH.'dashboard">Home</a></li>';
		
								foreach($breadcrumb as $name){
								if($name['path']){
								$b.="<li >";
								$b.=anchor(base_url().$name['path'],$name['title'],'');
								$b.="</li>";
								 }else{
								$b.='<li class="active">';
								$b.=$name['title'];
								}
								$b.="</li>";
								}
						$b.='</ul>
                        </div>
                     </div>					
                  </div>
				  
				  

               </div>
			   
            </div>';
		return $b;
	}
	public function project_leftpanel($project_id="")
	{
		$bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
		$bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_id,'bidder_id'=>$bidder_id));
		$paid_amount=$this->getPaidAmount($project_id,$bidder_id);
		
		$b='<div class="sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12 " style="border:#ddd 1px solid; overflow:hidden;">
			<div class="widget category">
			<ul class="category-list slide" style="padding-top:20px;">                            
			<li><a href="'.VPATH.'projectdashboard/index/'.$project_id.'">Inbox</a></li>
			<li><a href="'.VPATH.'projectdashboard/newmessage/'.$project_id.'">New Message</a></li>
			<li><a href="'.VPATH.'projectdashboard/outgoing/'.$project_id.'">Sent Message</a></li>
			<li><a href="'.VPATH.'projectdashboard/allfiles/'.$project_id.'">Files</a></li>
			<li><a href="'.VPATH.'projectdashboard/milestone/'.$project_id.'">Milestones</a></li>
			<li><a href="'.VPATH.'projectdashboard/payment_history/'.$project_id.'">Payment History</a></li>
			</ul>
			</div>
			
			
			<div class="proamount">
			<ul>
			<li>Project Amount : <span>'.CURRENCY.' '.$bidder_amt.'</span></li>
			<li>Paid Amount : <span>'.CURRENCY.' '.$paid_amount.'</span></li>
			<li>Remaining Amount : <span>'.CURRENCY.' '.($bidder_amt-$paid_amount).'</span></li>
			</ul>
			<p>
			
			</div>
		
			</div>';
			return $b;	
	}
	public function leftpanel($logo,$completeness){
		$plan=0;$img="";
		if($this->session->userdata('user'))
		{
			$user=$this->session->userdata('user');
			$plan=$user[0]->membership_plan;
		}
		if($plan==1)
		{
			$img="FREE_img.png";	
		}
		elseif($plan==2)
		{
			$img="SILVER_img.png";	
		}
		elseif($plan==3)
		{
			$img="GOLD_img.png";	
		}
		elseif($plan==4)
		{
			$img="PLATINUM_img.png";	
		}
		$b='<div class="sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        
                        <div class="widget category">
                           <h3 class="title">Profile completeness</h3>
                          
                           <div class="user_box">
						   <div class="userimg"><img src="'.VPATH.'assets/'.$logo.'"></div>
						   <div style="clear:both;"></div>
                           <div class="improve_icon">
                           <div class="improvebox"><div style="width: '.$completeness.'%" class="imprbox"></div>
                           </div> <p> '.floor($completeness).'%</p></div>
                           <div class="improve_bnt"><a href="'.VPATH.'dashboard/editprofile_professional"> Edit Profile</a></div>
                          <div class="freeimg_box"><img src="'.ASSETS.'images/'.$img.'"></div>            
                                 
                           </div>    
                           
                           
                           <ul class="category-list slide">
                  <li><a href="'.VPATH.'notification/">Notification <span class="count_list" style="display:none">12</span></a></li>          
				  <li><a href="#">My Projects</a><br>
						<span><a href="'.VPATH.'dashboard/myproject_professional">As Freelancer</a></span><br>
						<span><a href="'.VPATH.'dashboard/myproject_client">As Employer</a></span></li>
						      				
						<li><a href="'.VPATH.'myfinance/">My Finance</a></li>
									
						<li><a href="'.VPATH.'dashboard/">My Profile</a><br>
						<span><a href="'.VPATH.'dashboard/profile_professional"> As Freelancer</a></span><br>
						<span><a href="'.VPATH.'dashboard/profile_client"> As Employer</a></span></li>						
						<li><a href="'.VPATH.'findtalents/myfreelancer/">Myfreelancer</a></li>						
                              <li><a href="'.VPATH.'membership/">Membership</a></li>
                              <li><a href="'.VPATH.'message/">Inbox</a></li>
                              <li><a href="'.VPATH.'dashboard/myfeedback/">Feedback</a></li>
							  <li><a href="'.VPATH.'disputes/">Disputes</a></li>
                              <li><a href="'.VPATH.'dashboard/setting">Setting</a></li>
                              <li><a href="'.VPATH.'testimonial/">Give Testimonial</a></li>
                             <!-- <li><a href="'.VPATH.'references/">My References</a></li>-->
                              <li><a href="'.VPATH.'dashboard/closeacc">Close Account</a></li>    
                           </ul>
                        </div>
                        
                     </div>';
		return $b;
	}
        
     public function job_leftpanel($parent){ 
        $lft="<div class='sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12'>
        <div class='accordionMod panel-group'>";
        
        foreach($parent as $key =>$val){ 
            
        $lft.="<div class='accordion-item'>
        <h4 class='accordion-toggle'>".$val['cat_name']."</h4>
        <section class='accordion-inner panel-body'> 	
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>";
          
           $subcat=$this->auto_model->getcategory($val['cat_id']);
           
           foreach ($subcat as $key => $sval){ 
              $lft.="<li><a href='#'>".$sval['cat_name']."</a></li>"; 
           }
           
              
        
        $lft.="</ul> 
        </section>
        </div>";            
            
            
        }
        




       $lft.="<div class='accordion-item'>
        <h4 class='accordion-toggle'>Project Type</h4>
        <section class='accordion-inner panel-body'>
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>							
        <li><a href='#'>All</a></li>
        <li><a href='#'>Hourly</a></li>
        <li><a href='#'>Fixed</a></li>
        </ul>
        </section>
        </div>

        <div class='accordion-item'>
        <h4 class='accordion-toggle'>Budget</h4>
        <section class='accordion-inner panel-body'>
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'><li>
        <form method='post' action=''>

        <div style='display: block;' aria-hidden='false' class='doller clearfix'>
        $ <input type='text' value='0' name='budget_min' class='mini-inp'>
        to $ <input type='text' value='0' name='budget_max' class='mini-inp'>
        <input type='hidden' value='' name='cat_id'>	
        <input type='hidden' value='' name='posted_time'>	
        <input type='hidden' value='' name='country'>	
        <input type='submit' class='ok-btn' value='Ok'>
        </div>
        </form>
        </li>
        </ul>
        </section>
        </div>

        <div class='accordion-item'>
        <h4 class='accordion-toggle'>Radius</h4>
        <section class='accordion-inner panel-body'>
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'><li>
        <form method='post' action=''>
        <div style='display: block;' aria-hidden='false' class='doller clearfix'>
        Miles
        <input type='text' style='width:100px' value='0' class='mini-inp' name='radius'>
        <input type='hidden' value='' name='cat_id'>	
        <input type='hidden' value='' name='posted_time'>	
        <input type='hidden' value='' name='country'>	
        <input type='submit' class='ok-btn' value='Ok'>
        </div>
        </form>
        </li>
        </ul>
        </section>
        </div>

        <div class='accordion-item'>
        <h4 class='accordion-toggle'>Postal Code</h4>
        <section class='accordion-inner panel-body'>
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'><li>
        <form method='post' action=''>
        <div style='display: block;' aria-hidden='false' class='doller clearfix'>
        Postal Code
        <input type='text' style='width:73px' value='0' name='p_code' class='mini-inp' >
        <input type='hidden' value='' name='cat_id'>	
        <input type='hidden' value='' name='posted_time'>	
        <input type='hidden' value='' name='country'>	
        <input type='submit' class='ok-btn' value='Ok'>
        </div>
        </form>
        </li>
        </ul>
        </section>
        </div>

        <div class='accordion-item'>
        <h4 class='accordion-toggle'>Posted within</h4>
        <section class='accordion-inner panel-body'>
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>							
        <li><a href='#'>All</a></li>
        <li><a href='#'>Posted within 24 hours</a></li>
        <li><a href='#'>Posted within 3 days</a></li>
        <li><a href='#'>Posted within 7 days</a></li>
        </ul>
        </section>
        </div>

        <div class='accordion-item'>
        <h4 class='accordion-toggle'>Country</h4>
        <section class='accordion-inner panel-body'>
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>							
        <li><a href='#'><strong>All</strong></a></li>
        <li><a href='#'>Canada</a></li>
        <li><a href='#'>United States</a></li>
        </ul>
        </section>
        </div>
        </div>

        </div>";
        return $lft;
     }
        
   public function getCountry(){ 
       $this->db->select("Code,Name");
	   $this->db->order_by("Name", "asc");
       $res=  $this->db->get_where("country");
       
       $data=array();
       
       foreach ($res->result() as $row){ 
           $data[]=array(
              "code" => $row->Code,
              "name" => $row->Name
           );
       }
       return $data;
   }
   
   public function getCity($ccode){ 
       $this->db->select("Name");
	   $this->db->order_by("Name", "asc");
       $res=  $this->db->get_where("city",array("CountryCode"=>$ccode));
       
       $data=array();
       
       foreach ($res->result() as $row){ 
           $data[]=array(            
              "name" => $row->Name
           );
       }
       return $data;
   }   
   
   public function isOwner($pid){ 
       $uid=$this->getFeild("user_id", "projects", "project_id", $pid);
       $user=$this->session->userdata('user');
       
       if($user[0]->user_id==$uid){ 
           return TRUE;
       }
       else{ 
           return FALSE;
       }               
   }
   
   public function isinvitees(){ 
           return FALSE;
   }
   public function getPaidAmount($pid,$wid){ 
        $this->db->select_sum("bider_to_pay"); 
        $this->db->where("project_id",$pid);
        $this->db->where("worker_id",$wid);
		$this->db->where("release_type",'P');
        $res=$this->db->get("milestone_payment");
		
        $data=array();
        if($this->db->count_all_results()>0){ 
            foreach($res->result() as $row){ 
                $data[]=$row->bider_to_pay;
            }            
        }
        else{ 
            $data[0]=0;
        }

        return $data[0];        
                
    }     
   
	
}