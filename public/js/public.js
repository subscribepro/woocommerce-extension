jQuery(document).ready(function() {

    jQuery( '#saveinfo' ).parent().hide();

    jQuery( document.body ).on( 'updated_checkout', function() {
        jQuery( '#saveinfo' ).prop( 'checked', true );
        jQuery( '#saveinfo' ).parent().hide();
    });

});