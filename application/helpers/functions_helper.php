<?php
if ( ! function_exists('css_url'))
{
	function css_url($file_name)
	{
		return '<link rel="stylesheet" href="' . base_url() . 'assets/css/' . $file_name . '.css" />
	';
	}
}

if ( ! function_exists('js_url'))
{
	function js_url($file_name)
	{
		return '<script src="' . base_url() . 'assets/js/' . $file_name . '.js"></script>
	';
	}
}

if ( ! function_exists('content_url'))
{
	function content_url($rubric, $content, $title)
	{
		return '<a href="' . base_url($rubric . '/' . $content) . '">' . $title . '</a>';
	}
}

if ( ! function_exists('content_url_button'))
{
	function content_url_button($rubric, $content)
	{
		return '<a href="' . base_url($rubric . '/' . $content) . '" class="btn btn-primary">Lire la suite</a>';
	}
}

if ( ! function_exists('rubric_url'))
{
	function rubric_url($rubric, $title)
	{
		return '<a href="' . base_url($rubric) . '">' . $title . '</a>';
	}
}

if ( ! function_exists('author_url'))
{
	function author_url($author)
	{
		return '<a href="' . base_url('auteur/' . $author) . '">' . $author . '</a>';
	}
}

if ( ! function_exists('tag_url'))
{
	function tag_url($tag)
	{	
		if ($tag != ''):
			return '<a href="' . base_url('t?q=' . $tag) . '">' . $tag . '</a> ';
		endif;
	}
}

if ( ! function_exists('img_thumb') )
{
	function img_thumb($image)
	{
		return '<img src="' . $image . '" alt="" class="img-responsive" style="margin: 0 auto; text-align: center;" />';
	}
}

if ( ! function_exists('img_thumb_url') )
{
	function img_thumb_url($rubric, $content, $image)
	{
		return '<a href="' . base_url($rubric . '/' . $content).'">
					<img src="' . $image . '" alt="" class="img-responsive" style="margin: 0 auto; text-align: center;" />
				</a>';
	}
}

if ( ! function_exists('date_fr'))
{
	function date_fr($jour, $mois, $annee)
	{
		$mois_n = $mois;
		switch ($mois) {
			case '01':
				$mois = 'Janvier';
				break;
			case '02':
				$mois = 'Février';
				break;
			case '03':
				$mois = 'Mars';
				break;
			case '04':
				$mois = 'Avril';
				break;
			case '05':
				$mois = 'Mai';
				break;
			case '06':
				$mois = 'Juin';
				break;
			case '7':
				$mois = 'Juillet';
				break;
			case '8':
				$mois = 'Aout';
				break;
			case '9':
				$mois = 'Septembre';
				break;
			case '10':
				$mois = 'Octobre';
				break;
			case '11':
				$mois = 'Novembre';
				break;
			case '12':
				$mois = 'Décembre';
				break;
			
			default:
				break;
		}

		return '<time datetime="' . $annee . '-' . $mois_n . '-' . $jour . '">' .$jour . ' ' . $mois . ' ' . $annee.'</time>';
	}
}

if ( ! function_exists('pagination_custom'))
{
	function pagination_custom()
	{
		$CI =& get_instance();

		$p_nb_listing = $CI->model_params->get_params2()->result();
		if (!empty($p_nb_listing)):
			$p_nb_listing = $p_nb_listing['0']->p_nb_listing;
		else:
			$p_nb_listing = 5;
		endif;

		$config['per_page']         = $p_nb_listing;
		$config['use_page_numbers'] = TRUE;

		$config['full_tag_open']    = '<ul class="pagination">';
		$config['full_tag_close']   = '</ul><!--pagination-->';
		$config['num_tag_open']     = '<li>';
		$config['num_tag_close']    = '</li>';
		$config['cur_tag_open']     = '<li class="active"><span>';
		$config['cur_tag_close']    = '</span></li>';
		$config['next_tag_open']    = '<li>';
		$config['next_tag_close']   = '</li>';
		$config['prev_tag_open']    = '<li>';
		$config['prev_tag_close']   = '</li>';
		$config['first_tag_open']   = '<li style="display: none;">';
		$config['first_tag_close']  = '</li>';
		$config['last_tag_open']    = '<li style="display: none;">';
		$config['last_tag_close']   = '</li>';

		return $config;
	}

}


/* End of file functions_helper.php */
/* Location: ./application/helpers/functions_helper.php */