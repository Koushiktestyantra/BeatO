<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
	}
	
	
     function profile($data)
	   {
			$data_array =array(
					'name'=>$this->input->post('name'),
					'gender'=>$this->input->post('gender'),
					'email'=>$this->input->post('email'),
					'city'=>$this->input->post('city'),
					'phone'=>$this->input->post('phone'),
					'experience'=>$this->input->post('experience'),
					'description'=>$this->input->post('description'),
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$query= $this->db->insert('profile',$data_array);
			
			return $query; 
	        
	    }

}
