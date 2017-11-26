<?php

class Users extends CI_Controller {

    function __construct() {
    	parent::__construct();
        $this->load->model("admin/admin_user_model", "admin_u_model");
    }

	public function index()
	{
		$data['title'] = 'Співробітники';
		$data['roles'] = $this->admin_u_model->get_roles();

		$this->load->view('templates/head', $data);
		$this->load->view('pages/users/users');
		$this->load->view('templates/footer');
	}

	public function get_users(){
		$users = $this->admin_u_model->get_users();
		echo json_encode($users);
	}

	public function get_users_log(){
		$date = $this->input->get('date');
		$users_log = $this->admin_u_model->get_users_log($date);
		echo json_encode($users_log);
	}

	public function add_user(){
		$data = $this->input->post();
		$this->admin_u_model->add_user($data);
	}

	public function edit_user(){
		$data = $this->input->post();
		$this->admin_u_model->edit_user($data);
	}

	public function block_user(){
		$id = $this->input->post('id');
		$this->admin_u_model->block_user($id);
	}

	public function unblock_user(){
		$id = $this->input->post('id');
		$this->admin_u_model->unblock_user($id);
	}

	public function is_email_exist(){
		$email = $this->input->post('email');
		echo $this->admin_u_model->is_email_exist($email);
	}

	public function go_login_to_user($id){
		$query = $this->db->get_where("users", array("id" => $id));

        if($query->num_rows() == 0)
            show_404 ();
        else
        {
        	$this->load->model("login_model", "login");
            $row = $query->row();
            $this->login->goLogin($row->email, $row->password);
            redirect(base_url());
        }
	}

}
