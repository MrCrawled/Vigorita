<?php


// Actualiza automáticamente el estado de los pedidos a COMPLETADO
add_action( 'woocommerce_order_status_processing', 'actualizar_estado_pedidos_a_completado' );
add_action( 'woocommerce_order_status_on-hold', 'actualizar_estado_pedidos_a_completado' );
function actualizar_estado_pedidos_a_completado( $order_id ) {
    global $woocommerce;
    
    //ID's de las pasarelas de pago 
    $paymentMethods = array( 'mobbex', 'bacs', 'woo-mercado-pago-basic');
    
    if ( !$order_id ) return;
    $order = new WC_Order( $order_id );

    if ( !in_array( $order->payment_method, $paymentMethods ) ) return;
    $order->update_status( 'completed' );
}