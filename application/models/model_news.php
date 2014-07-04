<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_news extends CI_Model {

	function get_all_news()
	{
		$this->db->select('id_news, title_news, content_news, state_news, cdate_news, udate_news, user.id_user, user.pseudo_user')
				 ->from('news')
				 ->join('user', 'user.id_user = news.user_id_user')
				 ->order_by('id_news', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_news($id_news)
	{
		$this->db->select('id_news, title_news, content_news, state_news, cdate_news, udate_news')
				 ->from('news')
				 ->where('id_news', $id_news)
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function get_others_news($id_news)
	{
		$this->db->select('id_news, title_news')
				 ->from('news')
				 ->where('id_news <>', $id_news);

		$query = $this->db->get();
		return $query;
	}

	function check_title($id_news, $title_news)
	{
		$this->db->select('title_news')
				 ->from('news')
				 ->where('id_news <>', $id_news)
				 ->where('title_news', $title_news);

		$query = $this->db->get();
		return $query;
	}

	function create_news($title_news, $content_news, $state_news, $id_user)
	{
		$data = array(
			'title_news'   => $title_news,
			'content_news' => $content_news,
			'state_news'   => $state_news,
			'user_id_user' => $id_user,
			'cdate_news'   => unix_to_human(now(), TRUE, 'eu'),
			'udate_news'   => unix_to_human(now(), TRUE, 'eu')
		);

		$this->db->insert('news', $data);
	}

	function update_news($title_news, $content_news, $state_news, $id_news)
	{
		$data = array(
			'title_news'   => $title_news,
			'content_news' => $content_news,
			'state_news'   => $state_news,
			'udate_news'   => unix_to_human(now(), TRUE, 'eu')
		);

		$this->db->where('id_news', $id_news)
				  ->update('news', $data);
	}

	function delete_news($id_news)
	{
		$this->db->where('id_news', $id_news)
				 ->delete('news');
	}

}


/* End of file model_category.php */
/* Location: ./application/models/model_category.php */