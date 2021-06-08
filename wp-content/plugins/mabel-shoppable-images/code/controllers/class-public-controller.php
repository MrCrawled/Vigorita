<?php

namespace MABEL_SI\Code\Controllers
{

	use MABEL_SI\Core\Common\Frontend;
	use MABEL_SI\Core\Common\Managers\Config_Manager;
	use MABEL_SI\Core\Common\Managers\Script_Style_Manager;
	use MABEL_SI\Core\Common\Managers\Settings_Manager;

	if(!defined('ABSPATH')){die;}

	class Public_Controller extends Frontend
	{
		public function __construct()
		{
			parent::__construct();

			$tag_bg_color = Settings_Manager::get_setting('tagbgcolor');

			Script_Style_Manager::$frontend_js_var = 'siData';
			Script_Style_Manager::add_script_variable('site_url',trailingslashit(get_site_url()));
			Script_Style_Manager::add_script(Config_Manager::$slug,'public/js/public.min.js','jquery');
			Script_Style_Manager::add_style(Config_Manager::$slug,'public/css/public.min.css');
			Script_Style_Manager::add_inline_style(Config_Manager::$slug,'span.mb-siwc-tag', array(
				'margin-left' => '-'.intval(Settings_Manager::get_setting('tagsize')/2) .'px',
				'margin-top' => '-'.intval(Settings_Manager::get_setting('tagsize')/2) .'px',
				'color' => Settings_Manager::get_setting('tagfgcolor'),
				'width' => Settings_Manager::get_setting('tagsize') .'px',
				'height' => Settings_Manager::get_setting('tagsize') .'px',
				'background' => $tag_bg_color,
				'font-size' => Settings_Manager::get_setting('iconsize') .'px',
				'border-radius' => Settings_Manager::get_setting('tagborderradius') .'%',
			));
			Script_Style_Manager::add_inline_style(Config_Manager::$slug,'.mb-siwc-popup a',array(
				'background' => Settings_Manager::get_setting('buttonbgcolor'),
                'color' => Settings_Manager::get_setting('buttonfgcolor') .' !important;'
			));
			Script_Style_Manager::add_inline_style(Config_Manager::$slug,'.mb-siwc-popup .siwc-text',array(
				'color' => Settings_Manager::get_setting('popupfgcolor'),
			));
			Script_Style_Manager::add_inline_style(Config_Manager::$slug,'.mb-siwc-popup',array(
				'background' => Settings_Manager::get_setting('popupbgcolor'),
			));
			Script_Style_Manager::add_inline_style(Config_Manager::$slug,'.mb-siwc-popup:after',array(
				'border-bottom-color' => Settings_Manager::get_setting('popupbgcolor')
			));
			if(Settings_Manager::get_setting('taganim') === 'pulse')
			Script_Style_Manager::add_inline_style(
				Config_Manager::$slug,
				'@keyframes siwc-pulse',
				'0%{box-shadow:0 0 0 0px '.$this->color_to_rgba($tag_bg_color,.32).';}60%{box-shadow:0 0 0 10px '.$this->color_to_rgba($tag_bg_color,0).';}'
			);

			add_action('wp_footer',array($this,'add_mobile_check'));
		}

		public function add_mobile_check() {
			echo '<div class="si-mobile-check"></div>';
		}

		public function fetch_shortcode_ajax()
		{
			$attributes = htmlspecialchars_decode(stripslashes($_REQUEST['options']));
			echo do_shortcode('[' .$_REQUEST['code']. ' ' . $attributes . ' caching="false" ]');
			wp_die();
		}

		private function color_to_rgba( $color, $alpha = 1 ) {
			$color = strtolower($color);
			$hex = str_replace( '#', '', $color );

			$length = strlen( $hex );
			$rgb['r'] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
			$rgb['g'] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
			$rgb['b'] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );
			if($alpha){
				$rgb['a'] = $alpha;
			}
			return sprintf('rgba(%s,%s,%s,%s)',$rgb['r'],$rgb['g'],$rgb['b'],$alpha);
		}
	}
}