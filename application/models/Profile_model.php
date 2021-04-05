<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
	}

	function get_profiles()
	{
		$this->db->select('*');
		$this->db->from('profile');
		$data = $this->db->get();
		return $data;
	} 

	function get_profile($id)
	{
		$this->db->select('*');
		$this->db->from('profile');
		$this->db->where('id',$id);
		$data = $this->db->get();
		return $data;
	} 

	function profile($data)
	{
		$query= $this->db->insert('profile',$data);
		return $query;
	}
	      

	function profileUpdate($data,$useid)
	{
		$this->db->where('id',$useid);
		$res = $this->db->update('profile',$data);  
		return $res;
	}

}
