<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_news extends CI_Model {

	function get_all_news()
	{
		$this->db->select('id_news, title_news, content_news, state_news, cdate_news, udate_news, pdate_news, m_user.id_user, m_user.pseudo_user')
				 ->from('m_news')
				 ->join('m_user', 'm_user.id_user = m_news.fk_id_user')
				 ->order_by('id_news', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_news($id_news)
	{
		$this->db->select('id_news, title_news, image_news, content_news, state_news, cdate_news, udate_news, pdate_news')
				 ->from('m_news')
				 ->where('id_news', $id_news)
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function get_others_news($id_news)
	{
		$this->db->select('id_news, title_news')
				 ->from('m_news')
				 ->where('id_news <>', $id_news);

		$query = $this->db->get();
		return $query;
	}

	function check_title($id_news, $title_news)
	{
		$this->db->select('title_news')
				 ->from('m_news')
				 ->where('id_news <>', $id_news)
				 ->where('title_news', $title_news);

		$query = $this->db->get();
		return $query;
	}

	function create_news($title_news, $content_news, $image_news, $state_news, $pdate_news, $id_user)
	{
		$data = array(
			'title_news'   => $title_news,
			'content_news' => $content_news,
			'image_news'   => $image_news,
			'state_news'   => $state_news,
			'fk_id_user'   => $id_user,
			'cdate_news'   => unix_to_human(now(), TRUE, 'eu'),
			'udate_news'   => unix_to_human(now(), TRUE, 'eu'),
			'pdate_news'   => $pdate_news
		);

		$this->db->insert('m_news', $data);
	}

	function update_news($title_news, $content_news, $image_news, $state_news, $pdate_news, $id_news)
	{
		$data = array(
			'title_news'   => $title_news,
			'content_news' => $content_news,
			'image_news'   => $image_news,
			'state_news'   => $state_news,
			'udate_news'   => unix_to_human(now(), TRUE, 'eu'),
			'pdate_news'   => $pdate_news
		);

		$this->db->where('id_news', $id_news)
				  ->update('m_news', $data);
	}

	function delete_news($id_news)
	{
		$this->db->where('id_news', $id_news)
				 ->delete('m_news');
	}

}


/* End of file model_category.php */
/* Location: ./application/models/model_category.php */