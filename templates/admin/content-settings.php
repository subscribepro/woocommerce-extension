<?php 

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;
?>

<style>

    .spro-input {
        min-width: 475px;
    }

</style>

<div class="wrap">

    <h2>Subscribe Pro <?php esc_attr_e('Options', 'spro' ); ?></h2>

    <form method="post" name="spro_settings" action="options.php">
        <?php

        //Grab all options
        $options = get_option( 'spro_settings' );

        $base_url = ( isset( $options['base_url'] ) && ! empty( $options['base_url'] ) ) ? esc_attr( $options['base_url'] ) : 'https://api.subscribepro.com';
        $client_id = ( isset( $options['client_id'] ) && ! empty( $options['client_id'] ) ) ? esc_attr( $options['client_id'] ) : '';
        $client_secret = ( isset( $options['client_secret'] ) && ! empty( $options['client_secret'] ) ) ? esc_attr( $options['client_secret'] ) : '';

        settings_fields( 'spro_settings' );
        do_settings_sections( 'spro_settings' );

        ?>

        <fieldset>
            <p><?php esc_attr_e( 'Base URL', 'spro' ); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e( 'Base URL', 'spro' ); ?></span>
            </legend>
            <input type="text" class="spro-input" id="base_url" name="base_url" value="<?php if( ! empty( $base_url ) ) echo $base_url; else echo ''; ?>"/>
        </fieldset>

        <fieldset>
            <p><?php esc_attr_e( 'Client ID', 'spro' ); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e( 'Client ID', 'spro' ); ?></span>
            </legend>
            <input type="text" class="spro-input" id="client_id" name="client_id" value="<?php if( ! empty( $client_id ) ) echo $client_id; else echo ''; ?>"/>
        </fieldset>
        
        <fieldset>
            <p><?php esc_attr_e( 'Client Secret', 'spro' ); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e( 'Client Secret', 'spro' ); ?></span>
            </legend>
            <input type="password" class="spro-input" id="client_secret" name="client_secret" value="<?php if( ! empty( $client_secret ) ) echo $client_secret; else echo ''; ?>"/>
        </fieldset>

    <?php submit_button( __( 'Save all changes', 'spro' ), 'primary','submit', TRUE ); ?>

    </form>
</div>