<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Knowledgebase_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

public function getKnowledgeTitle(){
	$this->db->select('id,name');
	$this->db->from('knowledge_type');
	$this->db->where('parent_id',0);
	$this->db->where('status','Y');
	$this->db->order_by('ord','asc');
	$rs = $this->db->get();
	
	$data =  array();
	foreach($rs->result() as $row)
	{
		$data[] = array(
		'id' => $row->id,
		'name' => $row->name,
		'sub_title' => $this->getQuestionAns($row->id)
		);
	}
	
		return $data;

}
	
	public function  getSubTitle($id){
		$this->db->select('id,name');
		$this->db->from('knowledge_type');
		$this->db->where('parent_id',$id);
		//$this->db->order_by('ord','asc');
		$rs = $this->db->get();
	
		$data =  array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'id' => $row->id,
				'sub_name' => $row->name,
				'answers' => $this->getQuestionAns($row->id)
				
			);
		}
		
		return $data;
	
	}
	
	
	public function getQuestionAns($id){
	
		$this->db->select('knowledge_type,title,content');
		$this->db->from('knowledge');
		$this->db->where('knowledge_type',$id);
		$this->db->where('status','Y');
		$this->db->order_by('order','asc');
		$rs = $this->db->get();
		
		$data =  array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'knowledge_type' => $row->knowledge_type,
				'title' => $row->title,
				'content' => $row->content
			);
		}
		
		return $data;
	
	}
	

}
