<?php

namespace MABEL_SI\Core\Common
{

	use MABEL_SI\Core\Common\Managers\Script_Style_Manager;

	class Frontend extends Presentation_Base
	{
		public function __construct()
		{
			parent::__construct();
			Script_Style_Manager::add_script_variable('ajaxurl',admin_url('admin-ajax.php'));
			add_action( 'wp_enqueue_scripts', array($this, 'register_scripts_and_styles' ));
		}
		public function register_scripts_and_styles(){
			Script_Style_Manager::register_scripts();
			Script_Style_Manager::register_styles();
		}
	}
}