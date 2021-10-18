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
define( 'DB_PASSWORD', 'f68399dad8e4095b531df6df4d5c5f48a5701e97f2861d3d' );

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
define( 'AUTH_KEY',         'n|F]1?s~J TT*SB.Pn9#iAw]Zsk(dLLiaD8Fqq=7tOnfGT7=c#H9nB%e2(hA[kR_' );
define( 'SECURE_AUTH_KEY',  'c!7Q (:f+zk(gjkw+X/<>mk3j%>9f3Wu+#VfBk-^8.U1)$D,Y4aa1rBzOc.D4QQL' );
define( 'LOGGED_IN_KEY',    '+co($-W=~]m&c!;=4a2y.uvJLcy9K-(Pnkye}[P#ut6565CTEA!N[OwhmS}Y=5/V' );
define( 'NONCE_KEY',        'RAcn2kG)>wSiwOcQ}.1pGOHDf*  j?73T-VvNU:o*,=gC#wOL%/.k~0:ZA@&7`zw' );
define( 'AUTH_SALT',        'zRKh+1g[JsiS-~J&!ZF45H5)fF(39x44-`pr5m*nwjK7<T$.$mT*tYEq]PS^NL7s' );
define( 'SECURE_AUTH_SALT', 'bi@81:Ne:dayg/XChH!N!F(uF+0<~dwMtmPOG-D8!F>nOEXlXC;Y.T@&,+DoWaW(' );
define( 'LOGGED_IN_SALT',   'tz&[qp0Q~6WTqIKr@6R8I{Gj?I7p#=2acD$Q 2@.s)Y u|3,t~ejI ~+EtK_`Diy' );
define( 'NONCE_SALT',       'Eq*<_|<z8^zIZ-<{`V4J)Z3^J}B.kRC}X1*J6bROu@HjC/c8KMt;LqOpV<$*Ki~K' );

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
