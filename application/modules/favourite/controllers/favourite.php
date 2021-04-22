<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Favourite extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('favourite_model');
        parent::__construct();
    }

    public function index($limit_from='') {
    if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}else{
    
        $user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){

			$logo="images/user.png";

		}

		else{

			$logo="uploaded/".$logo;

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
	
        $data['logo']= $logo;

		///////////////////////////Right Section end//////////////////
		
		
		
		$breadcrumb=array(
                    array(
                            'title'=>'Favourite','path'=>''
                    )
                );
		
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Favourite');
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['available_hr'] = $this->autoload_model->getFeild('available_hr','user','user_id',$data['user_id']);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
		///////////////////////////Leftpanel Section start//////////////////
		$head['current_page']='jobfeed';
		
		$head['ad_page']='jobfeed';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$data['fav_projects'] = $this->favourite_model->getFavouriteProject($data['user_id']);

		$this->autoload_model->getsitemetasetting("meta","pagename","Jobfeed");

		$lay['client_testimonial']="inc/footerclient_logo";

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



		if($logo==''){

			$logo="images/user.png";

		}

		else{

			$logo="uploaded/".$logo;

		}

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
