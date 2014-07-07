<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_tag extends CI_Model {

	function get_tags()
	{
		$this->db->select('id_tag, name_tag')
				 ->from('m_tag')
				 ->order_by('id_tag', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_tag($id_tag)
	{

		$this->db->select('id_tag, name_tag')
				 ->from('m_tag')
				 ->where('id_tag', $id_tag)
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function check_name($id_tag, $name_tag)
	{
		$this->db->select('name_tag')
				 ->from('m_tag')
				 ->where('id_tag <>', $id_tag)
				 ->where('name_tag', $name_tag);

		$query = $this->db->get();
		return $query;
	}

	function create_tag($name_tag)
	{
		$data = array(
			'name_tag' => $name_tag
		);

		$this->db->insert('m_tag', $data);
	}

	function update_tag($name_tag, $id_tag)
	{
		$data = array(
			'name_tag' => $name_tag
		);

		$this->db->where('id_tag', $id_tag);
		$this->db->update('m_tag', $data);
	}

	function delete_tag($id_tag)
	{
		$this->db->where('id_tag', $id_tag)
				 ->delete('m_tag');
	}

}


/* End of file model_tag.php */
/* Location: ./application/models/model_tag.php */