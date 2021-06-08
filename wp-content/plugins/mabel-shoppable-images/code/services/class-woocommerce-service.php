<?php

namespace MABEL_SI\Code\Services
{

	use MABEL_SI\Core\Common\Linq\Enumerable;

	class Woocommerce_Service {

        public static function find_products_by_name($term)
        {
            if(empty($term))
                return array();

            $ds = new \WC_Product_Data_Store_CPT();
            $product_ids = $ds->search_products($term, '', false, false, 5);

            $products = array();

            foreach($product_ids as $pid) {
                if($pid === 0)
                    continue;

                $product = wc_get_product($pid);
                if(empty($product))
                    continue;

                $products[] = array(
                    'name' => $product->get_title(),
                    'variation' => false,
                    'url' => $product->get_permalink(),
                    'price' => get_woocommerce_currency_symbol() . wc_get_price_to_display($product),
                    'id' => $product->get_id()
                );

                if($product->is_type('variable')) {
                    $product_names = [];
                    $variations = $product->get_available_variations();
                    foreach($variations as $variation) {
                        $variations_string = join(', ', Enumerable::from($variation['attributes'])->where(function($x){
                            return !empty($x);
                        })->toArray());
	                    $product_names[$product->get_title() .' ('.$variations_string.')'] = new \WC_Product_Variation($variation['variation_id']);
                    }

                    foreach($product_names as $k=>$v) {
                        $products[] = array(
                            'name' => $k,
                            'variation' => true,
                            'url' => $v->get_permalink(),
                            'price' => get_woocommerce_currency_symbol() . wc_get_price_to_display($v),
                            'id' => $v->get_id()
                        );
                    }
                }
            }

            return $products;
        }

        public static function get_product($id)
        {
            $product = wc_get_product($id);
            if($product)
                return $product;
            return null;
        }
	}
}
