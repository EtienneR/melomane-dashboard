<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_media extends CI_Model {

	function get_all_medias()
	{
		$this->db->select('id_bg, image_bg')
				 ->from('m_bg')
				 ->order_by('id_bg', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_media($id_bg)
	{
		$this->db->select('id_bg, image_bg')
				 ->from('m_bg')
				 ->where('id_bg', $id_bg)
				 ->limit(1);

		$query = $this->db->get();
		return $query;
	}

	function create_bg($image_bg)
	{
		$data = array(
			'image_bg' => $image_bg
		);

		$this->db->insert('m_bg', $data);
	}

	function update_media($image_bg, $id_bg)
	{
		$data = array(
			'image_bg' => $image_bg
		);

		$this->db->where('id_bg', $id_bg);
		$this->db->update('m_bg', $data);
	}

	function delete_media($id_bg)
	{
		$this->db->where('id_bg', $id_bg)
				 ->delete('m_bg');
	}

}


/* End of file model_media.php */
/* Location: ./application/models/model_media.php */