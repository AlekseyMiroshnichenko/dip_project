<?php

class Home extends CI_Controller {

	public function index()
	{
		$data['title'] = "Дослідження термодинамічної стабільності рідких полімерних струменів";
		$this->load->view('templates/head', $data);
		$this->load->view('templates/footer');
	}
}
