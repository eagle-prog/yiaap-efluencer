<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site_options_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
 

    /* public function leftPannel() {
	     $result = array();
		 $this->db->select();
		 $query = $this->db->get_where("adminmenu", array("status" => 'Y', "parent_id" => 0));
		 $i = 0;
	     foreach ($query->result() as $row)
          {
		  $i++;
		     $result[$i]['id'] = $row->id;
             $result[$i]['name'] = $row->name;
			 $result[$i]['url'] = $row->url;
			 $result[$i]['parent_id'] = $row->parent_id;
			 $result[$i]['status'] = $row->status;
          }
		 return $result;
    }
	public function leftpanelchild($id) {	
		 $result = array();
		 $this->db->select();
		 $query = $this->db->get_where("adminmenu", array("status" => 'Y', "parent_id" => $id));
		 $i = 0;
	     foreach ($query->result() as $row)
          {
		  $i++;
		     $result[$i]['id'] = $row->id;
             $result[$i]['name'] = $row->name;
			 $result[$i]['url'] = $row->url;
			 $result[$i]['parent_id'] = $row->parent_id;
			 $result[$i]['status'] = $row->status;
          }
		 return $result;
	}*/
	
	////// ADD sitemap///////////////////////////////
	/* public function add_sitemap($data){
	 	return $this->db->insert('sitemap',$data);
	} */
	
	///// Edit sitemap ///////////////////////////////
	public function update_setting_option($post){
		$data = array(
               'setting_value' => $post['setting_value']);
		$this->db->where('option_id', $post['option_id']);
		return $this->db->update('setting_option', $data); 
		
	}
    /* public function record_count_sitemap() 
	{
        return $this->db->count_all('sitemap');
    } */
	

	//// Delete sitemap //////////////////////////////////
	/* public function delete_sitemap($id){
		return $this->db->delete('sitemap', array('id' => $id)); 
	} */
	

	/// Get setting_option list ////////////////////////////
	public function getsiteoptions(){
	    // $this->db->limit($limit,$start);
	    $this->db->where('is_editable', '1');
		$rs=$this->db->get('setting_option');
		
		$data = array();
		if($rs->num_rows>0){
			foreach ($rs->result() as $row){
				$data[]= array(
						'option_id' => $row->option_id,
						'setting_key' => $row->setting_key,
						'is_editable' => $row->is_editable,
						'setting_value' => $row->setting_value
						);
			}
			return $data;
		}
		return false;
	}
	

	
	
	
	public function getfield($select,$table,$feild,$value){
		$this->db->select($select);	
		$rs = $this->db->get_where($table,array($feild=>$value));
		 $data = '';
		 foreach ($rs->result() as $row){
		  $data = $row->$select;
		 }
		 return $data;
	}
	
	

}
