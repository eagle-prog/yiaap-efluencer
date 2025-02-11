<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Findjob_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	public function list_project($srch_param=array() , $limit=0 , $offset=40 , $for_list=TRUE){
		
		if($srch_param){
			foreach($srch_param as $k => $v){
				if(!is_array($v)){
					$srch_param[$k] = htmlentities($v);
				}
				
			}
		}
		//get_print($srch_param);
		$project = $this->db->dbprefix('projects');
		$user = $this->db->dbprefix('user');
		$this->db->select("$project.*,$user.fname,$user.lname,$user.country,$user.city")->from('projects');
		$this->db->join("user", "$project.user_id = $user.user_id" , "INNER");
		$this->db->join("project_skill", "project_skill.project_id=projects.project_id" , "LEFT");
		$this->db->join("skills", "skills.id=project_skill.skill_id" , "LEFT");
		
		$this->db->where("$project.visibility_mode", "Public");
		if(!empty($srch_param['skills'])){
			$this->db->where_in("project_skill.skill_id", $srch_param['skills']);
		}
		
		/* if(!empty($srch_param['category_id'])){
			$this->db->where("$project.category" , $srch_param['category_id']);
		}
		
		if(!empty($srch_param['sub_catgory_id'])){
			$this->db->where("$project.sub_category" , $srch_param['sub_catgory_id']);
		} */
		
		if(!empty($srch_param['category_id'])){
			$this->db->where("skills.cat_id" , $srch_param['category_id']);
		}
		
		if(!empty($srch_param['exp_level'])){
			$this->db->where("$project.exp_level" , $srch_param['exp_level']);
		}
		
		if(!empty($srch_param['ccode'])){
			$this->db->where("$user.country" , $srch_param['ccode']);
		}
		
		
		
		if(!empty($srch_param['env']) AND $srch_param['env'] != 'All'){
			$this->db->where("$project.environment" , $srch_param['env']);
		}
		
		if(!empty($srch_param['ptype']) AND $srch_param['ptype'] != 'All'){
			$this->db->where("$project.project_type" , $srch_param['ptype']);
		}
		
		if(!empty($srch_param['featured']) AND $srch_param['featured'] != 'All'){
			$this->db->where("$project.featured" , $srch_param['featured']);
		}
		
		if(!empty($srch_param['min'])){
			$this->db->where("$project.buget_min >=",$srch_param['min']);
		}
		
		if(!empty($srch_param['max'])){
			$this->db->where("$project.buget_max <=" , $srch_param['max']);
		}
		
		if(!empty($srch_param['q']) || !empty($srch_param['term'])){
			$term = !empty($srch_param['q']) ? $srch_param['q'] : $srch_param['term'];
			$term = addslashes($term);
			$this->db->where("($project.title LIKE '%{$term}%' OR $project.description LIKE '%{$term}%')");
		}
		
		if(!empty($srch_param['posted']) AND $srch_param['posted'] != 'All'){
			$newdate=date('Y-m-d',strtotime("-".$srch_param['posted']." day",strtotime(date('Y-m-d'))));
			$this->db->where('post_date >=',$newdate);
		}
		
		$this->db->where(array("$project.status"=>'O',"$project.project_status"=>'Y'));
		$this->db->group_by("$project.project_id");
		if($for_list){
			$result = $this->db->limit($offset , $limit)->order_by("$project.featured" , 'ASC')->order_by("$project.id" , "DESC")->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}
		//echo $this->db->last_query();
		return $result;
	}

   public function getSearchProjects($cat,$category,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid)
   {
   		$this->db->select();
		if($category!='All')
		{
			$cate=explode("-",$category);
			$this->db->where_in('category',$cate);	
		}
		if($ptype!='All')
		{
				$this->db->where('project_type',$ptype);	
		}
		if($minb>0)
		{
			$this->db->where('buget_min >=',$minb);
		}
		if($maxb > 0)
		{
			$this->db->where('buget_max <=',$maxb);
		}
		if($post_with!='All')
		{
			$newdate=date('Y-m-d',strtotime("-".$post_with." day",strtotime(date('Y-m-d'))));
			$this->db->where('post_date >=',$newdate);
		}
		if($country!='All')
		{
			$this->db->where('user_country',$country);
		}
		if($city!='All')
		{
			$this->db->where('user_city',$city);
		}
		if($featured!='All')
		{
			$this->db->where('featured',$featured);
		}
		if($environment!='All')
		{
			$this->db->where('environment',$environment);
		}
		
		if($uid > 0)
		{
			$this->db->where('user_id',$uid);
		}
		// set this to false so that _protect_identifiers skips escaping:
		$this->db->_protect_identifiers = FALSE;
		
		// your order_by line:
		$this -> db -> order_by("FIELD ( serv_projects.featured, 'N', 'Y')",'DESC');
		
		// important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
		$this->db->_protect_identifiers = TRUE;
		$this->db->where("(title LIKE '%".$cat."%' OR description LIKE '%".$cat."%')");
		/*$this->db->like('description',$cat);*/
		$rs=$this->db->get_where('projects',array('status'=>'O','project_status'=>'Y'));
		
		$data=array();
		foreach($rs->result() as $row)
		{
			if($row->visibility_mode=="Private" && $this->session->userdata('user')){
				$user=$this->session->userdata('user');
				
				if($this->autoload_model->isOwner($row->project_id) || $this->autoload_model->isinvitees($row->project_id,$user[0]->email)){ 
					
					$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'user_id'=>$row->user_id,
					'title'=>$row->title,
					'description'=>$row->description,
					'category' => $row->category,
					'sub_category' => $row->sub_category,
					'skills' => $row->skills,
					'environment'=>$row->environment,
					'project_type'=>$row->project_type,
					'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'post_date'=>$row->post_date,
					'expiry_date'=>$row->expiry_date,
					'user_country'=>$row->user_country,
					'country'=>$row->user_country,
					'user_city'=>$row->user_city,
					'user'=>$this->getUser($row->user_id)
					);
					
				}
			}
			else if($row->visibility_mode=="Public"){ 
				$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'user_id'=>$row->user_id,
					'title'=>$row->title,
					'description'=>$row->description,
					'category' => $row->category,
					'sub_category' => $row->sub_category,
					'skills' => $row->skills,
					'environment'=>$row->environment,
					'project_type'=>$row->project_type,
					'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'post_date'=>$row->post_date,
					'expiry_date'=>$row->expiry_date,
					'user_country'=>$row->user_country,
					'country'=>$row->user_country,
					'user_city'=>$row->user_city,
					'user'=>$this->getUser($row->user_id)
				);
			}
		}
		return $data;
   }
   public function getAllSearchProjects($field,$cat)
   {
   		$this->db->select();
		// set this to false so that _protect_identifiers skips escaping:
		$this->db->_protect_identifiers = FALSE;
		
		// your order_by line:
		$this -> db -> order_by("FIELD ( serv_projects.featured, 'N', 'Y')",'DESC');
		
		// important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
		$this->db->_protect_identifiers = TRUE;
		$this->db->like($field,$cat);
		$rs=$this->db->get_where('projects',array('status'=>'O','project_status'=>'Y'));
		$data=array();
		foreach($rs->result() as $row)
		{
			if($row->visibility_mode=="Private" && $this->session->userdata('user')){  
				$user=$this->session->userdata('user');
				
				if($this->autoload_model->isOwner($row->project_id) || $this->autoload_model->isinvitees($row->project_id,$user[0]->email)){ 
					
					$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'user_id'=>$row->user_id,
					'title'=>$row->title,
					'description'=>$row->description,
					'category' => $row->category,
					'sub_category' => $row->sub_category,
					'skills' => $row->skills,
					'environment'=>$row->environment,
					'project_type'=>$row->project_type,
					'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'post_date'=>$row->post_date,
					'expiry_date'=>$row->expiry_date,
					'user_country'=>$row->user_country,
					'user_city'=>$row->user_city,
					'user'=>$this->getUser($row->user_id)
					);
					
				}
				
				
			}
			else if($row->visibility_mode=="Public"){ 
				$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'user_id'=>$row->user_id,
					'title'=>$row->title,
					'description'=>$row->description,
					'category' => $row->category,
					'sub_category' => $row->sub_category,
					'skills' => $row->skills,
					'environment'=>$row->environment,
					'project_type'=>$row->project_type,
								'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'post_date'=>$row->post_date,
					'expiry_date'=>$row->expiry_date,
					'user_country'=>$row->user_country,
					'user_city'=>$row->user_city,
					'user'=>$this->getUser($row->user_id)
				);
			}
		}
		return $data;
   }
   public function getAllProjects()
   {
   		$this->db->select();
		// set this to false so that _protect_identifiers skips escaping:
		$this->db->_protect_identifiers = FALSE;
		
		// your order_by line:
		$this -> db -> order_by("FIELD ( serv_projects.featured, 'N', 'Y')",'DESC');
		
		// important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
		$this->db->_protect_identifiers = TRUE;
		$rs=$this->db->get_where('projects',array('status'=>'O','project_status'=>'Y'));
		$data=array();
		foreach($rs->result() as $row)
		{
			if($row->visibility_mode=="Private" && $this->session->userdata('user')){  
				$user=$this->session->userdata('user');
				
				if($this->autoload_model->isOwner($row->project_id) || $this->autoload_model->isinvitees($row->project_id,$user[0]->email)){ 
					
					$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'user_id'=>$row->user_id,
					'title'=>$row->title,
					'description'=>$row->description,
					'category' => $row->category,
					'sub_category' => $row->sub_category,
					'skills' => $row->skills,
					'environment'=>$row->environment,
					'project_type'=>$row->project_type,
					'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'post_date'=>$row->post_date,
					'expiry_date'=>$row->expiry_date,
					'user_country'=>$row->user_country,
					'user_city'=>$row->user_city,
					'user'=>$this->getUser($row->user_id)
					);
					
				}
				
				
			}
			else if($row->visibility_mode=="Public"){ 
				$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'user_id'=>$row->user_id,
					'title'=>$row->title,
					'description'=>$row->description,
					'category' => $row->category,
					'sub_category' => $row->sub_category,
					'skills' => $row->skills,
					'environment'=>$row->environment,
					'project_type'=>$row->project_type,
								'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'post_date'=>$row->post_date,
					'expiry_date'=>$row->expiry_date,
					'user_country'=>$row->user_country,
					'user_city'=>$row->user_city,
					'user'=>$this->getUser($row->user_id)
				);
			}
		}
		return $data;
   }
   public function getUser($id)
   {
   		$this->db->select('fname,lname,country,city');
		$this->db->where('user_id',$id);
		$rss=$this->db->get('user');
		return $rss->row();
   }
   public function getFilerjob($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid,$limit = '', $start = '')
   {
	   
		$this->db->select();
		if($cat!='All')
		{
			$category=explode("-",$cat);
			$this->db->where_in('category',$category);	
		}
		if($ptype!='All')
		{
				$this->db->where('project_type',$ptype);	
		}
		if($minb>0)
		{
			$this->db->where('buget_min >=',$minb);
		}
		if($maxb > 0)
		{
			$this->db->where('buget_max <=',$maxb);
		}
		if($post_with!='All')
		{
			$newdate=date('Y-m-d',strtotime("-".$post_with." day",strtotime(date('Y-m-d'))));
			$this->db->where('post_date >=',$newdate);
		}
		if($country!='All')
		{
			$this->db->where('user_country',$country);
		}
		if($city!='All')
		{
			$this->db->where('user_city',$city);
		}
		if($featured!='All')
		{
			$this->db->where('featured',$featured);
		}
		if($environment!='All')
		{
			$this->db->where('environment',$environment);
		}
		if($uid > 0)
		{
			$this->db->where('user_id',$uid);
		}
		// set this to false so that _protect_identifiers skips escaping:
		$this->db->_protect_identifiers = FALSE;
		
		// your order_by line:
		$this -> db -> order_by("FIELD ( serv_projects.featured, 'N', 'Y')",'DESC');
		
		// important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
		$this->db->_protect_identifiers = TRUE;
		if($limit>0)
		{
		$this->db->limit($limit, $start);
		}
		$rs=$this->db->get_where('projects',array('status'=>'O','project_status'=>'Y'));
		//echo $this->db->last_query();
		$data=array();
		foreach($rs->result() as $row)
		{
			if($row->visibility_mode=="Private" && $this->session->userdata('user')){  
				$user=$this->session->userdata('user');
				
				if($this->autoload_model->isOwner($row->project_id) || $this->autoload_model->isinvitees($row->project_id,$user[0]->email)){ 
					
					$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'user_id'=>$row->user_id,
					'title'=>$row->title,
					'description'=>$row->description,
					'category' => $row->category,
					'sub_category' => $row->sub_category,
					'skills' => $row->skills,
					'environment'=>$row->environment,
					'project_type'=>$row->project_type,
					'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'post_date'=>$row->post_date,
					'expiry_date'=>$row->expiry_date,
					'user_country'=>$row->user_country,
					'user_city'=>$row->user_city,
					'user'=>$this->getUser($row->user_id)
					);
					
				}
				
				
			}
			else if($row->visibility_mode=="Public"){ 
				$data[]=array(
				'id'=>$row->id,
				'project_id'=>$row->project_id,
				'user_id'=>$row->user_id,
				'title'=>$row->title,
				'description'=>$row->description,
				'category' => $row->category,
				'sub_category' => $row->sub_category,
				'skills' => $row->skills,
				'environment'=>$row->environment,
				'project_type'=>$row->project_type,
							'visibility_mode' =>$row->visibility_mode,    
				'buget_min'=>$row->buget_min,
				'buget_max'=>$row->buget_max,
				'featured'=>$row->featured,
				'post_date'=>$row->post_date,
				'expiry_date'=>$row->expiry_date,
				'user_country'=>$row->user_country,
				'user_city'=>$row->user_city,
				'user'=>$this->getUser($row->user_id)
				);
			}
		}
		return $data;
	}
	public function countFilerjob($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid)
   {
		$this->db->select();
		if($cat!='All')
		{
			$category=explode("-",$cat);
			
			$this->db->where_in('category',$category);				
		}
		if($ptype!='All')
		{
				$this->db->where('project_type',$ptype);	
		}
		if($minb>0)
		{
			$this->db->where('buget_min >=',$minb);
		}
		if($maxb > 0)
		{
			$this->db->where('buget_max <=',$maxb);
		}
		if($post_with!='All')
		{
			$newdate=date('Y-m-d',strtotime("-".$post_with." day",strtotime(date('Y-m-d'))));
			$this->db->where('post_date >=',$newdate);
		}
		if($country!='All')
		{
			$this->db->where('user_country',$country);
		}
		if($city!='All')
		{
			$this->db->where('user_city',$city);
		}
		if($featured!='All')
		{
			$this->db->where('featured',$featured);
		}
		if($environment!='All')
		{
			$this->db->where('environment',$environment);
		}
		if($uid > 0)
		{
			$this->db->where('user_id',$uid);
		}
		// set this to false so that _protect_identifiers skips escaping:
		$this->db->_protect_identifiers = FALSE;
		
		// your order_by line:
		$this -> db -> order_by("FIELD ( serv_projects.featured, 'N', 'Y')",'DESC');
		
		// important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
		$this->db->_protect_identifiers = TRUE;
		$rs=$this->db->get_where('projects',array('status'=>'O','project_status'=>'Y'));
		
		
		return $rs->num_rows();
	}
	
	public function getCountry()
	{
		$this->db->select('name');
		$this->db->order_by('name');
		$res=$this->db->get('countries');
		$data=array();
		foreach($res->result() as $row)
		{
			$data[]=array(
			'name'=>$row->name
			);
		}
		return $data;
	}
}