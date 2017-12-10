<?php

class Calculate extends CI_Controller {

	function __construct() {
    	parent::__construct();
        $this->load->model("scientist/calculate_model", "calc_model");
    }

	public function index()
	{
		$data = $this->input->post();
		if($data['step'] == "step_1")
			echo "q = <span id='q'>". $this->calc_model->calculate($data) ."</span>";
		if($data['step'] == "step_2"){
			$result = $this->calc_model->calculate($data);
			echo "ꭙ = <span id='xi'>". $result['xi'] ."</span>; ρ = <span id='eta'>". $result['eta'] ."</span>";
		}
		if($data['step'] == "step_3"){
			echo "δ = <span id='sigma'>". $this->calc_model->calculate($data) ."</span>";
		}
	}
}
