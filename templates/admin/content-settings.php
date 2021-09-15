<?php 

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;
?>

<style>

    .spro-input {
        min-width: 475px;
    }

    .connection-buttons {
        display: flex;
        margin-top: 30px;
    }

    .connection-buttons .submit {
        margin: 0;
        padding: 0;
    }

    .connection-buttons .action {
        margin-right: 10px;
    }

    .connection-message {
        margin-top: 15px;
        font-size: 18px;
    }

    .connection-message.success {
        color: green;
    }

    .connection-message.fail {
        color: red;
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

        <div class="connection-buttons">
            <a href="#" class="button action test-con-btn">Test Connection</a>

            <?php submit_button( __( 'Save all changes', 'spro' ), 'primary','submit', TRUE ); ?>
        </div>

        <div class="connection-message"></div>


    </form>

    <script type="text/javascript">

        jQuery(function($){

            console.log('ready 2');
        
            jQuery('.test-con-btn').click(function(e) {

                e.preventDefault();

                jQuery(this).text('Testing....');

                // Make AJAX Request
                wp.ajax.post( "test_connection", {} )
                .done(function(response) {
                    
                    if (response == 'success') {
                        jQuery('.connection-message').addClass('success');
                        jQuery('.connection-message').text('Connection successful!');
                    } else {
                        jQuery('.connection-message').addClass('fail');
                        jQuery('.connection-message').text('Connection failed!');
                    }


                    jQuery('.test-con-btn').text('Test Connection');

                });

            });

        });

    </script>

</div>