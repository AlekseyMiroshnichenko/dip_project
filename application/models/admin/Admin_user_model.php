<?php

class Admin_user_model extends CI_Model {

	public function get_users(){
		$result = $this->db->select('
									u.id,
									u.role,
									u.name,
									u.surname,
									u.email,
									u.password,
									u.phone,
									u.status,
									ur.role_name
								')
							->from('users u')
							->join('users_role ur','u.role = ur.id','left')
							->order_by('u.status','desc')
							->order_by('u.id','desc')
							->get()
							->result();
		return $result;
	}

	public function get_users_log($date){
		$result = $this->db->select('
									name,
									surname,
									date_time,
									INET_NTOA(user_ip) as user_ip
								')
							->from('users_log')
							->join('users','users_log.user_id = users.id','left')
							->where('DATE(date_time)',$date)
							->order_by('date_time','desc')
							->get()
							->result();
		return $result;
		
	}

	public function get_roles(){
		$result = $this->db->get('users_role')->result();
		return $result;
	}

	public function is_email_exist($email){
		$num_rows = $this->db->get_where('users',array('email'=>$email))->num_rows();
		if($num_rows == 0)
			return 'false';
		else
			return 'true';
	}

	public function add_user($data){
		$to_db = $this->make_user_info_arr($data);
		$this->db->insert('users', $to_db);
	}

	public function edit_user($data){
		$to_db = $this->make_user_info_arr($data);
		$this->db->where('id',$to_db['id']);
		$this->db->update('users', $to_db);
	}

	private function make_user_info_arr($data){
		$data['passhash'] = $this->user_model->getMD5($data['password']);
		return $data;
	}

	public function block_user($id){
		$this->db->set('status','0');
		$this->db->where('id',$id);
		$this->db->update('users');
	}

	public function unblock_user($id){
		$this->db->set('status','1');
		$this->db->where('id',$id);
		$this->db->update('users');
	}
}