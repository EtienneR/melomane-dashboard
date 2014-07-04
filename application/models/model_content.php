<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_content extends CI_Model {

	function get_contents($last_content, $state)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, id_user, pseudo_user, title_category');
		$this->db->from('song');
		$this->db->join('category', 'category.id_category = song.category_id_category');
		$this->db->join('user', 'user.id_user = song.user_id_user');
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
				 ->join('category', 'category.id_category = song.category_id_category')
				 ->from('song')
				 ->like('title_category', $category)
				 ->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_contents_by_tag($tag)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, title_category')
				 ->join('category', 'category.id_category = song.category_id_category')
				 ->from('song')
				 ->like('tag_song', $tag)
				 ->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_contents_by_author($author)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, id_user, pseudo_user, title_category')
				 ->from('song')
				 ->join('category', 'category.id_category = song.category_id_category')
				 ->join('user', 'user.id_user = song.user_id_user')
				 ->where('author_song', $author)
				 ->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}


	function get_content($id_song, $title_song)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, id_soundcloud, pseudo_user, user_id_user, category_id_category');
		$this->db->from('song');
		$this->db->join('user', 'user.id_user = song.user_id_user');
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
				 ->from('song')
				 ->order_by('author_song', 'ASC');

		$query = $this->db->get();
		return $query;
	}

	function check_title($id_song, $title_song)
	{
		$this->db->select('title_song')
				 ->from('song')
				 ->where('id_song <>', $id_song)
				 ->where('title_song', $title_song);

		$query = $this->db->get();
		return $query;
	}

	function create_content($id_user, $title_song, $author_song, $image_song, $tags_song, $state_song, $cdate_song, $id_soundcloud, $id_category)
	{
		$data = array(
			'user_id_user'		   => $id_user,
			'title_song'		   => $title_song,
			'author_song'		   => $author_song,
			'image_song'		   => $image_song,
			'tag_song'			   => $tags_song,
			'state_song'		   => $state_song,
			'cdate_song'		   => $cdate_song,
			'udate_song'		   => unix_to_human(now(), TRUE, 'eu'),
			'id_soundcloud'		   => $id_soundcloud,
			'category_id_category' => $id_category
		);

		$this->db->insert('song', $data);
	}
	
	function update_content($title_song, $author_song, $image_song, $tags_song, $state_song, $udate_song, $id_soundcloud, $id_category, $id_song)
	{
		if ($udate_song === TRUE):
			$data = array(
				'title_song'		   => $title_song,
				'author_song'		   => $author_song,
				'image_song'		   => $image_song,
				'tag_song'			   => $tags_song,
				'state_song'		   => $state_song,
				'udate_song'		   => unix_to_human(now(), TRUE, 'eu'),
				'id_soundcloud'		   => $id_soundcloud,
				'category_id_category' => $id_category
			);
		else:
			$data = array(
				'title_song'		   => $title_song,
				'author_song'		   => $author_song,
				'image_song'		   => $image_song,
				'tags_song'			   => $tags_song,
				'state_song'		   => $state_song,
				'id_soundcloud'		   => $id_soundcloud,
				'category_id_category' => $id_category
			);
		endif;

		$this->db->where('id_song', $id_song);
		$this->db->update('song', $data);
	}

	function delete_content($id_song)
	{
		$this->db->where('id_song', $id_song)
				 ->delete('song'); 
	}


	// Get content for listing
	function get_contents_listing($u_login, $numero_page, $per_page)
	{
		if (!empty($u_login)):
			$author = ', u_login';
		else:
			$author = '';
		endif;
		$this->db->select('c_title, c_content, c_image, c_tags, c_cdate, c_url_rw, r_title, r_url_rw ' . $author . '');
		$this->db->from('content');
		$this->db->join('rubric', 'rubric.r_id = content.r_id');
		if ($u_login):
			$this->db->join('user', 'user.u_id = content.u_id');
			$this->db->where('user.u_login', $u_login);
		endif;
		$this->db->where('c_state', 1);
		$this->db->where('c_cdate <', unix_to_human(now(), TRUE, 'eu') );
		$this->db->order_by('c_id', 'DESC');

		if ($numero_page and $per_page):
			$this->db->limit($per_page, ($numero_page-1) * $per_page);
		elseif ($per_page):
			$this->db->limit($per_page);
		endif;

		$query = $this->db->get();
		return $query;
	}

	// Get content for a content
	function get_content_by_slug($slug_rubric, $slug_content)
	{
		$this->db->select('c_id, c_title, c_content, c_image, c_tags, c_cdate, c_udate, c_url_rw, r_title, r_url_rw, user.u_id, u_login, u_biography')
				 ->from('content')
				 ->join('rubric', 'content.r_id = rubric.r_id')
				 ->join('user', 'content.u_id = user.u_id')
				 ->where('r_url_rw', $slug_rubric)
				 ->where('c_url_rw', $slug_content)
				 ->where('c_state', 1)
				 ->where('c_cdate <=', unix_to_human(now(), TRUE, 'eu'));

		$query = $this->db->get();
		return $query;
	}

	function get_contents_others($slug_content)
	{
		$this->db->select('c_title, c_url_rw, r_url_rw')
				 ->join('rubric', 'rubric.r_id = content.r_id')
				 ->from('content')
				 ->where('c_url_rw <>', $slug_content)
				 ->where('c_cdate <=', unix_to_human(now(), TRUE, 'eu') )
				 ->where('c_state', 1)
				 ->order_by('c_id', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_contents_same_rubric($slug_rubric, $slug_content)
	{
		$this->db->select('c_title, c_url_rw, r_url_rw')
				 ->join('rubric', 'content.r_id = rubric.r_id')
				 ->from('content')
				 ->where('rubric.r_url_rw', $slug_rubric)
				 ->where('content.c_url_rw <>', $slug_content)
				 ->where('c_state', 1)
				 ->where('c_cdate <=', unix_to_human(now(), TRUE, 'eu') )
				 ->order_by('c_id', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_contents_rubric_listing($slug_rubric, $numero_page, $per_page)
	{
		$this->db->select('c_title, c_content, c_image, c_tags, c_cdate, c_url_rw, r_title, r_description, r_url_rw');
		$this->db->from('content');
		$this->db->join('rubric', 'rubric.r_id = content.r_id');
		$this->db->where('rubric.r_url_rw', $slug_rubric);
		$this->db->where('c_state', 1);
		$this->db->where('c_cdate <=', unix_to_human(now(), TRUE, 'eu') );
		$this->db->order_by('content.c_id', 'DESC');
		if ($numero_page and $per_page):
			$this->db->limit($per_page, ($numero_page-1) * $per_page);
		elseif ($per_page):
			$this->db->limit($per_page);
		endif;

		$query = $this->db->get();
		return $query;
	} 

	function get_content_by_category($id_category)
	{
		$this->db->select('id_song, title_song')
				 ->from('song')
				 ->join('category', 'song.category_id_category = category.id_category')
				 ->where('category.id_category', $id_category);

		$query = $this->db->get();
		return $query;
	}

	function get_content_by_user($id_user, $limit)
	{
		$this->db->select('id_song, title_song, author_song, tag_song, state_song, cdate_song, udate_song, title_category');
		$this->db->from('song');
		$this->db->join('category', 'song.category_id_category = category.id_category');
		$this->db->join('user', 'user.id_user = song.user_id_user');
		$this->db->where('user.id_user', $id_user);
		$this->db->order_by('id_song', 'DESC');

		if (!empty($limit)):
			$this->db->limit($limit);
		endif;

		$query = $this->db->get();
		return $query;
	}

	// tags
	function get_content_by_tag_name($t_name, $numero_page, $per_page)
	{
		$this->db->select('*');
		$this->db->from('content');
		$this->db->join('rubric', 'content.r_id = rubric.r_id');
		$this->db->like('c_tags', $t_name);
		$this->db->where('c_state', 1);
		$this->db->order_by('c_id', 'DESC');

		if ($numero_page and $per_page):
			$this->db->limit($per_page, ($numero_page-1) * $per_page);
		elseif ($per_page):
			$this->db->limit($per_page);
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
		$this->db->from('song');
		$this->db->where('state_song', 1);

/*		$this->db->distinct()
				 ->select('c_tags')
				 ->from('content')
				 ->where('c_state', 1);*/

		$query = $this->db->get();
		return $query;		
	}


	function search_content($request)
	{
		$this->db->select('id_song, title_song, author_song, image_song, tag_song, state_song, cdate_song, udate_song, title_category')
				 ->join('category', 'category.id_category = song.category_id_category')
				 ->from('song')
				 ->like('title_song', $request)
				 ->order_by('id_song', 'DESC');

		$query = $this->db->get();
		return $query;
	}


}


/* End of file model_content.php */
/* Location: ./application/models/admin/model_content.php */