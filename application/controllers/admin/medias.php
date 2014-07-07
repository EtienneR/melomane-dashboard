<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medias extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_category', 'model_content', 'model_media', 'model_tag', 'model_user'));
		$this->load->library(array('admin/functions', 'form_validation', 'session'));
		$this->load->helper(array('file', 'form', 'functions', 'text'));
		define('URL_LAYOUT' , 'admin/view_dashboard');
		define('URL_HOME_MEDIAS' , 'admin/medias');
		session_start();
		if (isset($_GET["profiler"])):
			$this->output->enable_profiler(TRUE);
		endif;
	}

	// Display the gallery
	public function index()
	{
		if ($this->functions->get_loged()):
			$data['user_data']  = $this->functions->get_user_data();
			$data['tags']		= $this->functions->get_all_tags();
			$data['categories']	= $this->functions->get_all_categories();

			$data['page']  = 'gallery';
			$data['title'] = 'Galerie pour les background';

			$data['query'] = $this->model_media->get_all_medias();

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

	// Add or edit a bg
	public function edit($id_bg = '')
	{
		if ($this->functions->get_loged()):

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$this->form_validation->set_rules('tag_bg', 'Nom', 'trim|required');
			$tag_bg = $this->input->post('tag_bg');

			$config['upload_path']	 = './assets/img/bg/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']		 = '1024';
			$config['max_width']	 = '2048';
			$config['max_height']	 = '2048';

			$this->load->library('upload', $config);

			// Add a bg
			if ($this->uri->total_segments() == 3):
				$data['page']  = 'add_bg';
				$data['title'] = 'Ajouter un background';

				if (!$this->upload->do_upload('image')):
					$error = array($this->upload->display_errors());
					$this->session->set_flashdata('alert', strip_tags($error['0'], 'p'));

				elseif ($this->form_validation->run() !== FALSE):
					$upload_data = $this->upload->data();
					// Resize image
					$config['image_library']  = 'gd2';
					$config['source_image']	  = $upload_data["full_path"];
					$config['create_thumb']	  = FALSE;
					$config['new_image']	  = './assets/img/bg/thumb/';
					$config['maintain_ratio'] = TRUE;
					$config['width']		  = 150;
					$config['height']		  = 150;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$image_bg = $upload_data['file_name'];

					$this->model_media->create_bg($tag_bg, $image_bg);
					$this->session->set_flashdata('success', 'Tag "' . $tag_bg . '" ajouté');
					redirect(base_url(URL_HOME_MEDIAS));
				endif;

			else:
				$get_content = $this->model_media->get_media($id_bg);

				// bg exists
				if ($get_content->num_rows() == 1):
					$data['page']	  = 'edit_bg';
					$data['content']  = $this->model_content->get_content_by_bg($id_bg);
					$row 			  = $get_content->row();
					$data['tag_bg']   = $row->tag_bg;
					$data['image_bg'] = $row->image_bg;
					$data['title'] 	  = 'Modifier le background <em>' . $data['tag_bg'] . '</em>';

					if ($this->form_validation->run() !== FALSE):
						// If different image
						if (!empty($_FILES['image']['name']) && $_FILES['image']['name'] !== $data['image_bg']):

							if (!$this->upload->do_upload('image')):
								$error = array($this->upload->display_errors());
								$this->session->set_flashdata('alert', strip_tags($error['0'], 'p'));
						
							elseif ($this->upload->do_upload('image')):
								$upload_data = $this->upload->data();
								// Resize image
								$config['image_library']  = 'gd2';
								$config['source_image']	  = $upload_data["full_path"];
								$config['create_thumb']	  = FALSE;
								$config['new_image']	  = './assets/img/bg/thumb/';
								$config['maintain_ratio'] = TRUE;
								$config['width']		  = 150;
								$config['height']		  = 150;
								$this->load->library('image_lib', $config);
								$this->image_lib->resize();
								$image_bg = $upload_data['file_name'];
							endif;

						else:
							$image_bg = $data['image_bg'];
						endif;

						$this->model_media->update_media($tag_bg, $image_bg, $id_bg);
						$this->session->set_flashdata('success', 'Background "' . $tag_bg . '" modifié.');
						redirect(base_url(URL_HOME_MEDIAS));
					endif;

				// bg unknown 
				else:
					$this->session->set_flashdata('alert', 'Ce background n\'existe pas ou n\'a jamais existé.');
					redirect(URL_HOME_MEDIAS);
				endif;

			endif;

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

	// Upload treatment
	public function upload($error = array())
	{
		if ($this->functions->get_loged()):
			$config['upload_path']	 = './assets/img/bg/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']		 = '1024';

			$this->load->library('upload', $config);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tag_bg', 'tag_bg', 'required');
			$tag_bg	= $this->input->post('tag_bg');

			if (!$this->upload->do_upload() or $this->form_validation->run() == FALSE):
				$error = array($this->upload->display_errors());
				$this->session->set_flashdata('alert', strip_tags($error['0'], 'p'));
				redirect(base_url('admin/medias'));
			else:
				$upload_data = $this->upload->data();
				// Resize image
				$config['image_library']  = 'gd2';
				$config['source_image']   = $upload_data["full_path"];
				$config['create_thumb']   = FALSE;
				$config['new_image']	  = './assets/img/bg/thumb';
				$config['maintain_ratio'] = TRUE;
				$config['width']		  = 150;
				$config['height']		  = 150;
				$this->load->library('image_lib', $config);

				$this->image_lib->resize();

				$image_bg = $upload_data['file_name'];
				$this->model_media->create_bg($tag_bg, $image_bg);

				$this->session->set_flashdata('success', 'Image importée.');
				redirect(base_url('admin/medias'));
			endif;

		endif;
	}

	// Delete a background
	public function delete($id_bg)
	{
		if ($this->functions->get_loged()):
			// Category exists
			$data = $this->model_media->get_media($id_bg);
			if ($data->num_rows() == 1):

				// No content attached to this background
				if ($this->model_content->get_content_by_bg($id_bg)->num_rows() == 0):
					$this->model_media->delete_media($id_bg);
					// And delete images files
					$filename = $data->row()->image_bg;
					unlink('./assets/img/bg/thumb/' . $filename);
				    unlink('./assets/img/bg/' . $filename);
					$this->session->set_flashdata('success', 'Background supprimé.');
				// Content(s) attached to this background
				else:
					$this->session->set_flashdata('alert', 'Impossible de supprimer ce background car il y a un ou plusieurs article(s) rattaché(s). <a href="' . base_url(URL_HOME_MEDIAS . '/edit/' . $id_bg) . '">Afficher</a>');
				endif;

			// Background unknown
			else:
				$this->session->set_flashdata('alert', 'Ce background n\'existe pas ou n\'a jamais existé.');
			endif;

			redirect(base_url(URL_HOME_MEDIAS));

		endif;
	}


}


/* End of file medias.php */
/* Location: ./application/controllers/admin/medias.php */