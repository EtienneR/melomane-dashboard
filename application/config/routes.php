<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'admin/admin';

# ADMIN (connection)

$route['admin/logout'] 		   = $route['default_controller'] . '/logout';
$route['admin/reset_password'] = $route['default_controller'] . '/reset_password';

# ADMIN content
$route['admin/content']				  = 'admin/content';
$route['admin/content/edit']		  = 'admin/content/edit';
$route['admin/content/edit/(:num)']   = 'admin/content/edit/$1';
$route['admin/content/delete/(:num)'] = 'admin/content/delete/$1';
$route['admin/content/c']			  = 'admin/content/category';
$route['admin/content/t']			  = 'admin/content/tag';
$route['admin/content/a']			  = 'admin/content/artists';
$route['admin/content/get_tags.json']	  = 'admin/content/get_tags';

# Admin categories
$route['admin/category']			   = 'admin/category';
$route['admin/category/edit']		   = 'admin/category/edit';
$route['admin/category/edit/(:num)']   = 'admin/category/edit/$1';
$route['admin/category/delete/(:num)'] = 'admin/category/delete/$1';

# Admin tags
$route['admin/tag']			   	  = 'admin/tag';
$route['admin/tag/edit']		  = 'admin/tag/edit';
$route['admin/tag/edit/(:num)']   = 'admin/tag/edit/$1';
$route['admin/tag/delete/(:num)'] = 'admin/tag/delete/$1';

# Admin news
$route['admin/news']			    = 'admin/news';
$route['admin/news/edit']		    = 'admin/news/edit';
$route['admin/news/edit/(:num)']    = 'admin/news/edit/$1';
$route['admin/news/delete/(:num)']  = 'admin/news/delete/$1';
$route['admin/news/preview/(:num)'] = 'admin/news/preview/$1';

# ADMIN users
$route['admin/user']				 = 'admin/user';
$route['admin/user/edit']			 = 'admin/user/edit';
$route['admin/user/edit/(:num)']	 = 'admin/user/edit/$1';
$route['admin/user/delete/(:num)']   = 'admin/user/delete/$1';
$route['admin/user/change_password'] = 'admin/user/change_password';
$route['admin/user/(:num)']			 = 'admin/user/author/$1';

# ADMIN media
$route['admin/medias']				 = 'admin/medias';
$route['admin/medias/edit']			 = 'admin/medias/edit';
$route['admin/medias/edit/(:num)']   = 'admin/medias/edit/$1';
$route['admin/medias/delete/(:num)'] = 'admin/medias/delete/$1';
$route['admin/medias/upload'] = 'admin/medias/upload';

# ADMIN stats
$route['admin/stats'] = 'admin/stats';

# ADMIN params
$route['admin/params'] = 'admin/params';
$route['admin/search'] = 'admin/params/search';


/* End of file routes.php */
/* Location: ./application/config/routes.php */