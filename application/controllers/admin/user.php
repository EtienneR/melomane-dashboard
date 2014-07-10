<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_category', 'model_content', 'model_tag', 'model_user'));
		$this->load->library(array('form_validation', 'session', 'admin/functions'));
		$this->load->helper(array('form', 'functions', 'text'));
		define('URL_LAYOUT'		 , 'admin/view_dashboard');
		define('URL_HOME_RUBRIC' , 'admin/rubric');
		define('URL_HOME_USERS'  , 'admin/user');
		session_start();
		if (isset($_GET["profiler"])):
			$this->output->enable_profiler(TRUE);
		endif;
	}

	// Display all users
	public function index()
	{
		if ($this->functions->get_loged()):
			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			$data['page']  = 'users';
			$data['title'] = 'Tous les utilisateurs';

			$users = $data['query'] = $this->functions->get_all_user();

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

	// Add or edit an user
	public function edit($id_user = '')
	{
		if ($this->functions->get_loged()):
			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();

			// If user with "admin" level
			if ($data['user_data']['level'] == 0):

				$this->form_validation->set_rules('level_user', 'Level', 'required');
				$this->form_validation->set_rules('pseudo_user', 'Login', 'trim|required|callback_check_user');
				$this->form_validation->set_rules('email_user', 'Email', 'trim|required|valid_email|callback_check_email');

				$pseudo_user = $this->input->post('pseudo_user');
				$level_user  = $this->input->post('level_user');
				$email_user  = $this->input->post('email_user');

				// Add an user
				if ($this->uri->total_segments() == 3):
					$this->form_validation->set_rules('password_user', 'Pass', 'trim|required');

					$password_user  = $this->input->post('password_user');
					$data['page']  = 'add_user';
					$data['title'] = 'Ajouter un utilisateur';

					if ($this->form_validation->run() !== FALSE):
						$this->model_user->create_user($pseudo_user, $password_user, $email_user, $level_user);
						$this->session->set_flashdata('success', 'Utilisateur ou utilisatrice "' . $pseudo_user . '" ajouté(e)');
						redirect(base_url(URL_HOME_USERS));
					endif;

				// Edit an user
				else:
					$data['page']		 = 'edit_user';
					$row 				 = $this->model_user->get_user($id_user, '')->row();
					$data['pseudo_user'] = $row->pseudo_user;
					$data['email_user']  = $row->email_user;
					$data['level_user']  = $row->level_user;
					$data['title']		 = 'Modifier l\'utilisateur ' . $data['pseudo_user'];

					if ($this->form_validation->run() !== FALSE):
						$this->model_user->update_user($pseudo_user, $email_user, $level_user, $id_user);
						$this->session->set_flashdata('success', 'Utilisateur ou utilisatrice "' . $pseudo_user . '" modifié(e) (les paramètres prendront effet lors de la prochaine connexion).');
						redirect(base_url(URL_HOME_USERS));
					endif;

				endif;

				$this->load->view(URL_LAYOUT, $data);

			else:
				$this->session->set_flashdata('alert', 'Vous ne disposez pas des droits nécessaires pour accèder à cette partie.');
				redirect(base_url(URL_HOME_USERS));
			endif;

		endif;
	}

	// Check if an user already exists
	public function check_user($pseudo_user)
	{
		$id_user = $this->uri->segment(4);

		if ($this->model_user->check_user($id_user, $pseudo_user)->num_rows() == 1):
			$this->form_validation->set_message('check_user', 'Impossible de rajouter ou de modifier l\'utilisateur "' . $pseudo_user . '" car ce dernier existe déjà.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}

	// Check if the user email already exists (/!\ manque $id_user pour user existant /!\)
	public function check_email($email_user)
	{
		if ($this->model_user->check_email($email_user)->num_rows() == 1):
			$this->form_validation->set_message('check_email', 'Impossible de rajouter ou de modifier l\'utilisateur avec l\'email "' . $email_user . '" car cette adresse email existe déjà.');
			return FALSE;
		else:
			return TRUE;
		endif;	
	}

	// Delete an user
	public function delete($id_user)
	{
		if ($this->functions->get_loged()):

			// If the user with "admin" level
			if ($this->functions->get_user_level() == 0):

				// If user exists
				if ($this->model_user->get_user($id_user)->num_rows() == 1):
					$this->model_user->delete_user($id_user);
					$this->session->set_flashdata('success', 'Utilisateur ou utilisatrice supprimé(e).');
				else:
					$this->session->set_flashdata('alert', 'Cette utilisateur n\'existe pas ou n\'a jamais existé.');
				endif;

				redirect(base_url(URL_HOME_USERS));

			else:
				$this->session->set_flashdata('alert', 'Vous ne disposez pas des droits nécessaires pour accèder à cette partie.');
				redirect(base_url(URL_HOME_USERS));
			endif;

		endif;
	}

	// Changing his own password
	public function change_password()
	{
		if ($this->functions->get_loged()):
			$data['user_data']  = $this->functions->get_user_data();
			$data['categories']	= $this->functions->get_all_categories();
			$data['tags']		= $this->functions->get_all_tags();
			$id_user = $data['user_data']['id_user'];

			$data['page']  = 'change_password';
			$data['title'] = 'Changer mon mot de passe';

			$u_old_pass		 = $this->input->post('u_old_pass');
			$password_user   = $this->input->post('password_user');
			$password_user_2 = $this->input->post('password_user_2');

			$params = "{$u_old_pass},{$password_user},{$password_user_2}";

			$this->form_validation->set_rules('u_old_pass', 'Ancien password', 'trim|required|callback_check_password');
			$this->form_validation->set_rules('password_user', 'Nouveau password', 'trim|required');
			$this->form_validation->set_rules("password_user_2", "Nouveau password (confirmation)", "trim|required|callback_check_confirm[{$params}]");

			if ($this->form_validation->run() !== FALSE):
				$this->model_user->update_password_user($password_user, $id_user);
				$this->session->set_flashdata('success', 'Votre mot de passe a bien été validé et marchera à la première reconnexion.');
				redirect(base_url(URL_HOME_USERS));
			endif;

			$this->load->view(URL_LAYOUT, $data);

		endif;
	}

	// Check the user password
	public function check_password($u_old_pass)
	{
		$id_user = $this->functions->get_user_id();

		if ($this->model_user->check_user_password($id_user, $u_old_pass)->num_rows() == 0):
			$this->form_validation->set_message('check_password', 'L\'ancien mot de passe n\'est pas bon.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}

	// Check if : the new password is different from the old ; and if : both new passwords are same
	public function check_confirm($null, $params = '')
	{
		list($u_old_pass, $u_new_pass, $u_new_pass_2) = explode(',', $params);

		if ($u_old_pass == $u_new_pass):
			$this->form_validation->set_message('check_confirm', 'Le nouveau mot de passe est identique à l\'ancien.');
			return false;
		elseif ($u_new_pass !== $u_new_pass_2):
			$this->form_validation->set_message('check_confirm', 'Les 2 nouveaux mots de passe ne correspondent pas');
			return false;
		else:
			return true;
		endif;
	}

	// Display all contents from one user
	public function author($id_user = '')
	{
		if ($this->functions->get_loged() and !empty($id_user)):

			$user = $this->model_user->get_user($id_user, '');

			if ($user->num_rows() == 1): 
				$data['user_data']  = $this->functions->get_user_data();
				$data['categories']	= $this->functions->get_all_categories();
				$data['tags']		= $this->functions->get_all_tags();

				$user = $user->row()->pseudo_user;

				$data['page'] = 'author';
				if ($data['user_data']['id_user'] == $id_user):
					$data['title'] = 'Tous mes musiques';
				else:
					$data['title'] = 'Tous les musiques de <em>' . $user . '</em>';
				endif;

				$data['query'] = $this->model_content->get_content_by_user($id_user, '');

				$this->load->view(URL_LAYOUT, $data);

			else:
				$this->session->set_flashdata('alert', 'Cette auteur n\'existe pour ou n\'a jamais existé');
				redirect(base_url(URL_HOME_USERS));
			endif;

		endif;
	}

}


/* End of file user.php */
/* Location: ./application/controllers/admin/user.php */