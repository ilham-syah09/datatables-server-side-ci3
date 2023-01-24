<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library('Datatables', 'datatables');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}


	public function ajax_list()
	{
		$list = $this->User_model->get_datatables();
		$data = array();
		$no = $this->input->post('start');
		//looping data mahasiswa
		foreach ($list as $data) {
			$no++;
			$row = array();
			//row pertama akan kita gunakan untuk btn edit dan delete
			$row[] = $data->name;
			$row[] = $data->position;
			$data[] = $row;
		}
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->User_model->count_all(),
			"recordsFiltered" => $this->User_model->count_filtered(),
			"data" => $data,
		);
		//output to json format
		$this->output->set_output(json_encode($output));
	}
}
