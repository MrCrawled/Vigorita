<?php


/*
 * Guarda el campo Dni en la orden
 */
add_action( 'woocommerce_checkout_update_order_meta', 'dni_save_new_checkout_field' );

function dni_save_new_checkout_field( $order_id ) {
    if ( ! empty( $_POST['dni'] ) ) 
        update_post_meta( $order_id, '_dni', sanitize_text_field( $_POST['dni'] ) );   
}

/*
 * Muestra el valor del campo DNI en la página de la orden dentro del panel de administración
 */

add_action( 'woocommerce_admin_order_data_after_billing_address', 'dni_show_new_checkout_field_order', 10, 1 );

function dni_show_new_checkout_field_order( $order ) {    
    echo '<p><strong>'.__('Dni').':</strong> ' . get_post_meta( $order->id, '_dni', true ) . '</p>';
}

/**
 * Guarda el campo Necesito Factura A en la orden
 */
add_action( 'woocommerce_checkout_update_order_meta', 'necesito_factura_a_save_new_checkout_field' );
  
function necesito_factura_a_save_new_checkout_field( $order_id ){
    if (!empty( $_POST['necesito_factura_a']))
    update_post_meta( $order_id, '_necesito_factura_a', sanitize_text_field( $_POST['necesito_factura_a'] ) );
}

/*
 * Muestra el valor del campo Necesito factura A en la página de la orden dentro del panel de administración
 */

add_action( 'woocommerce_admin_order_data_after_billing_address', 'necesito_factura_a_show_new_checkout_field_order', 10, 1 );
   
function necesito_factura_a_show_new_checkout_field_order( $order ) {    
    $necesito_factura_a = get_post_meta( $order->get_id(), '_necesito_factura_a', true );
    if( $necesito_factura_a == 1 )
        echo '<p><strong>Necesito Factura A: </strong>Si</p>';
	elseif( $necesito_factura_a == 0 )
		echo '<p><strong>Necesito Factura A: </strong>No</p>';
}

/*
 * Guarda el campo Tipo Dni en la orden
 */
add_action( 'woocommerce_checkout_update_order_meta', 'tipo_dni_save_new_checkout_field' );

function tipo_dni_save_new_checkout_field( $order_id ) {
    if ( ! empty( $_POST['tipo_dni'] ) ) 
        update_post_meta( $order_id, '_tipo_dni', sanitize_text_field( $_POST['tipo_dni'] ) );   
}

/**
 * Muestra el valor del campo tipo dni en la página de la orden dentro del panel de admistraci&oacute;n
 */

add_action( 'woocommerce_admin_order_data_after_billing_address', 'tipo_dni_show_new_checkout_field_order', 10, 1 );

function tipo_dni_show_new_checkout_field_order( $order ) {    
    echo '<p><strong>'.__('Tipo dni').':</strong> ' . get_post_meta( $order->id, '_tipo_dni', true ) . '</p>';

}

/**
 * Guarda el campo Tipo de responsable en la orden
 */

 add_action( 'woocommerce_checkout_update_order_meta', 'tipo_de_responsable_save_new_checkout_field' );
  
function tipo_de_responsable_save_new_checkout_field( $order_id ) { 
    if ( $_POST['tipo_de_responsable'] ) update_post_meta( $order_id, '_tipo_de_responsable', sanitize_text_field( $_POST['tipo_de_responsable'] ) );
}
  
/**
 * Muestra el valor del campo tipo dni en la página de la orden dentro del panel de admistraci&oacute;n
 */

add_action( 'woocommerce_admin_order_data_after_billing_address', 'tipo_de_responsable_show_new_checkout_field_order', 10, 1 );
   
function tipo_de_responsable_show_new_checkout_field_order( $order ) {    
    echo '<p><strong>'.__('Tipo de responsable').':</strong> ' . get_post_meta( $order->id, '_tipo_de_responsable', true ) . '</p>';
}
?>