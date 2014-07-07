<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_content', 'model_category','model_tag'));
		$this->load->library(array('admin/functions', 'session'));
		$this->load->helper(array('form', 'functions', 'text'));
		define('URL_LAYOUT'      , 'admin/view_dashboard');
		define('URL_HOME_CONTENT', 'admin/content');
		define('URL_HOME_CATEGORY', 'admin/category');
		session_start();
		if (isset($_GET["profiler"])):
			$this->output->enable_profiler(TRUE);
		endif;
	}

	// Display all categories
	public function index()
	{
		if ($this->functions->get_loged()):

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$data['page']  = 'categories';
			$data['title'] = 'Toutes les catégories';

			$data['query'] = $this->functions->get_all_categories();

			$this->load->view(URL_LAYOUT, $data);
		endif;
	}

	// Add or edit a category
	public function edit($id_category = '')
	{
		if ($this->functions->get_loged()):

			$this->load->library('form_validation');

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$this->form_validation->set_rules('title_category', 'Titre', 'trim|required|callback_check_category_title');
			$this->form_validation->set_rules('description_category', 'Description', 'trim|required');

			$title_category		  = $this->input->post('title_category');
			$description_category = $this->input->post('description_category');

			// Add a category
			if ($this->uri->total_segments() == 3):
				$data['page']  = 'add_category';
				$data['title'] = 'Ajouter une catégorie';

				if ($this->form_validation->run() !== FALSE):
					$this->model_category->create_category($title_category, $description_category);
					$this->session->set_flashdata('success', 'Catégorie "' . $title_category . '" ajoutée');
					redirect(base_url(URL_HOME_CATEGORY));
				endif;

			else:
				$get_content = $this->model_category->get_category($id_category, '');

				// Category exists
				if ($get_content->num_rows() == 1):
					$data['page']  		   		  = 'edit_category';
					$data['content']			  = $this->model_content->get_content_by_category($id_category);
					$row 						  = $get_content->row();
					$data['title_category']	   	  = $row->title_category;
					$data['description_category'] = $row->description_category;
					$data['title'] 		   		  = 'Modifier la catégorie <em>' . $data['title_category'] . '</em>';

					if($this->form_validation->run() !== FALSE):
						$this->model_category->update_category($title_category, $description_category, $id_category);
						$this->session->set_flashdata('success', 'Catégorie "' . $title_category . '" modifiée.');
						redirect(base_url(URL_HOME_CATEGORY));
					endif;

				// Category unknown 
				else:
					$this->session->set_flashdata('alert', 'Cette catégorie n\'existe pas ou n\'a jamais existé.');
					redirect(URL_HOME_CATEGORY);
				endif;

			endif;

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}


	// Check if a category already exists
	public function check_category_title($title_category)
	{
		$id_category = $this->uri->segment(4);

		if ($this->model_category->check_title($id_category, $title_category)->num_rows() == 1):
			$this->form_validation->set_message('check_category_title', 'Impossible de rajouter la catégorie "' . $title_category . '" car cette dernière existe déjà.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}

	// Delete a category
	public function delete($id_category)
	{
		if ($this->functions->get_loged()):
			// Category exists
			if ($this->model_category->get_category($id_category)->num_rows() == 1):

				// No content attached to this category
				if ($this->model_content->get_content_by_category($id_category)->num_rows() == 0):
					$this->model_category->delete_category($id_category);
					$this->session->set_flashdata('success', 'Catégorie supprimée.');
				// Content(s) attached to this category
				else:
					$this->session->set_flashdata('alert', 'Impossible de supprimer cette catégorie car il y a un ou plusieurs article(s) rattaché(s). <a href="' . base_url(URL_HOME_CONTENT . '/edit_category/' . $id_category) . '">Afficher</a>');
				endif;

			// Category unknown
			else:
				$this->session->set_flashdata('alert', 'Cette catégorie n\'existe pas ou n\'a jamais existé.');
			endif;

			redirect(base_url(URL_HOME_CATEGORY));

		endif;
	}

}


/* End of file category.php */
/* Location: ./application/controllers/admin/category.php */