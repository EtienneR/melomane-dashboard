<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_stats extends CI_Model {

	function get_playlists()
	{
		$this->db->select('id_playlist')
				 ->from('m_playlist');

		$query = $this->db->get();
		return $query;
	}

	function get_playlist_songs()
	{
		$this->db->distinct('')
				 ->select('fk_id_song, count(fk_id_song) as total, title_song, artist_song')
				 ->from('m_playlist_content')
				 ->join('m_song', 'm_song.id_song = m_playlist_content.fk_id_song')
				 ->group_by('fk_id_song')
				 ->order_by('count(fk_id_song)', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_distinct_playlist_user()
	{
		$this->db->distinct()
				 ->select('fk_id_user')
				 ->from('m_playlist');

		$query = $this->db->get();
		return $query;
	}

	function get_favorites()
	{
		$this->db->distinct('')
				 ->select('fk_id_song, count(fk_id_song) as total, title_song, artist_song')
				 ->from('m_playlist_content')
				 ->join('m_song', 'm_song.id_song = m_playlist_content.fk_id_song')
				 ->where('favorite_playlist_content', 1)
				 ->group_by('fk_id_song')
				 ->order_by('count(fk_id_song)', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_songs()
	{
		$where = 'fk_id_user IS NULL';
		$this->db->select('id_song, title_song, artist_song')
				 ->from('m_song')
				 ->join('m_playlist_content', 'm_playlist_content.fk_id_song = m_song.id_song', 'left outer')
				 ->where($where);

		$query = $this->db->get();
		return $query;
	}

}


/* End of file model_stats.php */
/* Location: ./application/models/admin/model_stats.php */