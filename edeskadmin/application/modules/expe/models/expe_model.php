<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expe_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD MENU///////////////////////////////
    public function add_expe($data) {
        return $this->db->insert('experience_level', $data);
    }

    ///// Edit MENU ///////////////////////////////
    public function update_expe($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('experience_level', $data);
    }

    public function record_count_expe() {
        return $this->db->count_all('experience_level');
    }

    //// Delete Menu //////////////////////////////////
    public function delete_expe($id) {
        return $this->db->delete('experience_level', array('id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getexpeList($limit = '', $start = '') {
        $this->db->select('*');
        $this->db->order_by('id','desc');
        $this->db->limit($limit, $start);
        $rs = $this->db->get('experience_level');
        $data = array();

        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
				'name' => $row->name,
				'arb_name' => $row->arb_name,
				'description' => $row->description,
				'arb_description' => $row->arb_description,
                'status' => $row->status
            );
        }
        return $data;
    }
    
    /* public function get_all_position($type='')
    {
        $this->db->distinct();
        $this->db->select("position");
        $this->db->from("banner_type");
        if($type=="")
        {
            $this->db->where("type", $type);
        }
        $res = $this->db->get();
        $data = array();
        foreach ($res->result() as $row)
        {
            $position = $row->position;
            if ($position == 1)
                $position = 'Top';
            else if ($position == 2)
                $position = 'Left side';
            else if ($position == 3)
                $position = 'Right side';
            else if ($position == 4)
                $position = 'Bottom';
            else if ($position == 5)
                $position = 'Footer';
            
            $data[] = array(
                "pos_id" =>$row->position,
                "pos_val"=>$position
            );
        }
        return $data;
    }

    public function getbannertype() {
        $this->db->select('type');
        $this->db->group_by('type');
        $rs = $this->db->get('banner_type');

        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'type' => $row->type
            );
        }
        return $data;
    }

    public function get_banner_position($type) {
        $res = $this->db->select("position")->from("banner_type")->where("type", $type)->get();
        $data = array();
        foreach ($res->result() as $row) {
            $position = $row->position;
            if ($position == 1)
                $position = 'Top';
            else if ($position == 2)
                $position = 'Left side';
            else if ($position == 3)
                $position = 'Right side';
            else if ($position == 4)
                $position = 'Bottom';
            else if ($position == 5)
                $position = 'Footer';
            $data[] = array(
                'position_id' => $row->position,
                'position_val' => $position
            );
        }
        return $data;
    }

    public function getAllSearchData($usr_select, $search_element, $type) {
        $this->db->select('*');
        $this->db->like($usr_select, $search_element, 'none');
        $rs = $this->db->get_where('banner');
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'type' => $row->type,
                'image' => $row->image,
                'order' => $row->order,
                'status' => $row->status
            );
        }
        return $data;
    }

    public function updatebanner($data, $id) {
        if($data['status']=="Y")
        {
            $ban_det = $this->db->select("type, pos")->from("banner")->where("id", $id)->get()->row();
            $ban_end_date = $this->db->select("validity")->get_where("banner_type", array("type"=>$ban_det->type, "position"=> $ban_det->pos));
            $baned = $ban_end_date->row();
            $validity = $baned->validity;
            $startdate = date("Y-m-d");
            $enddate = date('Y-m-d', strtotime($startdate . "+".$validity." days"));
            $data['start_date'] = $startdate;
            $data['end_date'] = $enddate;
        }
        $this->db->where('id', $id);
        return $this->db->update('banner', $data);
    } */

}
