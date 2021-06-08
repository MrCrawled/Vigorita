<?php


function custom_fields_show_custom_fields_thankyou($order_id){
    echo '<h2>Informaci&oacute;n Adicional</h2>';	
    echo '<p><strong>'.__('DNI').':</strong> ' . get_post_meta( $order_id, '_dni', true ) . '</p>';
    if(get_post_meta( $order_id, '_necesito_factura_a', true )==1){
        $necesito_factura_a = "Si";
    }else{
        $necesito_factura_a = "No";
    }
    echo '<p><strong>'.__('Necesito factura A').':</strong> ' . $necesito_factura_a . '</p>';
    echo '<p><strong>'.__('Tipo Dni').':</strong> ' . get_post_meta( $order_id, '_tipo_dni', true ) . '</p>';
    echo '<p><strong>'.__('Tipo de Responsable').':</strong> ' . get_post_meta( $order_id, '_tipo_de_responsable', true ) . '</p>';

}

add_action('woocommerce_thankyou','custom_fields_show_custom_fields_thankyou', 20);
add_action('woocommerce_view_order','custom_fields_show_custom_fields_thankyou', 20);

?>