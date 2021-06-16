<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'db_portal' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'n!YOC@^c]ENci4( n5|a,=og9nesU7v$]TJpDJ1z1(uZ^0`adnM.LEI1q)R#MtNg' );
define( 'SECURE_AUTH_KEY',  '[![5iml=%}H%@@C4^>jtnu$~#UQkRqQVfoZ0r1Ub|OHahtQ}%c,rt{~yE4x$f3<%' );
define( 'LOGGED_IN_KEY',    'QKa/n-2|:e]G7sJrvHoI;{Q_7?<e+dX1?gcc$cl~-,9P}X8A|&brWJFi-8G]7e7T' );
define( 'NONCE_KEY',        'q0)XLBn=r(7KvX}/=FWK1{HG#&%XJL0P;-WP*.lM=kCrV-JOk._]9}eA`F(8>Z J' );
define( 'AUTH_SALT',        'b4^9v=r%{ydN9]d*H{%$Ek`RR_7QAn~ov9XHR{F[:lm`L{UDYcgg%iNl$ocrTJ_z' );
define( 'SECURE_AUTH_SALT', 'mVpume}JVa{fQ!jsCuT%q6+::R4PLI?*WQ:A)GZqtV_X; %=YdkM5!o3Z8HBir[$' );
define( 'LOGGED_IN_SALT',   '8x; So2y4=.uhW=Ds!{iBpG@iusQD;=8J3s?xO9!np,O/QX|.s9+@*q=M/va_R#3' );
define( 'NONCE_SALT',       'AZ68xa[ST@!k>AjVnp-#s?EyilUbxI+Q&U-)CDm{Ie_twXa5%.Nb(&r>F`0AF4gP' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
