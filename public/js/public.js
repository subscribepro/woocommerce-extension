jQuery(document).ready(function() {

    jQuery( '.woocommerce-checkout #saveinfo' ).parent().hide();

    jQuery( document.body ).on( 'updated_checkout', function() {

        jQuery( '.woocommerce-checkout #saveinfo' ).parent().hide();

        if ( jQuery('body.logged-in').length > 0 ) {

            jQuery( '.woocommerce-checkout #saveinfo' ).prop( 'checked', true );
            
        }

    });

});