<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue child scripts
 */
add_action( 'wp_enqueue_scripts', 'amely_child_enqueue_scripts' );
if ( ! function_exists( 'amely_child_enqueue_scripts' ) ) {

	function amely_child_enqueue_scripts() {
		wp_enqueue_style( 'amely-main-style', trailingslashit( get_template_directory_uri() ) . '/style.css' );
		wp_enqueue_style( 'amely-child-style', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css' );
		wp_enqueue_script( 'amely-child-script',
			trailingslashit( get_stylesheet_directory_uri() ) . 'script.js',
			array( 'jquery' ),
			null,
			true );
	}
}

//Modifica el Tabs Mas Información a Ficha Técnica, en el detalle del producto 
add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);

function woo_rename_tabs($tabs)
{
	$tabs['additional_information']['title'] = 'Ficha Técnica';
	return $tabs;
}


	
//Añade el campo descuento en el form de usuarios del panel de administración
add_action( 'show_user_profile', 'add_field_seccion' );
add_action( 'edit_user_profile', 'add_field_seccion' );
 
function add_field_seccion( $user ) {
?>
    <h3><?php _e('Descuento'); ?></h3>
    
    <table class="form-table">
        <tr>
            <th>
                <label for="descuento"><?php _e('Descuento (%)'); ?></label>
            </th>
            <td>
                <input type="text" name="descuento" id="descuento" class="regular-text"
                	value="<?php echo esc_attr( get_the_author_meta( 'descuento', $user->ID ) ); ?>" />
                <p class="description"><?php _e('Ingrese el descuento'); ?></p>
            </td>
        </tr>
    </table>
<?php }

//Guarda campo descuento dentro del perfil de usuario
add_action( 'personal_options_update', 'save_field_seccion' );
add_action( 'edit_user_profile_update', 'save_field_seccion' );

function save_field_seccion( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    if( isset($_POST['descuento']) ) {
        $descuento = sanitize_text_field($_POST['descuento']);
        update_user_meta( $user_id, 'descuento', $descuento );
    }
}

add_filter('woocommerce_cart_shipping_method_full_label', 'custom_shipping_method_label', 10, 2);
function custom_shipping_method_label( $label, $method ){
    $local_pickup_id = $method->id; // Metodo local pickup (Method Id + ':' + Instance ID)

    // Continua si encuentra local pick up como metodo"
    if( $method->method_id !== 'local_pickup' ) return $label;

    switch ( $method->instance_id ) {
        case '6':
            $txt = __('Ver <a href="https://vigorita.com.ar/tiempo-y-costo-de-envio/" target="_blank"><strong style="color: #C9C19F">Tiempos y costos de envío</strong></a>'); // <= Additional text
            break;
        case '7':
            $txt =  __('Ver <a href="https://vigorita.com.artiempo-y-costo-de-envio/" target="_blank"><strong style="color: #C9C19F">Tiempos y costos de envío</strong></a>'); // <= Additional text
            break;

    }
    return $label . ' ' . $txt . ' ';
}

//Deshabilita el boton comprar en el catálogo de productos
//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );

//remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );

//add_action( 'woocommerce_after_shop_loop_item_title', 'home_loop_features_products', 20 );

//Agrega el nombre de la categoía los productos destacados
function home_loop_features_products(){
    global $product;
    $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
    // Featured product on home page (when using the loop)
    if( $product->is_featured() && is_front_page() && $product_cats )
        $single_cat = array_shift( $product_cats ); 
        echo $single_cat->name;
}

function sv_add_logo_above_wc_product_thumbs() {

    echo '<img src="/wp-content/uploads/2020/01/Pisos-Flotantes-AC4-KronoSwissAC4.jpg" style="margin-bottom: 20px;" />';

}
add_action( 'additional_information_tabs', 'sv_add_logo_above_wc_product_thumbs' );

function tango_custom_product_tab( $tabs ) {
    $tabs['id_tango'] = array(
        'label'   =>  __( 'Tango', 'woocommerce' ),
        'target'  =>  'tango_custom_tab_data',
        'priority' => 60,
    );
    return $tabs;
}

add_filter( 'woocommerce_product_data_tabs', 'tango_custom_product_tab');


