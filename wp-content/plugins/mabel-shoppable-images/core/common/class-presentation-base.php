<?php

namespace MABEL_SI\Core\Common
{

	use MABEL_SI\Core\Common\Linq\Enumerable;
	use MABEL_SI\Core\Common\Managers\Config_Manager;
	use MABEL_SI\Core\Models\Inline_Style;

	class Presentation_Base
	{
		/**
		 * @var array with key, value pairs to send to the frontend.
		 */

		public function __construct()
		{
		}

		public function add_ajax_function($name,$component,$callable,$frontend = true,$backend = true)
		{
			if($frontend)
				add_action('wp_ajax_nopriv_' . $name,array($component,$callable));
			if($backend)
				add_action('wp_ajax_' . $name, array($component,$callable));
		}
	}
}
