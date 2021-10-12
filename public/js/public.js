jQuery(document).ready(function() {

    jQuery( '#saveinfo' ).parent().hide();

    jQuery( document.body ).on( 'updated_checkout', function() {

        jQuery( '#saveinfo' ).parent().hide();

        if ( jQuery('body.logged-in').length > 0 ) {

            jQuery( '#saveinfo' ).prop( 'checked', true );
            
        }

    });

});