add_action( 'woocommerce_product_data_panels', 'tango_prodct_tab_content' );

function tango_prodct_tab_content () {
    global $woocommerce, $post;
    ?>
    <!-- id below must match target registered in above add_my_custom_product_data_tab function -->
    <div id="tango_custom_tab_data" class="panel woocommerce_options_panel">
        <?php
        woocommerce_wp_text_input( array( 
            'id'            => '_id_tango', 
            'label'         => __( 'ID tango', 'woocommerce' ),
            'description'   => __( 'Id Tango del producto', 'woocommerce' ),
            'type'       => 'text',
            'desc_tip'      => false,
        ) );
        ?>
    </div>
    <?php
}
add_action( 'woocommerce_process_product_meta', 'woocommerce_process_product_meta_fields_save' );
function woocommerce_process_product_meta_fields_save( $post_id ){
    $idTango = sanitize_text_field($_POST['_id_tango']);
    update_post_meta( $post_id, '_id_tango', $idTango );

}

function ws_new_user_approve_autologout(){
       if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                $user_id = $current_user->ID;
  
                if ( get_user_meta($user_id, 'pw_user_status', true )  === 'approved' ){ $approved = true; }
        else{ $approved = false; }
  
  
        if ( $approved ){ 
            return $redirect_url;
        }
                else{ //when user not approved yet, log them out
                        wp_logout();
                        wp_clear_auth_cookie(); 
                        return add_query_arg( 'approved', 'false', get_permalink( get_option('woocommerce_myaccount_page_id') ) );
                }
        }
}
add_action('woocommerce_registration_redirect', 'ws_new_user_approve_autologout', 2);
  
function ws_new_user_approve_registration_message(){
        $not_approved_message = '<p class="registration">ACALRACIÃ“N: Su cuenta se mantendrÃ¡ para moderaciÃ³n y no podrÃ¡ iniciar sesiÃ³n hasta que se apruebe.</p>';
  
        if( isset($_REQUEST['approved']) ){
                $approved = $_REQUEST['approved'];
                if ($approved == 'false')  echo '<p class="registration successful;" style="color:green;">Â¡Registro exitoso! Se le notificarÃ¡ una vez aprobada su cuenta.</p>';
                else echo $not_approved_message;
        }
        else echo $not_approved_message;
}
add_action('woocommerce_before_customer_login_form', 'ws_new_user_approve_registration_message', 2);

//Email Notifications
//Content parsing borrowed from: woocommerce/classes/class-wc-email.php
function ws_new_user_approve_send_approved_email($user_id){
  
    global $woocommerce;
    //Instantiate mailer
    $mailer = $woocommerce->mailer();
  
        if (!$user_id) return;
  
        $user = new WP_User($user_id);
  
        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);
        $user_pass  = "Según lo especificado durante el registro";
  
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
  
        $subject  = apply_filters( 'woocommerce_email_subject_customer_new_account', sprintf( __( 'Â¡Tu cuenta en %s ha sido aprobada!', 'woocommerce'), $blogname ), $user );
        $email_heading  = "Usuario $user_login ha sido aprobado";
  
        // Buffer
        ob_start();
  
        // Get mail template
        wc_get_template('emails/customer-account-approved.php', array(
                'user_login'    => $user_login,
                'user_pass'             => $user_pass,
                'blogname'              => $blogname,
                'email_heading' => $email_heading
       ));
  
        // Get contents
        $message = ob_get_clean();
  
        // Send the mail
        wc_mail( $user_email, $subject, $message, $headers = "Content-Type: text/htmlrn", $attachments = "" );
}
add_action('new_user_approve_approve_user', 'ws_new_user_approve_send_approved_email', 10, 1);
  
function ws_new_user_approve_send_denied_email($user_id){
        return;
}
add_action('new_user_approve_deny_user', 'ws_new_user_approve_send_denied_email', 10, 1);

/*
 Muestra el atributo Precio M2 en el single product
 arriba del precio
 */ 
function attribute_by_price_m2_add_content(){
    global $product;
    $precio_m2 = $product->get_attribute( 'pa_precio-m2' );

    $taxonomy   = 'pa_precio-m2';
    $label_name = wc_attribute_label( $taxonomy );

    if (!empty($label_name) )
        // Muestra el nombre del atributo + valor del atributo
        echo '<strong>'.$label_name.': '.$precio_m2. '</strong>';
    }

