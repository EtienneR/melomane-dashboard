<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_category extends CI_Model {

	function get_categories()
	{
		$this->db->select('id_category, title_category, description_category, cdate_category, udate_category')
				 ->from('m_category')
				 ->order_by('id_category', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_category($id_category, $title_category)
	{
		$this->db->select('title_category, description_category, cdate_category, udate_category');
		$this->db->from('m_category');
		if (empty($title_category)):
		$this->db->where('id_category', $id_category);
		else:
		$this->db->where('title_category', $title_category);
		endif;
		$this->db ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function check_title($id_category, $title_category)
	{
		$this->db->select('title_category')
				 ->from('m_category')
				 ->where('id_category <>', $id_category)
				 ->where('title_category', $title_category);

		$query = $this->db->get();
		return $query;
	}


	function create_category($title_category, $description_category)
	{
		$data = array(
			'title_category'       => $title_category,
			'description_category' => $description_category,
			'cdate_category'	   => unix_to_human(now(), TRUE, 'eu'),
			'udate_category'	   => unix_to_human(now(), TRUE, 'eu')
		);

		$this->db->insert('m_category', $data);
	}

	function update_category($title_category, $description_category, $id_category)
	{
		$data = array(
			'title_category'	   => $title_category,
			'description_category' => $description_category,
			'udate_category'	   => unix_to_human(now(), TRUE, 'eu')
		);

		$this->db->where('id_category', $id_category);
		$this->db->update('m_category', $data);
	}

	function delete_category($id_category)
	{
		$this->db->where('id_category', $id_category)
				 ->delete('m_category');
	}

}


/* End of file model_category.php */
/* Location: ./application/models/model_category.php */