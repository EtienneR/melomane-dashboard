<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_category', 'model_content', 'model_tag', 'model_user'));
		$this->load->library(array('admin/functions', 'form_validation', 'session'));
		$this->load->helper(array('file', 'form', 'functions', 'text'));
		define('URL_LAYOUT'      , 'admin/view_dashboard');
		define('URL_HOME_CONTENT', 'admin/content');
		session_start();

		if (isset($_GET["profiler"])):
			$this->output->enable_profiler(TRUE);
		endif;

		setLocale(LC_TIME, 'fr_FR', 'FRA');
		date_default_timezone_set('Europe/Berlin');
	}

	// Display all contents
	public function index()
	{
		if ($this->functions->get_loged()):

			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$data['page']  = 'home';
			$data['title'] = 'Toutes les musiques';
			$data['query'] = $this->functions->get_all_content();

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

	// Add or edit a content
	public function edit($id_song = '')
	{
		if ($this->functions->get_loged()):

			$data['user_data'] = $this->functions->get_user_data();
			$data['users']	   = $this->model_user->get_users();
			$data['images']	   = get_dir_file_info('./assets/img/bg/thumb', $top_level_only = FALSE);
			$data['authors']   = $this->model_content->get_authors();
			$data['tags']	   = $this->functions->get_all_tags();
			$data['categories']= $this->functions->get_all_categories();

			$this->form_validation->set_rules('id_soundcloud', 'ID Soundcloud', 'trim|required|numeric|callback_check_id_soundcloud');
			//$this->form_validation->set_rules('title_song', 'Titre', 'trim|required|callback_check_content');
			$this->form_validation->set_rules('title_song', 'Titre', 'trim|required');
			$this->form_validation->set_rules('artist_song', 'Artiste', 'trim|required');
			$this->form_validation->set_rules('punchline_song', 'Punchline', 'trim|required');
			$this->form_validation->set_rules('state_song', 'Etat', 'required');
			$this->form_validation->set_rules('tag_song', 'Tag');
			$this->form_validation->set_rules('category', 'Catégorie', 'required');
			$this->form_validation->set_rules('id_bg', 'Image de fond', 'required');

			$id_soundcloud	 = $this->input->post('id_soundcloud');
			$title_song		 = $this->input->post('title_song');
			$artist_song	 = $this->input->post('artist_song');
			$punchline_song  = $this->input->post('punchline_song');
			$vendor_song	 = $this->input->post('vendor_song');
			$state_song		 = $this->input->post('state_song');
			$cdate_song		 = $this->input->post('cdate_song');
			$tag_song		 = $this->input->post('tag_song');
			$id_soundcloud 	 = $this->input->post('id_soundcloud');
			$id_category	 = $this->input->post('category');
			$id_bg			 = $this->input->post('id_bg');
			$userfile		 = $this->input->get_post('userfile');

			$data['img_bg'] = $this->model_content->get_all_bg_image();

			$config['upload_path']	 = './assets/img/song/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']		 = '1024';
			$config['max_width']	 = '2048';
			$config['max_height']	 = '2048';

			$this->load->library('upload', $config);

			// Add a content
			if ($this->uri->total_segments() == 3):
				$data['page']  = 'add_content';
				$data['title'] = 'Ajouter une musique';

				$id_user = $data['user_data']['id_user'];

				if (!$this->upload->do_upload('image')):
					$error = array($this->upload->display_errors());
					$this->session->set_flashdata('alert', strip_tags($error['0'], 'p'));

				elseif ($this->form_validation->run() !== FALSE):

					// BEGIN SOUNDCLOUD API
					if (!empty($id_soundcloud)):
						$ch = file_get_contents('http://api.soundcloud.com/tracks/'. $id_soundcloud .'.json?client_id=f944e2e1605cbe1de67e7b3c54b3a808');
						$obj = json_decode($ch);
						$url_soundcloud 	 = $obj->{'permalink_url'};
						$duration_soundcloud = $obj->{'duration'};
					endif;

					// END SOUNDCLOUD API



/*					if (empty($cdate_song)):
						echo 'vide';
					else:
						var_dump($cdate_song);
					endif;
					die;*/
					$upload_data = $this->upload->data();
					// Resize image
					$config['image_library']  = 'gd2';
					$config['source_image']	  = $upload_data["full_path"];
					$config['create_thumb']	  = FALSE;
					$config['new_image']	  = './assets/img/song/thumb/';
					$config['maintain_ratio'] = TRUE;
					$config['width']		  = 150;
					$config['height']		  = 150;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$image_song = $upload_data['file_name'];


					if (empty($cdate_song)):
						$cdate_song = unix_to_human(now(), TRUE, 'eu');
					endif;

					$this->model_content->create_content($id_user, $title_song, $artist_song, $punchline_song, $image_song, $vendor_song, $state_song, $cdate_song, $id_soundcloud, $url_soundcloud, $duration_soundcloud, $id_category, $id_bg);

					// For tags
					$id_song = $this->db->insert_id();
					foreach ($tag_song as $row):
						$tags = array(
							'fk_id_song' => $id_song,
							'fk_id_tag'  => $row
						);
						$this->db->insert('m_songtags', $tags);
					endforeach;

					$this->session->set_flashdata('success', 'Musique "' . $title_song . '" ajoutée.');

					redirect(URL_HOME_CONTENT);

				endif;

			else:
				$get_content = $this->model_content->get_content($id_song, '');

				// Content exist
				if ($get_content->num_rows() == 1):
					$data['page'] = 'edit_content';

					$udate_song = (isset($_POST['udate_song']))?true:false;

					$row				   = $get_content->row();
					$data['id_song']	   = $row->id_song;
					$data['title_song']	   = $row->title_song;
					$data['artist_song']   = $row->artist_song;
					$data['punchline_song']= $row->punchline_song;
					$data['image_song']	   = $row->image_song;
					$data['vendor_song']	   = $row->vendor_song;
					$data['state_song']	   = $row->state_song;
					$data['id_soundcloud'] = $row->id_soundcloud;
					$data['id_category']   = $row->fk_id_category;
					$data['id_bg']		   = $row->fk_id_bg;
					$data['title']		   = 'Modifier la musique <em>' . $data['title_song'] . '</em>';

					if ($this->form_validation->run() !== FALSE):

						// BEGIN SOUNDCLOUD API
						if (!empty($data['id_soundcloud'])):
							$ch = file_get_contents('http://api.soundcloud.com/tracks/'. $id_soundcloud .'.json?client_id=f944e2e1605cbe1de67e7b3c54b3a808');
							$obj = json_decode($ch);
							$url_soundcloud 	 = $obj->{'permalink_url'};
							$duration_soundcloud = $obj->{'duration'};
						endif;
						// END SOUNDCLOUD API

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
								$config['new_image']	  = './assets/img/song/thumb/';
								$config['maintain_ratio'] = TRUE;
								$config['width']		  = 150;
								$config['height']		  = 150;
								$this->load->library('image_lib', $config);
								$this->image_lib->resize();
								$image_song = $upload_data['file_name'];
							endif;
						else:
							$image_song = $data['image_song'];
						endif;

						$this->model_content->update_content($title_song, $artist_song, $punchline_song, $image_song, $vendor_song, $state_song, $udate_song, $id_soundcloud, $url_soundcloud, $duration_soundcloud, $id_category, $id_bg, $id_song);

						// For tags
						$this->model_content->delete_content_songtags($id_song);
						foreach ($tag_song as $row):
							$tags = array(
								'fk_id_song' => $id_song,
								'fk_id_tag'  => $row
							);
							$this->db->insert('m_songtags', $tags);
						endforeach;

						$this->session->set_flashdata('success', 'Musique "' . $title_song . '" modifiée.');

						redirect(URL_HOME_CONTENT);

					endif;

				// Content unknown
				else:
					$this->session->set_flashdata('alert', 'Cette musique n\'existe pas ou n\'a jamais existé');
					redirect(URL_HOME_CONTENT);
				endif;

			endif;

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

/*	// Check if a content already exists
	public function check_content($title_song)
	{
		$c_id = $this->uri->segment(4);

		if ($this->model_content->check_title($c_id, $title_song)->num_rows() == 1):
			$this->form_validation->set_message('check_content', 'Impossible de rajouter la musique avec le titre "' . $title_song . '" car cette dernière existe déjà.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}*/

	// Check if a soundcloud id already exists
	public function check_id_soundcloud($id_soundcloud)
	{
		$c_id = $this->uri->segment(4);

		if ($this->model_content->check_id_soundcloud($c_id, $id_soundcloud)->num_rows() >= 1):
			$this->form_validation->set_message('check_id_soundcloud', 'Impossible de rajouter la musique avec cet id soundcloud "' . $id_soundcloud . '" car ce dernier existe déjà.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}


	// Delete a content
	public function delete($id = '')
	{
		if ($this->functions->get_loged()):

			// Content exists
			if ($this->model_content->get_content($id)->num_rows() == 1):
				// Delete the tag(s) association
				$this->model_content->delete_content_songtags($id);
				$this->model_content->delete_content($id);
				$this->session->set_flashdata('success', 'L\'article a bien été supprimé');
				redirect(base_url('admin'));

			// Content unknown 
			else:
				$this->session->set_flashdata('alert', 'Cette article n\'existe pour ou n\'a jamais existé');
				redirect(base_url(URL_HOME_CONTENT));
			endif;

		endif;
	}

	// Get music by category
	public function category()
	{
		if ($this->functions->get_loged()):
			$data['user_data'] = $this->functions->get_user_data();
			$data['tags']	   = $this->functions->get_all_tags();
			$data['categories']= $this->functions->get_all_categories();

			$category = $this->input->get('q');

			if (!empty($category)):
				$query = $this->model_content->get_contents_by_category($category);

				if ($query->num_rows > 0):
					$data['page']  = 'tags';
					$data['title'] = 'Catégorie <em>' . $category . '</em>';
					$data['query'] = $query;
					$this->load->view(URL_LAYOUT, $data);
				else:
					$this->session->set_flashdata('alert', 'Pas de musique avec cette catégorie "' . $category . '"');
					redirect(base_url(URL_HOME_CONTENT));
				endif;

			else:
				redirect(base_url(URL_HOME_CONTENT));
			endif;

		endif;
	}

	// Get music by tag
	public function tag()
	{
		if ($this->functions->get_loged()):
			$data['user_data']  = $this->functions->get_user_data();
			$data['tags']		= $this->functions->get_all_tags();
			$data['categories']	= $this->functions->get_all_categories();

			$tag = $this->input->get('q');
			
			if (!empty($tag)):
				$query = $this->model_content->get_contents_by_tag($tag);

				if ($query->num_rows > 0):
					$data['page']  = 'tags';
					$data['title'] = 'Tag <em>' . $tag . '</em>';
					$data['query'] = $query;
					$this->load->view(URL_LAYOUT, $data);
				else:
					$this->session->set_flashdata('alert', 'Pas de musique avec ce tag "' . $tag . '"');
					redirect(base_url(URL_HOME_CONTENT));
				endif;

			else:
				redirect(base_url(URL_HOME_CONTENT));
			endif;

		endif;
	}

	// Get music by artist
	public function artists()
	{
		if ($this->functions->get_loged()):
			$data['user_data']  = $this->functions->get_user_data();
			$data['tags']		= $this->functions->get_all_tags();
			$data['categories']	= $this->functions->get_all_categories();

			$artist = $this->input->get('q');
			
			if (!empty($artist)):
				$query = $this->model_content->get_contents_by_author($artist);

				if ($query->num_rows > 0):
					$data['page']  = 'artists';
					$data['title'] = 'Artiste <em>' . $artist . '</em>';
					$data['query'] = $query;
					$this->load->view(URL_LAYOUT, $data);
				else:
					$this->session->set_flashdata('alert', 'Pas de musique avec cette artiste "' . $artist . '"');
					redirect(base_url(URL_HOME_CONTENT));
				endif;

			else:
				redirect(base_url(URL_HOME_CONTENT));
			endif;

		endif;
	}

	public function preview($id_song)
	{
		if ($this->functions->get_loged()):

			$query = $this->model_content->get_content($id_song, '');

			// If song exists
			if ($query->num_rows() == 1):
				$data['query'] = $query->row();
				//var_dump($data['query']);
				$this->load->view('admin/dashboard/content/view_preview_content', $data);
			else:
				$this->session->set_flashdata('alert', 'Cette musique n\'existe pas ou n\'a jamais existé.');
				redirect(URL_HOME_CONTENT);
			endif;

		endif;
	}

}


/* End of file content.php */
/* Location: ./application/controllers/admin/content.php */