add_action( 'woocommerce_single_product_summary', 'attribute_by_price_m2_add_content', 18 );

    add_action('woocommerce_shop_loop_item_title', 'wh_insertAfterShopProductTitle', 16);

    function wh_insertAfterShopProductTitle()
    {
        global $product;
    
        $abv = $product->get_attribute('pa_precio-m2');
        if (empty($abv))
            return;
        echo '<b style="color:black;">'.__($abv, 'woocommerce').' m2'.'</b>';
    }


/*************Agregar los atributos a ordenar **************/
 
/**
 * Define los criterios para ordenar con las opciones definidas
 */
add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');
 
function custom_woocommerce_get_catalog_ordering_args( $args ) {
    global $wp_query;
    if (isset($_GET['orderby'])) {
        switch ($_GET['orderby']) :
            case 'pa-precio-m2-asc' :
                $args['order'] = 'ASC';
                $args['meta_key'] = 'pa-precio-m2';
                $args['orderby'] = 'meta_value';
            break;
        endswitch;
    }
    return $args;
}
 
/**
 *  Adds the sorting options to dropdown list .. The logic/criteria is in the method above
 */
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );

add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');
 
function custom_woocommerce_catalog_orderby( $sortby ) {
    $sortby['pa-precio-m2-asc'] = 'Precio M2: de menor precio a mayor precio';
    return $sortby;
}

/**
 *  Save custom attributes as post's meta data as well so that we can use in sorting and searching
 */
add_action( 'save_post', 'save_woocommerce_attr_to_meta' );
function save_woocommerce_attr_to_meta( $post_id ) {
        // Get the attribute_names .. For each element get the index and the name of the attribute
        // Then use the index to get the corresponding submitted value from the attribute_values array.
    foreach( $_REQUEST['attribute_names'] as $index => $value ) {
        update_post_meta( $post_id, $value, $_REQUEST['attribute_values'][$index] );
    }
}
/************ End of Sorting ***************************/




add_filter( 'woocommerce_get_price_html', 'conditional_price_suffix_categories', 20, 2 );
function conditional_price_suffix_categories( $price, $product ) {
    // HERE define your product categories (can be IDs, slugs or names)
    $product_categories = array('pisos-de-madera','pisos-flotantes','pisos-a-prueba-de-agua','porcelanatos','paneleria','cubre-leds','cornisas');
	$products_per_unit = array ('alfombras-sanitizantes','espejos','tratamiento-de-carpetas','zocalos','adhesivos','perfileria-de-aluminio','perfileria-spc');
    $products_per_roll = array ('cesped-sintetico','goma','vinilicos','zig-zag','cushion-mat','mantas-bajo-piso');

    if( has_term( $product_categories, 'product_cat', $product->get_id() ) ){
        $price .= ' ' . __('por caja');
}elseif(has_term( $products_per_unit, 'product_cat', $product->get_id())){
 $price .= ' ' . __('por unidad');
}elseif(has_term( $products_per_roll, 'product_cat', $product->get_id())){
    $price .= ' ' . __('por rollo');
}
    return $price;
}

add_filter( 'woocommerce_get_price_html', 'njengah_text_after_price' );


function njengah_text_after_price($price){
	
	global $post;
		
	$product_id = $post->ID;
	
	$product_array_per_box = array(894,2664);
	$product_array_per_unit = array(888,889,890,891,892,893,895,896,2025,2667,2669,4353,7170,7172,7175,7176,7190,7197,7229,7729,7814,7886,7886,7890,7893,7895,7897,7900,7906,7910,7915,7922);
$product_array_per_bag  = array(7194,7195,7928);

	
	if ( in_array( $product_id, $product_array_per_box )) {
	$price .= ' ' . __('por caja');	  
	}elseif( in_array( $product_id, $product_array_per_unit )){
    $price .= ' ' . __('por unidad');
	}elseif( in_array( $product_id, $product_array_per_bag )){
    $price .= ' ' . __('por bolsa');
	}
	return $price;
}
