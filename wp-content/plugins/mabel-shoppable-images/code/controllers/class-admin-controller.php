<?php

namespace MABEL_SI\Code\Controllers
{
	use MABEL_SI\Core\Common\Admin;
	use MABEL_SI\Core\Common\Managers\Config_Manager;
	use MABEL_SI\Core\Common\Managers\Options_Manager;
	use MABEL_SI\Core\Common\Managers\Script_Style_Manager;
	use MABEL_SI\Core\Common\Managers\Settings_Manager;
	use MABEL_SI\Code\Services\Woocommerce_Service;
	use MABEL_SI\Core\Models\ColorPicker_Option;
	use MABEL_SI\Core\Models\Container_Option;
	use MABEL_SI\Core\Models\Custom_Option;
	use MABEL_SI\Core\Models\Dropdown_Option;
	use MABEL_SI\Core\Models\Range_Option;
	use MABEL_SI\Core\Models\Text_Option;

	if(!defined('ABSPATH')){die;}

	class Admin_Controller extends Admin
	{
		private $slug;
		public function __construct()
		{
			parent::__construct(new Options_Manager());
			$this->slug = Config_Manager::$slug;

			$this->add_mediamanager_scripts = true;

			Script_Style_Manager::add_style('wp-color-picker',null);

			$this->add_ajax_function('mb-siwc-get-images', $this,'get_images',false,true);
			$this->add_ajax_function('mb-siwc-get-image', $this,'get_image',false,true);
			$this->add_ajax_function('mb-siwc-add-image', $this,'add_image',false,true);
			$this->add_ajax_function('mb-siwc-update-image', $this,'update_image',false,true);
			$this->add_ajax_function('mb-siwc-delete-image', $this, 'delete_image', false, true);

			$this->add_ajax_function('mb-siwc-get-product-by-id', $this, 'get_wc_product_by_id', false, true);
			$this->add_ajax_function('mb-siwc-get-products-by-ids', $this, 'get_wc_products_by_ids', false, true);
			$this->add_ajax_function('mb-siwc-get-products', $this, 'get_wc_products_by_name', false, true);

			add_filter('woocommerce_available_variation',array($this,('add_variation_id_to_available_variations')),10,3);
		}

		public function add_variation_id_to_available_variations($var_array,$variable_product,$variation) {
			$var_array['variable_id'] = $variable_product->get_ID();
			return $var_array;
		}

		public function get_wc_products_by_ids() {

			if(empty($_GET['ids'])){
				echo json_encode(array());
				wp_die();
			}

			$is_new = version_compare( WC()->version, '3.0.0','>=') === true;

			$products = array();

			foreach (explode(',',$_GET['ids']) as $pid) {

				$product = wc_get_product($pid);

                if(!$product)
                    continue;

				$products[] = array(
					'name'  => $product->get_title(),
					'url'   => $product->get_permalink(),
					'price' => get_woocommerce_currency_symbol() . ($is_new ? wc_get_price_to_display($product) :  $product->get_display_price()),
					'id' => $product->get_id()
				);

			}

			echo json_encode($products);
			wp_die();
		}

		public function get_wc_product_by_id() {
			echo json_encode($this->get_wc_product($_GET['id']));
			wp_die();
		}

		public function get_wc_products_by_name()
		{
			echo json_encode(Woocommerce_Service::find_products_by_name(isset($_GET['q']) ? $_GET['q'] : ''));
			wp_die();
		}

		private function get_wc_product($pid)
		{
			$is_new = version_compare( WC()->version, '3.0.0','>=') === true;

			$product = wc_get_product($pid);

			return array(
				'name'  => $product->get_title(),
				'variation' => false,
				'url'   => $product->get_permalink(),
				'price' => get_woocommerce_currency_symbol() . ($is_new ? wc_get_price_to_display($product) :  $product->get_display_price()),
				'id' => $product->get_id()
			);
		}

		public function delete_image()
		{
			wp_delete_post( $_REQUEST['imageId'], true );
			wp_die();
		}

		public function get_image()
		{
			if(!isset($_GET['id'])) wp_die();

			$post = get_post($_GET['id']);
			if($post == null) wp_die();

			wp_send_json(array(
				'id' => $post->ID,
				'image'  => json_decode(get_post_meta($post->ID,'image',true))->image,
				'tags' => json_decode(get_post_meta($post->ID,'tags',true))
			));
		}

		public function get_images()
		{
			$page = isset($_GET['page']) ? $_GET['page'] : 1;

			$post_ids = new \WP_Query(array(
				'post_type' => 'mb_siwc_image',
				'fields' => 'ids',
				'posts_per_page' => 12,
				'paged' => $page
			));

			$images = array();

			foreach ($post_ids->posts as $id){
				$thumb = json_decode(get_post_meta($id,'image',true))->thumb;
				$obj = (object) array(
					'id' => $id,
					'image'  => $thumb,
					'tags' => json_decode(get_post_meta($id,'tags',true))
				);
				array_push($images,$obj);
			}
			wp_reset_postdata();

			wp_send_json( array(
				'images' => $images,
				'maxPages' => $post_ids->max_num_pages,
				'currentPage' => $page
			));
		}

		public function update_image()
		{
			update_post_meta($_POST['id'],'tags',$_POST['tags']);
			wp_die();
		}

