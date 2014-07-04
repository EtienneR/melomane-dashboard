<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_category', 'model_content', 'model_user'));
		$this->load->library(array('admin/functions', 'session'));
		$this->load->helper(array('form', 'functions', 'text'));
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

			$this->load->library('form_validation');
			$this->load->helper('file');
			$this->load->model('model_category');

			$data['user_data'] = $this->functions->get_user_data();
			$data['users']	   = $this->model_user->get_users();
			$data['images']	   = get_dir_file_info('./assets/img/thumb', $top_level_only = FALSE);
			$data['authors']   = $this->model_content->get_authors();
			$data['tags']	   = $this->functions->get_all_tags();
			$data['categories']= $this->functions->get_all_categories();

			$this->form_validation->set_rules('title_song', 'Titre', 'trim|required|callback_check_content');
			$this->form_validation->set_rules('author_song', 'Auteur', 'trim|required');
			$this->form_validation->set_rules('image_song', 'Image d\'illustration', 'trim');
			$this->form_validation->set_rules('state_song', 'Etat', 'required');
			//$this->form_validation->set_rules('tags_song', 'Tag', 'required');
			$this->form_validation->set_rules('category', 'Catégorie', 'required');

			$title_song	   = $this->input->post('title_song');
			$author_song   = $this->input->post('author_song');
			$image_song	   = $this->input->post('image_song');
			$state_song	   = $this->input->post('state_song');
			$cdate_song	   = $this->input->post('cdate_song');
			$tags_song	   = $this->input->post('tags_song'); // Tableau
			$id_soundcloud = $this->input->post('id_soundcloud');
			$id_category   = $this->input->post('category');

			// Add a content
			if ($this->uri->total_segments() == 3):
				$data['page']  = 'add_content';
				$data['title'] = 'Ajouter une musique';

				$get_tags = $this->model_content->get_tags()->result();
				$data['tags_json'] = json_encode($get_tags[0]->tag);

				$id_user = $data['user_data']['id_user'];

				// Récupération des tags cochés
				if (!empty($tag_song)):
					$tags_song = implode(';', $tag_song);
				endif;

				if ($this->form_validation->run() !== FALSE):
					if (empty($cdate_song)):
						$cdate_song = unix_to_human(now(), TRUE, 'eu');
					endif;
					$this->model_content->create_content($id_user, $title_song, $author_song, $image_song, $tags_song, $state_song, $cdate_song, $id_soundcloud, $id_category);
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
					$data['title_song']	   = $row->title_song;
					$data['author_song']   = $row->author_song;
					$data['image_song']	   = $row->image_song;
					$data['state_song']	   = $row->state_song;
					$data['tags_song']	   = $row->tag_song;
					$data['id_soundcloud'] = $row->id_soundcloud;
					$data['id_category']   = $row->category_id_category;
					$data['title']		   = 'Modifier la musique <em>' . $data['title_song'] . '</em>';

					if ($this->form_validation->run() !== FALSE):

						if (!empty($tags_song)):
							$tags_song = implode(';', $tags_song);
						endif;

						if ($data['title_song'] == $title_song 
							&& $data['author_song'] == $author_song
							&& $data['image_song'] == $image_song
							&& $data['state_song'] == $state_song
							&& $data['tags_song'] == $tags_song
							&& $data['id_soundcloud'] == $id_soundcloud
							&& $data['id_category'] == $id_category
							):

						else:

							$this->model_content->update_content($title_song, $author_song, $image_song, $tags_song, $state_song, $udate_song, $id_soundcloud, $id_category, $id_song);
							$this->session->set_flashdata('success', 'Musique "' . $title_song . '" modifiée.');
						endif;
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

	// Check if a content already exists
	public function check_content($title_song)
	{
		$c_id = $this->uri->segment(4);

		if ($this->model_content->check_title($c_id, $title_song)->num_rows() == 1):
			$this->form_validation->set_message('check_content', 'Impossible de rajouter la musique avec le titre "' . $title_song . '" car cette dernière existe déjà.');
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

	public function get_tags()
	{
		/*$get_tags = $this->model_content->get_tags()->result();
		$data['tags_json'] = json_encode($get_tags[0]->tag);*/

		header('Content-type: application/json');
		$data['tags_json'] = "tag_song,soul,corse,tag_song,soul,rap,rap,blues,rap,celtic,corse";

		echo json_encode($data['tags_json']);
	}

/*	// Ajax request
	public function search()
	{
		if ($this->functions->get_loged()):
			$data['page'] = '';
			$request = $this->input->get('q');
			$data['query'] = $this->model_content->search_content($request);
			//var_dump($data['query']->result());
			$this->load->view('admin/dashboard/content/view_board_content', $data);
		endif;
	}*/

}


/* End of file content.php */
/* Location: ./application/controllers/admin/content.php */