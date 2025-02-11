<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Findjob extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('findjob_model');
		$this->load->model('jobdetails/jobdetails_model');
		$this->load->library('pagination');
		$idiom = $this->session->userdata('lang');
		$this->lang->load('findjob', $idiom);
        parent::__construct();
    }

    public function index() {
		redirect(base_url('findjob/browse'));
		$data['srch_url'] = uri_string();
		$data['srch_param'] = $data['srch_string'] = $this->input->get();
		
		$breadcrumb=array(
						array(
                            'title'=>__('findjob_find_job','Find Job'),'path'=>''
						)
					);

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('findjob_find_job','Find Job'));
		
		$data['offset'] = 6;
		$data['limit'] = !empty($data['srch_param']['per_page']) ? $data['srch_param']['per_page'] : 0;
		$data['srch_string'] = !empty($data['srch_string']) ? $data['srch_string'] : array();
		
		unset($data['srch_string']['per_page']);
		unset($data['srch_string']['total']);

		$data['projects'] = $this->findjob_model->list_project($data['srch_param'] , $data['limit'] , $data['offset']);
		$data['total_projects'] = $this->findjob_model->list_project($data['srch_param'] , $data['limit'] , $data['offset'] , FALSE);
		$q1 = array('select' => '*' , 'from' => 'categories' , 'where' => array('status' => 'Y' ,'parent_id' => 0) , 'offset' => 500);
		$data['parent_category'] = get_results($q1);
	
		$data['child_category'] = array();
		if(!empty($cat_id)){
			$q2 = array('select' => '*' , 'from' => 'categories' , 'where' => array('status' => 'Y' ,'parent_id' => $q2) , 'offset' => 500);
			$data['child_category'] =  get_results($q2);
		}
		$q3 = array('select' => '*' , 'from' => 'country' , 'offset' => 1000);
		$data['countries'] =  get_results($q3);
		
		$q4 = array('select' => '*' , 'from' => 'experience_level' , 'where' => array('status' => 'Y'));
			
		$data['exp_levels'] =  get_results($q4);
		
		/*Pagination Start*/
		$config['base_url'] = base_url('findjob/?total=10');
		$config['base_url'] .= !empty($data['srch_string']) ? '&'.http_build_query($data['srch_string']) : '';
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $data['total_projects'];
		$config['per_page'] = $data['offset'];
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');
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
		
		$head['current_page']='findjob';
		$head['ad_page']='findjob';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Findjob");
		$lay['client_testimonial']="inc/footerclient_logo";
		//print_r($data);
		$this->layout->view('list',$lay,$data,'normal');
	}
	
	public function browse($cat='',$cat_id='',$sub_cat='',$sub_cat_id=''){
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		$data['srch_url'] = uri_string();
		$data['srch_param'] = $data['srch_string'] = $this->input->get();
		$data['srch_param']['term'] = $data['srch_string']['term'] = $data['srch_string']['q'];
		$data['srch_param']['category'] = $cat;
		$data['srch_param']['category_id'] = $cat_id;
		$data['srch_param']['sub_catgory'] = $sub_cat;
		$data['srch_param']['sub_catgory_id'] = $sub_cat_id;
		
		$data['offset'] = 10;
		$data['limit'] = !empty($data['srch_param']['per_page']) ? $data['srch_param']['per_page'] : 0;
		$data['srch_string'] = !empty($data['srch_string']) ? $data['srch_string'] : array();
		
		unset($data['srch_string']['per_page']);
		unset($data['srch_string']['total']);
		
		if(!empty($data['srch_param']['skills']) && is_array($data['srch_param']['skills'])){
			$data['selected_skills'] = $this->db->where_in('id', $data['srch_param']['skills'])->get('skills')->result_array();
		}else{
			$append_skill = $this->input->get('append_skill');
			if($append_skill == ''){
				$append_skill = 1;
			}
			/* if($user_id > 0 && $append_skill == 1){
				$user_skills_arr = array();
				$user_skills = $this->db->where('user_id', $user_id)->get('new_user_skill')->result_array();
				if(count($user_skills) > 0){
					foreach($user_skills as $k => $v){
						$user_skills_arr[] = $v['sub_skill_id'];
					}
					
				}
				
				if(count($user_skills_arr) > 0){
					$data['srch_param']['skills'] = $user_skills_arr;
					$data['selected_skills'] = $this->db->where_in('id', $user_skills_arr)->get('skills')->result_array();
				}
				
			}else{
				$data['selected_skills'] = array();
			} */
			$data['selected_skills'] = array();
		}
		
		
		$data['projects'] = $this->findjob_model->list_project($data['srch_param'] , $data['limit'] , $data['offset']);
		$data['total_projects'] = $this->findjob_model->list_project($data['srch_param'] , $data['limit'] , $data['offset'] , FALSE);
		$q1 = array('select' => '*' , 'from' => 'categories' , 'where' => array('status' => 'Y' ,'parent_id' => 0) , 'offset' => 500);
		$data['parent_category'] = get_results($q1);
		$data['child_category'] = array();
		if(!empty($cat_id)){
			$q2 = array('select' => '*' , 'from' => 'categories' , 'where' => array('status' => 'Y' ,'parent_id' => $cat_id) , 'offset' => 500);
			$data['child_category'] =  get_results($q2);
		}
		$q3 = array('select' => '*' , 'from' => 'country' , 'offset' => 1000);
		$data['countries'] =  get_results($q3);
		
		$q4 = array('select' => '*' , 'from' => 'experience_level' , 'where' => array('status' => 'Y'));
			
		$data['exp_levels'] =  get_results($q4);
		
		/*Pagination Start*/
		if(!empty($cat_id)){
			$config['base_url'] = base_url('findjob/browse/'.$cat.'/'.$cat_id.'?total=10');
		}else{
			$config['base_url'] = base_url('findjob/browse?total=10');
		}
		
		$config['base_url'] .= !empty($data['srch_string']) ? '&'.http_build_query($data['srch_string']) : '';
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $data['total_projects'];
		$config['per_page'] = $data['offset'];
		
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
		
		
		$breadcrumb=array(
                    array(
                            'title'=>__('findjob_find_job','Find Job'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('findjob_find_job','Find Job'));
		
		$head['current_page']='findjob';
		$head['ad_page']='findjob';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Findjob");
		$lay['client_testimonial']="inc/footerclient_logo";
		
	
		$this->layout->view('list',$lay,$data,'normal');
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
			$data['projects']=$this->findjob_model->getSearchProjects($cat,$category,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid);
			
			foreach($data['projects'] as $k => $val){
				$r2= array('select' => '*' , 'from' => 'user' , 'where' => array('status' => 'Y' ,'user_id' => $val['user_id']));
				$data['projects']['user_date'] = 'dfslkghnlkdfs';
			}
		}
		else
		{	
			$data['projects']=$this->findjob_model->getFilerjob($category,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid,'','');
			
			foreach($data['projects'] as $k => $val){
			 $r1= array('select' => '*' , 'from' => 'user' , 'where' => array('status' => 'Y' ,'user_id' => $val['user_id']));
			 $data['projects']['user_date'] = get_results($r1);
			}
		}
		
		$q1 = array('select' => '*' , 'from' => 'categories' , 'where' => array('status' => 'Y' ,'parent_id' => 0) , 'offset' => 500);
		$data['parent_category'] = get_results($q1);
		$data['child_category'] = array();
		if(!empty($cat_id)){
			$q2 = array('select' => '*' , 'from' => 'categories' , 'where' => array('status' => 'Y' ,'parent_id' => $cat_id) , 'offset' => 500);
			$data['child_category'] =  get_results($q2);
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
		$data['projects']=$this->findjob_model->getAllSearchProjects($searchby,$cat);
		//print_r($data);
		$this->layout->view('ajax_projectlist', '', $data, 'ajax', 'N');
		//return $data['gallery'];
	}
	public function filterjob($category = '', $project_type = '', $min_budget='', $max_budget = '', $posted = '', $country = '',$city='',$featured='',$environment='',$uid='', $limit_from='')
	{
		$breadcrumb=array(
                    array(
                            'title'=>__('findjob_all_job','All Jobs'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'findjob_all_job','All Jobs');

        $user=$this->session->userdata('user');

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
		$config['base_url'] = VPATH.'findjob/filterjob/'.$cat.'/'.$ptype.'/'.$minb.'/'.$maxb.'/'.$post_with.'/'.$country.'/'.$city.'/'.$featured.'/'.$environment.'/'.$uid.'/';
		$config['total_rows'] =$this->findjob_model->countFilerjob($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid);
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
		$data['projects']=$this->findjob_model->getFilerjob($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid,$config['per_page'], $start);
		

		$head['current_page']='findjob';
		
		$head['ad_page']='findjob';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);



		$this->autoload_model->getsitemetasetting("meta","pagename","Findjob");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('list',$lay,$data,'normal');
	}
    
	
	public function get_skills(){
		$res = array();
		$skills = get_results(array('select' => '*', 'from' => 'skills', 'status' => 'Y'));
		if(!empty($skills)){
			foreach($skills as $k => $v){
				$res[] = array(
					'text' => $v['skill_name'],
					'value' => $v['id']
				);
			}
		}
		echo json_encode($res);
	}

    
    
}
