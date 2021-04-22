<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Jobfeed_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }


	
	public function getFavouriteproject(){
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$result = $this->db->select('object_id')->from('favorite')->where(array('type' => 'JOB', 'user_id' => $user_id))->get()->result_array();
		$fav = array();
		if(count($result) > 0){
			foreach($result as $k => $v){
				$fav[] = $v['object_id'];
			}
		}
		return $fav;
		
	}
	
   public function getProjects($limit = '', $start = ''){
	   $data=array();
	$user=$this->session->userdata('user');
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
	
 
   		$this->db->select("*");

		// set this to false so that _protect_identifiers skips escaping:

		$this->db->_protect_identifiers = FALSE;

		

		// your order_by line:

		$this -> db -> order_by("FIELD ( serv_projects.featured, 'N', 'Y')",'DESC');

		

		// important to set this back to TRUE or ALL of your queries from now on will be non-escaped:

		$this->db->_protect_identifiers = TRUE;
		

		
		$this->db->where($wh." !=", 0);
                

                

		$this->db->limit($limit, $start);

		$rs=$this->db->get_where('projects',array('status'=>'O','project_status'=>'Y'));

		//echo $this->db->last_query();die();

		
            //  echo $this->db->last_query();

		foreach($rs->result() as $row){
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
}  
		return $data;

   }

   public function getSearchProjects($cat,$category,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid)

   {
$user=$this->session->userdata('user');
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
   		$this->db->select();
$this->db->where($wh." !=", 0);
		if($category!='All')

		{
$wh="FIND_IN_SET('".strtolower($category)."',LOWER(skills))";
			/*$cate=explode("-",$category);

			$this->db->where_in('category',$cate);	*/
$this->db->where($wh." !=", 0);
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
$wh="FIND_IN_SET('".strtolower($cat)."',LOWER(skills))";
			//$category=explode("-",$cat);

			//$this->db->where_in('category',$category);	
			
$this->db->where($wh." !=", 0);
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
$wh="FIND_IN_SET('".strtolower($cat)."',LOWER(skills))";
$this->db->where($wh." !=", 0);
			/*$category=explode("-",$cat);

			

			$this->db->where_in('category',$category);	*/			

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