<?php 
require_once plugin_dir_path(__FILE__).'/includes/add_custom_checkout_fields.php';
require_once plugin_dir_path(__FILE__).'/includes/change_text_thankyoupage.php';
require_once plugin_dir_path(__FILE__).'/includes/add_custom_fields_order_received.php';
require_once plugin_dir_path(__FILE__).'/admin/custom_woocommerce_admin_order_data.php';

    /*
    Plugin Name: Custom Checkout Vigorita
    Description: El plugin crea campos personalizados en el checkout que son requeridos por el ERP Tango para poder realizar la sincronización entre ambos.
    Muestra estos campos al finalizar la compra y en el panel de administración dentro de los pedidos.
    También, modifica el nombre de campos que vienen por default.
    Author: Folder I.T.
    Version: 1.0
    Author URI: https://folderit.net
    */



    defined('ABSPATH') or die("Adios");
?>