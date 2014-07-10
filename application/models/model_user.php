<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model {

	function login($login, $password)
	{
		$this->db->select('id_user, pseudo_user, password_user, email_user, level_user')
				 ->from('m_user')
				 ->where('pseudo_user', $login)
				 ->where('password_user', MD5($password))
				 ->where('level_user <> 3')
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function get_users()
	{
		$this->db->select('id_user, pseudo_user, password_user, email_user, level_user')
				 ->from('m_user')
				 ->order_by('id_user', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	function get_user($id_user, $pseudo_user)
	{
		$this->db->select('id_user, pseudo_user, email_user, password_user, level_user');
		$this->db->from('m_user');
		if (empty($pseudo_user)):
		$this->db->where('id_user', $id_user);
		else:
		$this->db->where('pseudo_user', $pseudo_user);
		endif;
		$this->db->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function check_user($id_user, $pseudo_user)
	{
		$this->db->select('pseudo_user')
				 ->from('m_user')
				 ->where('id_user <>', $id_user)
				 ->where('pseudo_user', $pseudo_user)
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function check_email($email_user)
	{
		$this->db->select('email_user')
				 ->from('m_user')
				 ->where('email_user', $email_user)
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function check_user_password($id_user, $u_old_pass)
	{
		$this->db->select('password_user')
				 ->from('m_user')
				 ->where('id_user', $id_user)
				 ->where('password_user', md5($u_old_pass))
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function reset_password($email_user, $new_pass)
	{
		$data = array(
			'password_user' => md5($new_pass)
		);

		$this->db->where('email_user', $email_user);
		$this->db->update('m_user', $data);
	}

	function get_songs_by_user($id_user)
	{
		$this->db->select('fk_id_user')
				 ->from('m_song')
				 ->where('fk_id_user', $id_user);

		$query = $this->db->get();
		return $query; 
	}

	function get_distinct_playlist_by_user($id_user)
	{
		$this->db->distinct()
				 ->select('fk_id_user')
				 ->from('m_playlist')
				 ->where('fk_id_user', $id_user);

		$query = $this->db->get();
		return $query;
	}

	function get_news_by_user($id_user)
	{
		$this->db->select('fk_id_user')
				 ->from('m_news')
				 ->where('fk_id_user', $id_user);

		$query = $this->db->get();
		return $query;
	}

	function create_user($pseudo_user, $password_user, $email_user, $level_user)
	{
		$data = array(
			'pseudo_user'	=> $pseudo_user,
			'password_user'	=> md5($password_user),
			'email_user'	=> $email_user,
			'level_user'	=> $level_user
		);

		$this->db->insert('m_user', $data);
	}

	function update_user($pseudo_user, $email_user, $level_user, $id_user)
	{
		$data = array(
			'pseudo_user' => $pseudo_user,
			'email_user'  => $email_user,
			'level_user'  => $level_user
		);

		$this->db->where('id_user', $id_user);
		$this->db->update('m_user', $data);
	}

	function delete_user($id_user)
	{
		$this->db->where('id_user', $id_user)
				 ->delete('m_user');
	}

	function update_password_user($u_new_pass, $id_user)
	{
		$data = array(
			'password_user' => md5($u_new_pass)
		);

		$this->db->where('id_user', $id_user);
		$this->db->update('m_user', $data);
	}

}


/* End of file model_user.php */
/* Location: ./application/models/admin/model_user.php */