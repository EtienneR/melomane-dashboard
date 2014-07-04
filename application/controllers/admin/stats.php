<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_category', 'model_content', 'model_user', 'model_stats'));
		$this->load->library(array('admin/functions', 'session'));
		$this->load->helper(array('form', 'functions', 'text'));
		define('URL_LAYOUT'      , 'admin/view_dashboard');
		session_start();
		if (isset($_GET["profiler"])):
			$this->output->enable_profiler(TRUE);
		endif;
	}

	public function index()
	{
		if ($this->functions->get_loged()):

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();
			$data['playlists']  = $this->model_stats->get_playlists();
			$data['users']		= $this->model_user->get_users();

			$data['playlist_user_distinct'] = $this->model_stats->get_distinct_playlist_user()->num_rows();

			$data['no_playlist']	  = $data['users']->num_rows -  $data['playlist_user_distinct'];
			$data['playlist_songs']	  = $this->model_stats->get_playlist_songs();
			$data['favorites']		  = $this->model_stats->get_favorites();
			$data['no_playlist_song'] = $this->model_stats->get_songs();

			$data['page']  = 'stats';
			$data['title'] = 'Statistiques';
			$data['query'] = $this->functions->get_all_content();

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}
}


/* End of file stats.php */
/* Location: ./application/controllers/admin/stats.php */