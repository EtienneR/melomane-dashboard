<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_content extends CI_Model {

	function get_contents($last_content, $state)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, id_user, pseudo_user, title_category');
		$this->db->from('m_song');
		$this->db->join('m_category', 'm_category.id_category = m_song.fk_id_category');
		$this->db->join('m_user', 'm_user.id_user = m_song.fk_id_user');
		if (!empty($last_content)):
		$this->db->where('cdate_song <=', unix_to_human(now(), TRUE, 'eu') );
		endif;	
		if (!empty($state)):
		$this->db->where('state_song', 1);
		endif;
		$this->db->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_contents_by_category($category)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, title_category')
				 ->join('m_category', 'm_category.id_category = m_song.fk_id_category')
				 ->from('m_song')
				 ->like('title_category', $category)
				 ->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_contents_by_tag($tag)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, title_category')
				 ->join('m_category', 'm_category.id_category = m_song.fk_id_category')
				 ->from('m_song')
				 ->like('tag_song', $tag)
				 ->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_contents_by_author($author)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, id_user, pseudo_user, title_category')
				 ->from('m_song')
				 ->join('m_category', 'm_category.id_category = m_song.fk_id_category')
				 ->join('m_user', 'm_user.id_user = m_song.fk_id_user')
				 ->where('author_song', $author)
				 ->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}


	function get_content($id_song, $title_song)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, id_soundcloud, pseudo_user, fk_id_user, fk_id_category');
		$this->db->from('m_song');
		$this->db->join('m_user', 'm_user.id_user = m_song.fk_id_user');
		if (empty($c_title)):
		$this->db->where('id_song', $id_song);
		else:
		$this->db->where('title_song', $title_song);
		endif;
		$this->db->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function get_authors()
	{
		$this->db->distinct('')
				 ->select('author_song')
				 ->from('m_song')
				 ->order_by('author_song', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	function check_title($id_song, $title_song)
	{
		$this->db->select('title_song')
				 ->from('m_song')
				 ->where('id_song <>', $id_song)
				 ->where('title_song', $title_song);

		$query = $this->db->get();
		return $query;
	}

	function create_content($id_user, $title_song, $author_song, $image_song, $tags_song, $state_song, $cdate_song, $id_soundcloud, $url_soundcloud, $duration_soundcloud, $id_category)
	{
		$data = array(
			'fk_id_user'		   => $id_user,
			'title_song'		   => $title_song,
			'author_song'		   => $author_song,
			'image_song'		   => $image_song,
			'tag_song'			   => $tags_song,
			'state_song'		   => $state_song,
			'cdate_song'		   => $cdate_song,
			'udate_song'		   => unix_to_human(now(), TRUE, 'eu'),
			'id_soundcloud'		   => $id_soundcloud,
			'url_soundcloud'	   => $url_soundcloud,
			'duration_soundcloud'  => $duration_soundcloud,
			'fk_id_category' 	   => $id_category,
			// à changer
			'm_bg_id_bg' 		   => 1
		);

		$this->db->insert('m_song', $data);
	}
	
	function update_content($title_song, $author_song, $image_song, $tags_song, $state_song, $udate_song, $id_soundcloud, $id_category, $id_song)
	{
		if ($udate_song === TRUE):
			$data = array(
				'title_song'	 => $title_song,
				'author_song'	 => $author_song,
				'image_song'	 => $image_song,
				'tag_song'		 => $tags_song,
				'state_song'	 => $state_song,
				'udate_song'	 => unix_to_human(now(), TRUE, 'eu'),
				'id_soundcloud'	 => $id_soundcloud,
				'fk_id_category' => $id_category,
				// à changer
				'm_bg_id_bg'    => 1
			);
		else:
			$data = array(
				'title_song'	 => $title_song,
				'author_song'	 => $author_song,
				'image_song'	 => $image_song,
				'tags_song'		 => $tags_song,
				'state_song'	 => $state_song,
				'id_soundcloud'	 => $id_soundcloud,
				'fk_id_category' => $id_category,
				// à changer
				'm_bg_id_bg'    => 1
			);
		endif;

		$this->db->where('id_song', $id_song);
		$this->db->update('m_song', $data);
	}

	function delete_content($id_song)
	{
		$this->db->where('id_song', $id_song)
				 ->delete('m_song'); 
	}

	function get_content_by_category($id_category)
	{
		$this->db->select('id_song, title_song')
				 ->from('m_song')
				 ->join('m_category', 'm_song.fk_id_category = m_category.id_category')
				 ->where('m_category.id_category', $id_category);

		$query = $this->db->get();
		return $query;
	}

	function get_content_by_user($id_user, $limit)
	{
		$this->db->select('id_song, title_song, author_song, tag_song, state_song, cdate_song, udate_song, title_category');
		$this->db->from('m_song');
		$this->db->join('m_category', 'm_song.fk_id_category = m_category.id_category');
		$this->db->join('m_user', 'm_user.id_user = m_song.fk_id_user');
		$this->db->where('m_user.id_user', $id_user);
		$this->db->order_by('id_song', 'DESC');

		if (!empty($limit)):
			$this->db->limit($limit);
		endif;

		$query = $this->db->get();
		return $query;
	}

	function get_tags()
	{

		$select = 'tag_song,
				  GROUP_CONCAT(DISTINCT tag_song
				  ORDER BY tag_song DESC SEPARATOR ";") as tag';

		$this->db->select($select);
		$this->db->from('m_song');
		$this->db->where('state_song', 1);

/*		$this->db->distinct()
				 ->select('c_tags')
				 ->from('content')
				 ->where('c_state', 1);*/

		$query = $this->db->get();
		return $query;		
	}

}


/* End of file model_content.php */
/* Location: ./application/models/admin/model_content.php */