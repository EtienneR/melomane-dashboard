<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_category', 'model_content', 'model_news', 'model_tag', 'model_user'));
		$this->load->library(array('admin/functions', 'session'));
		$this->load->helper(array('form', 'functions', 'text'));
		define('URL_LAYOUT'   , 'admin/view_dashboard');
		define('URL_HOME_NEWS', 'admin/news');
		session_start();
		if (isset($_GET["profiler"])):
			$this->output->enable_profiler(TRUE);
		endif;
	}

	// Display all news
	public function index()
	{
		if ($this->functions->get_loged()):

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$data['page']  = 'news';
			$data['title'] = 'Toutes les news';

			$data['query'] = $this->model_news->get_all_news();

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

	// Add or edit a category
	public function edit($id_news = '')
	{
		if ($this->functions->get_loged()):

			$this->load->library('form_validation');

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$this->form_validation->set_rules('title_news', 'Titre', 'trim|required|callback_check_news_title');
			$this->form_validation->set_rules('content_news', 'Description', 'trim|required');
			$this->form_validation->set_rules('state_news', 'Etat', 'required');

			$title_news   = $this->input->post('title_news');
			$content_news = $this->input->post('content_news');
			$state_news	  = $this->input->post('state_news');

			// Add a new
			if ($this->uri->total_segments() == 3):
				$data['page']  = 'add_news';
				$data['title'] = 'Ajouter une news';

				$data['news'] = $this->model_news->get_all_news();

				$data['user_data'] = $this->functions->get_user_data();
				$id_user = $data['user_data']['id_user'];

				if ($this->form_validation->run() !== FALSE):
					$this->model_news->create_news($title_news, $content_news, $state_news, $id_user);
					$this->session->set_flashdata('success', 'News "' . $title_news . '" ajoutée');
					redirect(base_url(URL_HOME_NEWS));
				endif;

			else:
				$data['others_news'] = $this->model_news->get_others_news($id_news);
				$get_content = $this->model_news->get_news($id_news);

				// News exists
				if ($get_content->num_rows() == 1):
					$data['page']		  = 'edit_news';
					$row 				  = $get_content->row();
					$data['title_news']	  = $row->title_news;
					$data['content_news'] = $row->content_news;
					$data['state_news']   = $row->state_news;
					$data['cdate_news']   = $row->cdate_news;
					$data['udate_news']   = $row->udate_news;
					$data['title']		  = 'Modifier la news <em>' . $data['title_news'] . '</em>';

					if($this->form_validation->run() !== FALSE):
						$this->model_news->update_news($title_news, $content_news, $state_news, $id_news);
						$this->session->set_flashdata('success', 'News "' . $title_news . '" modifiée.');
						redirect(base_url(URL_HOME_NEWS));
					endif;

				// Category unknown 
				else:
					$this->session->set_flashdata('alert', 'Cette news n\'existe pas ou n\'a jamais existé.');
					redirect(URL_HOME_NEWS);
				endif;

			endif;

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

	// Display the news preview
	public function preview($id_news = '')
	{
		if ($this->functions->get_loged()):

			$get_content = $this->model_news->get_news($id_news);

			// If new exist
			if ($get_content->num_rows() == 1):
				echo 'preview'.$id_news;
			else:
				$this->session->set_flashdata('alert', 'Cette news n\'existe pas ou n\'a jamais existé.');
				redirect(URL_HOME_NEWS);
			endif;

		endif;
	}

	// Check if a news already exists
	public function check_news_title($title_news)
	{
		$id_news = $this->uri->segment(4);

		if ($this->model_news->check_title($id_news, $title_news)->num_rows() == 1):
			$this->form_validation->set_message('check_news_title', 'Impossible de rajouter la news "' . $title_news . '" car cette dernière existe déjà.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}

	// Delete a news
	public function delete($id_news)
	{
		if ($this->functions->get_loged()):

			// News exists
			if ($this->model_news->get_news($id_news)->num_rows() == 1):
				$this->model_news->delete_news($id_news);
				$this->session->set_flashdata('success', 'News supprimée.');

			// News unknown
			else:
				$this->session->set_flashdata('alert', 'Cette news n\'existe pas ou n\'a jamais existé.');
			endif;

			redirect(base_url(URL_HOME_NEWS));

		endif;
	}

}


/* End of file news.php */
/* Location: ./application/controllers/admin/news.php */