<?php

namespace MABEL_SI\Code\Controllers
{

	use MABEL_SI\Code\Models\Shoppable_Image_VM;
	use MABEL_SI\Code\Models\Tag;
	use MABEL_SI\Code\Services\Woocommerce_Service;
	use MABEL_SI\Core\Common\Managers\Config_Manager;
	use MABEL_SI\Core\Common\Managers\Script_Style_Manager;
	use MABEL_SI\Core\Common\Managers\Settings_Manager;
	use MABEL_SI\Core\Common\Shortcode;

	if(!defined('ABSPATH')){die;}

	class Shortcode_Controller
	{
		private $slug;

		public function __construct()
		{
			$this->slug = Config_Manager::$slug;
			$this->init_shortcode();
		}

		private function init_shortcode()
		{
			new Shortcode(
				'shoppable_image',
				'shoppable-image',
				array($this,'create_shortcode_model')
			);
		}

		public function create_shortcode_model($attributes) {

			Script_Style_Manager::publish_style(Config_Manager::$slug);
			Script_Style_Manager::publish_script(Config_Manager::$slug);
			Script_Style_Manager::publish_inline_styles();
			Script_Style_Manager::add_script_vars();

			$model = new Shoppable_Image_VM();

			if(!isset($attributes['id']) || get_post($attributes['id']) == null || get_post($attributes['id'])->post_type !== 'mb_siwc_image') {
				$model->show_error = true;
				return $model;
			}

			$model->button_text = Settings_Manager::get_setting('buttontext');
			$model->size = Settings_Manager::get_setting('tagsize');
			$model->icon = Settings_Manager::get_setting('tagicon');
			$model->image = json_decode(get_post_meta($attributes['id'],'image',true))->image;
			$taglist = json_decode(get_post_meta($attributes['id'],'tags',true));

			foreach($taglist as $tag)
			{

				$t = new Tag(round(doubleval($tag->x),4),round(doubleval($tag->y),4));

				if($tag->id) {

					$product = Woocommerce_Service::get_product($tag->id);

					if($product === null)
						continue;

					$t->is_variation = $product->is_type('variation');
					$t->link = $product->get_permalink();
                    $t->thumb = get_the_post_thumbnail_url($product->get_id(),Settings_Manager::get_setting('image_size'));
                    $t->price = $this->format_price(wc_get_price_to_display($product));
					$t->title = $product->get_title();
					$t->product_id = $tag->id;

					$t = apply_filters('shoppable_image_woocommerce_tag', $t, $product);

				}else{ 
					$t->price = $tag->price;
					$t->title = $tag->name;
					$t->link = $tag->url;

                    $t = apply_filters('shoppable_image_tag', $t);
				}

				array_push($model->tags, $t);
			}

			return $model;
		}

        private function format_price($price) {
            if(empty($price))
                $price = 0;

            return sprintf(
                get_woocommerce_price_format(),
                get_woocommerce_currency_symbol(),
                number_format($price,wc_get_price_decimals(),wc_get_price_decimal_separator(),wc_get_price_thousand_separator())
            );
        }

	}
}