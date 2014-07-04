<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front {

	function about()
	{
		$CI =& get_instance();
		$data = $CI->model_params->get_params()->row();

		return $data;
	}

	function get_all_content()
	{
		$CI =& get_instance();
		$data = $CI->model_content->get_contents(true, 1);

		return $data;
	}

	function get_all_rubrics()
	{
		$CI =& get_instance();
		$data = $CI->model_rubric->get_rubrics_front();

		return $data;
	}

	function get_all_authors()
	{
		$CI   =& get_instance();
		$data = $CI->model_user->get_users();

		return $data;
	}

	function get_pagination_seo($url, $first_url, $numero_page, $total, $per_page, $type)
	{
		// First page
		if ( ($numero_page == 1) OR ($numero_page == 0) ):
			if ($per_page > $total):
				$data = '';
			elseif ($type == 'POST'):
				$data = '<link rel="next" href="' . $url . '/' . ($numero_page+1) . '">' . "\n";
			else:
				$data = '<link rel="next" href="' . $url . '&page=' . ($numero_page+2) . '">' . "\n";
			endif;

		// Last page
		elseif($numero_page == ceil($total/$per_page)):
			if ($numero_page == 2):
				$data = '<link rel="prev" href="' . $first_url . '">'."\n";
			elseif ($type == 'POST'):
				$data = '<link rel="prev" href="' . $url . '/' . ($numero_page-1) . '">' . "\n";
			else:
				$data = '<link rel="prev" href="' . $url . '&page=' . ($numero_page-1) . '">' . "\n";
			endif;

		else:
			if ($type == 'POST'):
				if ($numero_page == 2):
					$data = '<link rel="prev" href="' . $first_url . '">' . "\n";
				else:
					$data = '<link rel="prev" href="' . $url . '/' . ($numero_page-1) . '">' . "\n";
				endif;
				$data.= '<link rel="next" href="' . $url . '/' . ($numero_page+1) . '">' . "\n";
			else:
				if ($numero_page == 2):
					$data = '<link rel="prev" href="' . $first_url . '">' . "\n";
				else:
					$data = '<link rel="prev" href="' . $url . '&page=' . ($numero_page-1) . '">' . "\n";
				endif;
				$data.= '<link rel="next" href="' . $url . '&page=' . ($numero_page+1) . '">' . "\n";
			endif;
		endif;

		return $data;
	}

}


/* End of file Front.php */
/* Location: ./application/librairies/Front.php */