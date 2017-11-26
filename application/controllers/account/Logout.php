<?php

class Logout extends CI_Controller {
	
	public function index(){
		
		$this->load->model("login_model");
		$this->login_model->logout();
		redirect(base_url());
		
	}
	
}
