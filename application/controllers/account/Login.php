<?php
class Login extends CI_Controller{

    public function index(){   
    	$this->load->model("login_model", "login");
   		
   		$email = $this->input->post("email");
   		$password = $this->input->post("password");

    	if($email == false || $password == false){
    		if($this->login->isLogin()){
    	 		redirect(base_url()."calculating");
	     	}else{
    	 		$this->load->view("pages/account/login");
    	 	}
    	}else{

    		$login = $this->login->goLogin( $email, $password);
    		if($login){
                redirect(base_url()."calculating");
    		}else{
    			redirect(base_url() ."login");
    		}
    	}
    }
    
}