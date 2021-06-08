<?php

add_filter( 'woocommerce_thankyou_order_received_text', 'change_thank_you_message' );

function change_thank_you_message() {
 $added_text = 'Gracias, tu pedido ha sido recibido y será procesado dentro de las próximas 24/48 hs. hábiles.';
 return $added_text ;
}