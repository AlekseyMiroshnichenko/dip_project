<?php

class Calculate extends CI_Controller {

	function __construct() {
    	parent::__construct();
        $this->load->model("scientist/calculate_model", "calc_model");
    }

	public function index()
	{
		$data = $this->input->post();
		$this->calc_model->calculate($data);
	}
}
