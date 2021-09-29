<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'd74595e5c0d40231346c33ed2715c06f612aa53ba48220ec' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Dlw8:Yl6`=9=5*TEf9F$.o I}xpT: X}60I!lg[6(3w]rkTtR1PS3@ed0Dm]Y:`F' );
define( 'SECURE_AUTH_KEY',  '-LN0fO2{biOat,?q.OA@}BAh{9nhC<^s7-1hpVIraVZxRBf*iS:)(z^@=IUExLlP' );
define( 'LOGGED_IN_KEY',    '$2}4V*L>R2IA?QI:77pqDTEXU#Db)^KYXM<Mq5NNtx|7w|x;#QN u*a!)QY%>bGZ' );
define( 'NONCE_KEY',        'k||H2^MW5D<EPlz;^L_y9i&.f)MyQtr%)&6OWw}[H7__Jl}pqxMT=jd sqQZ7,PW' );
define( 'AUTH_SALT',        '6ogczxiNx1k(Uz:M5/tWQi0<>JAP_$TokvdBP>sr%PTqXQ!zLv,oZw+fbDAPZ1s3' );
define( 'SECURE_AUTH_SALT', '&Ra[DW^okh<-(mvbBmn]U25R{fz+&Z 0q[=7elZ-P`LSX>*l{CA&uXwDXS5pzCl*' );
define( 'LOGGED_IN_SALT',   'da/h~kX)x@*G-y-*&mT$2?h-wMJnJ+d m22LX_n.t*2Q_v%R.S?iAA-v!QB=+C(W' );
define( 'NONCE_SALT',       'TVgSq%;VBJEJ&E[u5_3h~p<RP=hW%4]qA~5xAuEKnysl^=>h5_.,Bog3+JPPCV4A' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

/* Add any custom values between this line and the "stop editing" line. */

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
