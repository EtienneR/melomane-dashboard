<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_stats extends CI_Model {

	function get_playlists()
	{
		$this->db->select('id_playlist')
				 ->from('playlist');

		$query = $this->db->get();
		return $query;
	}

	function get_playlist_songs()
	{
		$this->db->distinct('')
				 ->select('song_id_song, count(song_id_song) as total, title_song, author_song')
				 ->from('playlist_content')
				 ->join('song', 'song.id_song = playlist_content.song_id_song')
				 ->group_by('song_id_song')
				 ->order_by('count(song_id_song)', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_distinct_playlist_user()
	{
		$this->db->distinct()
				 ->select('user_id_user')
				 ->from('playlist');

		$query = $this->db->get();
		return $query;
	}

	function get_favorites()
	{
		$this->db->distinct('')
				 ->select('song_id_song, count(song_id_song) as total, title_song, author_song')
				 ->from('playlist_content')
				 ->join('song', 'song.id_song = playlist_content.song_id_song')
				 ->where('favorite_playlist_content', 1)
				 ->group_by('song_id_song')
				 ->order_by('count(song_id_song)', 'DESC');

		$query = $this->db->get();
		return $query;
	}

	function get_songs()
	{
		$where = 'song_id_song IS NULL';
		$this->db->select('id_song, title_song, author_song')
				 ->from('song')
				 ->join('playlist_content', 'playlist_content.song_id_song = song.id_song', 'left outer')
				 ->where($where);

		$query = $this->db->get();
		return $query;
	}


}


/* End of file model_stats.php */
/* Location: ./application/models/admin/model_stats.php */