<?php


function register_finalized_order_status() {
    register_post_status( 'wc-finalized', array(
        'label'                     => 'Finalizada',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Finalizada <span class="count">(%s)</span>', 'Finalizada <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_finalized_order_status' );

function add_awaiting_finalized_to_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-finalized'] = 'Finalizada';
        }
    }
    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_awaiting_finalized_to_order_statuses' );