<?php

namespace MABEL_SI\Core\Common
{
	use MABEL_SI\Core\Common\Managers\Config_Manager;
	use MABEL_SI\Core\Common\Managers\License_Manager;
	use MABEL_SI\Core\Common\Managers\Options_Manager;
	use MABEL_SI\Core\Common\Managers\Script_Style_Manager;
	use MABEL_SI\Core\Models\Start_VM;
	use DateTime;
	use DateTimeZone;

	abstract class Admin extends Presentation_Base
	{
		public $options_manager;
		public $add_mediamanager_scripts;
		private static $notices = array();

		public function __construct(Options_Manager $options_manager)
		{
			parent::__construct();
			$this->add_mediamanager_scripts = false;
			$this->options_manager = $options_manager;

			// License & update manager
			new License_Manager('https://studiowombat.com/wp-json/ssp/v1',Config_Manager::$plugin_base);

			Script_Style_Manager::add_script(Config_Manager::$slug,'admin/js/admin.min.js',array('jquery','wp-color-picker'));
			Script_Style_Manager::add_style(Config_Manager::$slug,'admin/css/admin.min.css');

			add_action('admin_menu', array($this, 'add_menu'));
			add_filter('plugin_action_links_' . Config_Manager::$plugin_base, array($this, 'add_settings_link'));

			add_action( 'admin_init', array($this, 'init_settings'));
			if(isset($_GET['page']) && $_GET['page'] === Config_Manager::$slug)
			{
				add_action( 'admin_enqueue_scripts', array($this, 'register_styles' ));
				add_action( 'admin_enqueue_scripts', array($this, 'register_scripts') );
				add_action('admin_init',array($this,'init_admin_page'));
				add_action('admin_notices', array($this,'show_admin_notices'));
			}
		}

		public function show_admin_notices() {
			$notices = self::$notices;

			foreach( $notices as $notice ) {
				echo '<div class="notice is-dismissible notice-'.$notice['class'].'"><p>'.$notice['message'].'</p></div>';
			}

			if(isset($_GET['notice']) && isset($_GET['page']) && $_GET['page'] === Config_Manager::$slug){
				$notice = unserialize(base64_decode($_GET['notice']));
				echo '<div class="notice is-dismissible notice-'.$notice['class'].'"><p>'.$notice['message'].'</p></div>';
			}
		}

		public abstract function init_admin_page();

		public function add_settings_link( $links )
		{
			$my_links = array(
				'<a href="' . admin_url( 'options-general.php?page=' .Config_Manager::$slug ) . '">' .__('Settings' , Config_Manager::$slug). '</a>',
			);
			return array_merge( $links, $my_links );
		}

		public function add_menu()
		{
            $capability = 'manage_options';

            if(has_filter('shoppable_images_capability')) {
                $capability = apply_filters( 'shoppable_images_capability', $capability );
            }

			add_options_page('', Config_Manager::$name, $capability, Config_Manager::$slug, array($this,'display_settings'));
		}

		public function init_settings()
		{
			register_setting( Config_Manager::$slug , Config_Manager::$settings_key );
		}

		public function display_settings()
		{
			$model = new Start_VM();
			$model->settings_key = Config_Manager::$settings_key;
			$model->sections = $this->options_manager->get_sections();
			$model->hidden_settings = $this->options_manager->get_hidden_settings();
			$model->slug = Config_Manager::$slug;

			$info = License_Manager::get_license_info();

			if($info !== null)
			{
				$model->has_license = !empty($info->key);
				$license_date_as_date =  DateTime::createFromFormat(
					'Y-m-d H:i:s',
					$info->expiration,
					new DateTimeZone('UTC'));
				$difference =  $license_date_as_date->diff(new DateTime('now',new DateTimeZone('UTC')));
				$model->time_left_in_days = $difference->days;
				$model->license_overdue = $difference->invert === 0;
			}

			ob_start();
			include Config_Manager::$dir . 'core/views/start.php';
			echo ob_get_clean();
		}

		public function register_styles() {
			Script_Style_Manager::register_styles();
			Script_Style_Manager::publish_styles();
		}

		public function register_scripts() {
			Script_Style_Manager::register_scripts();
			Script_Style_Manager::publish_scripts();
			if ( $this->add_mediamanager_scripts ) {
				wp_enqueue_media();
			}
		}
	}
}