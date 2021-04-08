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
		$query = $this->db->update('profile',$data);  
		return $query;
	}

	function education($data)
	{
		$query= $this->db->insert('education',$data);
		return $query;
	}
	
	function get_userdata($useid)
	{   
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id',$useid);
		$query = $this->db->get();
		return $query;		
	}

	function get_educationData($userid)
	{   
		$this->db->select('*');
		$this->db->from('education');
		$this->db->where('user_id',$userid);
		$query = $this->db->get();
		return $query;		
	}

	function educationUpdate($data, $userid)
	{   
		$this->db->where('user_id',$userid);
		$query = $this->db->update('education',$data);  
		return $query;		
	}

	function services($data)
	{
		$query= $this->db->insert('services',$data);
		return $query;
	}

	function get_services($userid)
	{   $this->db->select('*');
		$this->db->from('services');
		$this->db->where('user_id',$userid);
		$query = $this->db->get();
		return $query;		
	}

	function servicesUpdate($data,$useid)
	{
		$this->db->where('id',$useid);
		$query = $this->db->update('services',$data);  
		return $query;
	}

	function check_rewards($userid)
	{
		$this->db->select('*');
		$this->db->from('rewards');
		$this->db->where('user_id',$userid);
		$query = $this->db->get();		
		return $query->num_rows();
	}

	function rewards($data)
	{
		$query= $this->db->insert('rewards',$data);
		return $query;
	}

	function get_rewards($userid)
	{   $this->db->select('*');
		$this->db->from('rewards');
		$this->db->where('user_id',$userid);
		$query = $this->db->get();
		return $query;		
	}

	function rewardsUpdate($data,$useid)
	{
		$this->db->where('user_id',$useid);
		$query = $this->db->update('rewards',$data);  
		return $query;
	}	

}
