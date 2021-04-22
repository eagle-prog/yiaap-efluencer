<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobfeed extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('jobfeed_model');
		$this->load->model('jobdetails/jobdetails_model');
		$this->load->library('pagination');
	//$this->load->library('form_validation');
        parent::__construct();
    }

    public function index($limit_from='') {
    	if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");
		}
		else
		{
			
			$this->auto_model->updateproject();
			$user=$this->session->userdata('user');
			
			$data['user_id']=$user[0]->user_id;
			if($this->session->userdata('user'))
			{
			if($this->input->post('submit')){
				$post = $this->input->post();
				if($post['submit'] == 'edit_hour' && !empty($post['available_week'])){
					$this->db->set('available_hr' , trim($post['available_week']))->where('user_id' , $data['user_id'])->update('user');
				}
			}
	  
			///////////////////////////Right Section start//////////////////



			$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);



			if($logo==''){

				$logo="images/user.png";

			}

			else{

				$logo="uploaded/".$logo;

			}

			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

			$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
	}
			$data['logo']= $logo;

			///////////////////////////Right Section end//////////////////
			
			
			
			$breadcrumb=array(
						array(
								'title'=>'All Jobs','path'=>''
						)
					);
			
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'All Jobs');
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
			$data['available_hr'] = $this->autoload_model->getFeild('available_hr','user','user_id',$data['user_id']);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
			///////////////////////////Leftpanel Section start//////////////////

			

			//$data['leftpanel']=$this->autoload_model->job_leftpanel($parent_cat);
	$user_id=$user[0]->user_id;
	$wh='';
			$skill_list=$this->auto_model->getFeild("skills_id","user_skills","user_id",$user_id);
			$wh=array();
	if($skill_list!=""){ 
		$skill_list=  explode(",",$skill_list);
		foreach($skill_list as $key => $s){ 
			$lnk=$this->auto_model->getFeild("skill_name","skills","id",$s); 
			$wh[]="FIND_IN_SET('".strtolower($lnk)."',LOWER(skills))";
		}
		$wh="(".implode(" or ",$wh).")";
		}
			///////////////////////////Leftpanel Section end//////////////////
			$this->load->library('pagination');
			$config['base_url'] = VPATH.'jobfeed/index/';
			if($wh){
			
			$config['total_rows'] =$this->db->where($wh." !=", 0)->get_where('projects',array('status'=>'O','project_status'=>'Y'))->num_rows();
			//echo $this->db->last_query(); die();
			}else{
			$config['total_rows'] =0;
			}
			$config['per_page'] = 5; 
			$config["uri_segment"] = 3;
			$config['use_page_numbers'] = TRUE;   
					$config['full_tag_open'] = "<div class='pagination'><ul>";
					$config['full_tag_close'] = '</ul></div>';
					$config['first_link'] = 'First';
					$config['first_tag_open'] = '<li>';
					$config['first_tag_close'] = '</li>';
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'><b>";
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
					if ($page > 0) {
						for ($i = 1; $i < $page; $i++) {
							$start = $start + $per_page;
						}
					}
			$data['total']=$config['total_rows'];
			$data['projects']=$this->jobfeed_model->getProjects($config['per_page'], $start);
			//print_r($data['projects']);
			$data['links']=$this->pagination->create_links();

			$head['current_page']='jobfeed';
			
			$head['ad_page']='jobfeed';

			$load_extra=array();

			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

			$this->layout->set_assest($head);



			$this->autoload_model->getsitemetasetting("meta","pagename","Jobfeed");

			$lay['client_testimonial']="inc/footerclient_logo";
			$data['favourite_project'] = $this->jobfeed_model->getFavouriteproject();
			
			//get_print($data);
			$this->layout->view('list',$lay,$data,'normal');
			

		}
    }
	
	public function getsrch()
	{
		$cat=str_replace("%20"," ",$this->uri->segment(3));
		$category=str_replace('_','&',$this->uri->segment(4));
		$ptype=$this->uri->segment(5);
		$minb=$this->uri->segment(6);
		$maxb=$this->uri->segment(7);
		$post_with=$this->uri->segment(8);
		$country=$this->uri->segment(9);
		$city=$this->uri->segment(10);
		$featured=$this->uri->segment(11);
		$environment=$this->uri->segment(12);
		$uid=$this->uri->segment(13);
		
		$category=str_replace('%20',' ',$category);
		$country=str_replace('%20',' ',$country);
		$city=str_replace('%20',' ',$city);
		
		if($cat!='_')
		{
			$data['projects']=$this->jobfeed_model->getSearchProjects($cat,$category,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid);
		}
		else
		{	
			$data['projects']=$this->jobfeed_model->getFilerjob($category,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid,'','');
		}
		$data['favourite_project'] = $this->jobfeed_model->getFavouriteproject();
		//print_r($data);
		$this->layout->view('ajax_projectlist', '', $data, 'ajax', 'N');
		//return $data['gallery'];
	}
	public function serachproject()
	{
		$cat=$this->uri->segment(4);
		$cat=str_replace('%20',' ',$cat);
		$searchby=$this->uri->segment(3);
		$data['projects']=$this->jobfeed_model->getAllSearchProjects($searchby,$cat);
		//print_r($data);
		$this->layout->view('ajax_projectlist', '', $data, 'ajax', 'N');
		//return $data['gallery'];
	}
	public function filterjob($category = '', $project_type = '', $min_budget='', $max_budget = '', $posted = '', $country = '',$city='',$featured='',$environment='',$uid='', $limit_from='')
	{
		$breadcrumb=array(
                    array(
                            'title'=>'All Jobs','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'All Jobs');

        $user=$this->session->userdata('user');
$data['user_id']=$user[0]->user_id;
	  if($this->session->userdata('user'))
						{
  
		///////////////////////////Right Section start//////////////////



		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		$data['favourite_project'] = $this->jobfeed_model->getFavouriteproject();

		if($logo==''){

			$logo="images/user.png";

		}

		else{

			$logo="uploaded/".$logo;

		}
		$data['logo'] = $logo;
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
}


		///////////////////////////Right Section end//////////////////

		
		///////////////////////////Leftpanel Section start//////////////////

		$data['parent_cat']=  $this->auto_model->getcategory(0);
		$data['countries']= $this->autoload_model->getCountry();

		//$data['leftpanel']=$this->autoload_model->job_leftpanel($parent_cat);

		///////////////////////////Leftpanel Section end//////////////////
		
		/*$data['category']=$cat=str_replace('_','&',$this->uri->segment(3));
		$data['project_type']=$ptype=$this->uri->segment(4);
		$data['min_budget']=$minb=$this->uri->segment(5);
		$data['max_budget']=$maxb=$this->uri->segment(6);
		$data['posted']=$post_with=$this->uri->segment(7);
		$data['country']=$country=$this->uri->segment(8);*/
		
		$data['category']=$cat=str_replace('_','&',$category);
		$data['project_type']=$ptype=$project_type;
		$data['min_budget']=$minb=$min_budget;
		$data['max_budget']=$maxb=$max_budget;
		$data['posted']=$post_with=$posted;
		$data['country']=$country=$country;
		$data['city']=$city=$city;
		$data['featured']=$featured=$featured;
		$data['environment']=$environment=$environment;
		$data['uid']=$uid=$uid;
		
		$cat=str_replace('%20',' ',$cat);
		$country=str_replace('%20',' ',$country);
		$city=str_replace('%20',' ',$city);
		
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'jobfeed/filterjob/'.$cat.'/'.$ptype.'/'.$minb.'/'.$maxb.'/'.$post_with.'/'.$country.'/'.$city.'/'.$featured.'/'.$environment.'/'.$uid.'/';
		$config['total_rows'] =$this->jobfeed_model->countFilerjob($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid);
		$config['per_page'] = 5; 
		$config["uri_segment"] = 10;
		$config['use_page_numbers'] = TRUE;   
		$this->pagination->initialize($config); 
		$page = ($limit_from) ? $limit_from : 0;
                $per_page = $config["per_page"];
                $start = 0;
                if ($page > 0) {
                    for ($i = 1; $i < $page; $i++) {
                        $start = $start + $per_page;
                    }
                }
		$data['total']=$config['total_rows'];
		$data['projects']=$this->jobfeed_model->getFilerjob($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid,$config['per_page'], $start);

		$head['current_page']='jobfeed';
		
		$head['ad_page']='jobfeed';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);



		$this->autoload_model->getsitemetasetting("meta","pagename","Findjob");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('list',$lay,$data,'normal');
	}
    

    
    
}
