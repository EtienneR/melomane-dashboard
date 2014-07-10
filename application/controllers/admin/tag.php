<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_content', 'model_category', 'model_tag'));
		$this->load->library(array('admin/functions', 'session'));
		$this->load->helper(array('form', 'functions', 'text'));
		define('URL_LAYOUT'      , 'admin/view_dashboard');
		define('URL_HOME_CONTENT', 'admin/content');
		define('URL_HOME_TAG', 'admin/tag');
		session_start();
		if (isset($_GET["profiler"])):
			$this->output->enable_profiler(TRUE);
		endif;
	}

	// Display all tags
	public function index()
	{
		if ($this->functions->get_loged()):

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$data['page']  = 'tag';
			$data['title'] = 'Tous les tags';

			$data['query'] = $data['tags'];

			$this->load->view(URL_LAYOUT, $data);
		endif;
	}

	// Add or edit a tag
	public function edit($id_tag = '')
	{
		if ($this->functions->get_loged()):

			$this->load->library('form_validation');

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$this->form_validation->set_rules('name_tag', 'Nom', 'trim|required|callback_check_tag_name');
			$name_tag = $this->input->post('name_tag');

			// Add a tag
			if ($this->uri->total_segments() == 3):
				$data['page']  = 'add_tag';
				$data['title'] = 'Ajouter un tag';

				if ($this->form_validation->run() !== FALSE):
					$this->model_tag->create_tag($name_tag);
					$this->session->set_flashdata('success', 'Tag "' . $name_tag . '" ajouté');
					redirect(base_url(URL_HOME_TAG));
				endif;

			else:
				$get_content = $this->model_tag->get_tag($id_tag, '');

				// Tag exists
				if ($get_content->num_rows() == 1):
					$data['page']  	  = 'edit_tag';
					$data['content']  = $this->model_content->get_content_by_tag($id_tag);
					$row 			  = $get_content->row();
					$data['name_tag'] = $row->name_tag;
					$data['title'] 	  = 'Modifier le tag <em>' . $data['name_tag'] . '</em>';

					if ($this->form_validation->run() !== FALSE):
						$this->model_tag->update_tag($name_tag, $id_tag);
						$this->session->set_flashdata('success', 'Tag "' . $name_tag . '" modifiée.');
						redirect(base_url(URL_HOME_TAG));
					endif;

				// Tag unknown 
				else:
					$this->session->set_flashdata('alert', 'Cet tag n\'existe pas ou n\'a jamais existé.');
					redirect(URL_HOME_TAG);
				endif;

			endif;

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}


	// Check if a tag already exists
	public function check_tag_name($name_tag)
	{
		$id_tag = $this->uri->segment(4);

		if ($this->model_tag->check_name($id_tag, $name_tag)->num_rows() == 1):
			$this->form_validation->set_message('check_tag_name', 'Impossible de rajouter le tag "' . $name_tag . '" car cet dernier existe déjà.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}

	// Delete a tag
	public function delete($id_tag)
	{
		if ($this->functions->get_loged()):
			// Category exists
			if ($this->model_tag->get_tag($id_tag)->num_rows() == 1):

				// No content attached to this tag
				if ($this->model_content->get_content_by_tag($id_tag)->num_rows() == 0):
					$this->model_tag->delete_tag($id_tag);
					$this->session->set_flashdata('success', 'Tag supprimé.');
				// Content(s) attached to this tag
				else:
					$this->session->set_flashdata('alert', 'Impossible de supprimer ce tag car il y a un ou plusieurs article(s) rattaché(s). <a href="' . base_url(URL_HOME_TAG . '/edit/' . $id_tag) . '">Afficher</a>');
				endif;

			// Tag unknown
			else:
				$this->session->set_flashdata('alert', 'Ce tag n\'existe pas ou n\'a jamais existé.');
			endif;

			redirect(base_url(URL_HOME_TAG));

		endif;
	}

}


/* End of file tag.php */
/* Location: ./application/controllers/admin/tag.php */