<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meloman extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('front/view_home');
	}

}


/* End of file meloman.php */
/* Location: ./application/controllers/front/meloman.php */