		public function add_image()
		{
			$id = wp_insert_post(array(
				'post_type' => 'mb_siwc_image',
				'post_status' => 'publish'
			),true);

			if(!is_wp_error( $id ) && $id > 0){

				add_post_meta($id,'image', json_encode(array(
					'image' => $_POST['image'],
					'thumb' => $_POST['thumb']
				),JSON_UNESCAPED_UNICODE));
				add_post_meta($id,'tags', $_POST['tags']);
			}
			wp_die($id);
		}

		public function init_admin_page()
		{
			$this->options_manager->add_section('sett',__('Settings', $this->slug), 'admin-settings',true);
			$this->options_manager->add_section('addimage', __('Add image',$this->slug), 'format-image');
			$this->options_manager->add_section('images', __('Images',$this->slug), 'images-alt2');

			$tag_container = new Container_Option(
				__('Hotspots', $this->slug),
				__('Hotspot settings', $this->slug),
				__('The hotspots are the clickable icons on your image.', $this->slug),
                null,
                false
			);
			$tag_container->options = [
				new ColorPicker_Option(
					'tagbgcolor',
					Settings_Manager::get_setting('tagbgcolor'),
					__('Tag background color',$this->slug)
				),
				new ColorPicker_Option(
					'tagfgcolor',
					Settings_Manager::get_setting('tagfgcolor'),
					__('Tag icon color',$this->slug)
				),
				new Dropdown_Option(
					'tagicon',
					__('Tag icon',$this->slug),
					array(
						'siwc-icon-info' => 'Info',
						'siwc-icon-info_outline' => 'Info (outlined)',
						'siwc-icon-plus' => 'Plus',
						'siwc-icon-plus_thin' => 'Plus (thin)',
						'siwc-icon-tag' => 'Tag',
						'siwc-icon-tag_outline' => 'Tag (outline)',
						'siwc-icon-target' => 'Target'
					),
					Settings_Manager::get_setting('tagicon')
				),
				new Range_Option(
					'tagsize',
					Settings_Manager::get_setting('tagsize'),
					__('Tag size',$this->slug),
					10,
					50
				),
				new Range_Option(
					'iconsize',
					Settings_Manager::get_setting('iconsize'),
					__('Tag icon size',$this->slug),
					10,
					50
				),
				new Range_Option(
					'tagborderradius',
					Settings_Manager::get_setting('tagborderradius'),
					__('Tag rounded corners',$this->slug),
					0,
					50
				),
				new Dropdown_Option(
					'taganim',
					'Tag animation',
					array(
						'none' => __('None', $this->slug),
						'pulse' => __('Pulse', $this->slug),
					),
					Settings_Manager::get_setting('taganim'),
					__('Add more visibility to your tags by adding an animation to them.')
				)
			];

			$this->options_manager->add_option('sett',$tag_container);

			$popup_settings = new Container_Option(
				__('Info window', $this->slug),
				__('Info window settings', $this->slug),
				__('When someone clicks on a hotspot, a small info window opens.',$this->slug)
            );
			$popup_settings->options = [
				new ColorPicker_Option(
					'popupbgcolor',
					Settings_Manager::get_setting('popupbgcolor'),
					__('background color',$this->slug)
				),
				new ColorPicker_Option(
					'popupfgcolor',
					Settings_Manager::get_setting('popupfgcolor'),
					__('Text color',$this->slug)
				),
				new Dropdown_Option(
					'image_size',
					__('Image size', $this->slug),
					array(
						'woocommerce_thumbnail' => 'Square thumbnail',
						'woocommerce_single' => 'Full size',
						'woocommerce_gallery_thumbnail' => 'Small thumbnail',
					),
					Settings_Manager::get_setting('image_size'),
					__("Size of the product images. Only change this setting if you find the shoppable image cards don't look good.", $this->slug)
				),
                new Dropdown_Option(
                    'popupopen',
                    __('Open info window', $this->slug),
                    array('click' => __('On clicking the tag', $this->slug), 'hover' => __('On hovering the tag',$this->slug)),
                    Settings_Manager::get_setting('popupopen'),
                    __('When to open the info window?',$this->slug)
                )
			];
			$this->options_manager->add_option('sett', $popup_settings);

			$button_options = new Container_Option(
				__('Button', $this->slug),
				__('Button settings', $this->slug),
				__('Setting for the "call to action" button inside the info window.',$this->slug)
			);

						$button_options->options = [
				new ColorPicker_Option(
					'buttonbgcolor',
					Settings_Manager::get_setting('buttonbgcolor'),
					__('Button background color',$this->slug)
				),
				new ColorPicker_Option(
					'buttonfgcolor',
					Settings_Manager::get_setting('buttonfgcolor'),
					__('Button text color',$this->slug)
				),
				new Text_Option(
					'buttontext',
					__('Button text', $this->slug),
					Settings_Manager::get_setting('buttontext'),
					null,
					__('What text should appear on the button.', $this->slug)
				),
				new Dropdown_Option(
					'buttonaction',
					__('Button behavior', $this->slug),
					array(
						'product' => __("Go to product detail page",$this->slug),
						'cart' => __("Add to cart (via Ajax)", $this->slug)
					),
					Settings_Manager::get_setting('buttonaction'),
					__("What should happen when the user clicks on the button?", $this->slug)
				)
			];

			$this->options_manager->add_option('sett', $button_options);

			$this->options_manager->add_option('addimage',
				new Custom_Option(null,'add_image',array(
					'woocommerce_active' => class_exists( 'WooCommerce' )
				))
			);

			$this->options_manager->add_option('images',
				new Custom_Option(null,'all_images')
			);

		}

	}
}