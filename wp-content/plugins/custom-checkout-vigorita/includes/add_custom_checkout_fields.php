<?php

 /*
 * Agrega el campo DNI al checkout
 */

add_action( 'woocommerce_before_order_notes', 'dni_add_custom_checkout_field' );
  
function dni_add_custom_checkout_field( $checkout ) { 
   woocommerce_form_field( 'dni', array(        
    'type'          => 'text',
    'label'         => __('DNI'),
    'maxlength'     => 10, 
 	'required'      => true,      
   ),
    $checkout->get_value( 'dni' ) ); 
}

/*
 * Valida que el campo Dni no venga vacio
 */
add_action('woocommerce_checkout_process', 'dni_validate_new_checkout_field');

function dni_validate_new_checkout_field() {
    if ( ! $_POST['dni'] )
        wc_add_notice( __( 'Ingrese el numero de Dni.' ), 'error' );
}

/*
 * Muestra el campo DNI cuando se envia un mail con el detalle de la compra
 */
add_action( 'woocommerce_email_after_order_table', 'dni_show_new_checkout_field_emails', 20, 4 );
  
function dni_show_new_checkout_field_emails( $order, $sent_to_admin, $plain_text, $email ) {
    if ( get_post_meta( $order->get_id(), '_dni', true ) ) echo '<p><strong>Dni:</strong> ' . get_post_meta( $order->get_id(), '_dni', true ) . '</p>';
}

/*
 * Agrega el campo Necesito Factura A al checkout
 */

add_action( 'woocommerce_before_order_notes', 'necesito_factura_a_add_custom_checkout_field' );

function necesito_factura_a_add_custom_checkout_field( $checkout ) { 
   woocommerce_form_field( 'necesito_factura_a', array(        
    'type' => 'checkbox', 
    'class' => array('input-checkbox'), 
    'label' => __('Necesito Factura A. Podes comunicarte al:</br>
		   Tel&eacute;fono: 0342-474-4900</br>
		   Wapp: +54 9 3425 97-8490</br>
		   Mail: webmail@vigorita.com.ar'),
    'default' => 0, 
),$checkout->get_value( 'necesito_factura_a' ));
}

/*
 * Muestra el campo Necesito Factura A cuando se envia un mail con el detalle de la compra
 */
add_action( 'woocommerce_email_after_order_table', 'necesito_factura_a_show_new_checkout_field_emails', 20, 4 );
  
function necesito_factura_a_show_new_checkout_field_emails( $order, $sent_to_admin, $plain_text, $email ) {
    $necesito_factura_a = get_post_meta( $order->get_id(), '_necesito_factura_a', true );
    if( $necesito_factura_a == 1 )
    echo '<p><strong>Necesito Factura A: </strong>Si</p>';
	elseif( $necesito_factura_a == 0 )
		echo '<p><strong>Necesito Factura A: </strong>No</p>';
}


/*
 * Agrega el campo tipo dni al checkout y lo oculta
*/
add_action( 'woocommerce_before_order_notes', 'tipo_dni_add_custom_checkout_field' );
  
function tipo_dni_add_custom_checkout_field( $checkout ) { 
   woocommerce_form_field( 'tipo_dni', array(        
    'type'          => 'text',
	'default'       => '96',
    'required'      => true, 
    'label_class' => array('custom_fields')
     
   ),
    $checkout->get_value( 'tipo_dni' ) ); 
}



/*
 *Agrega el campo tipo_de_responsable al checkout y lo oculta 
 */
add_action( 'woocommerce_before_order_notes', 'tipo_de_responsable_add_custom_checkout_field' );
  
function tipo_de_responsable_add_custom_checkout_field( $checkout ) { 
   woocommerce_form_field( 'tipo_de_responsable', array(        
    'type'          => 'text',
    'class' => array( 'custom_fields' ),        
    'default' => 'CF',	   
   ),
    $checkout->get_value( 'tipo_de_responsable' ) ); 
}

// Sobreescribe el campo Direccion de la calle y lo reemplaza por Dirección
add_filter('woocommerce_default_address_fields', 'override_default_address_checkout_fields');

function override_default_address_checkout_fields( $address_fields ) {
    $address_fields['address_1']['placeholder'] = 'Dirección';
    $address_fields['address_1']['label'] = 'Dirección';
     return  $address_fields;
}


?>