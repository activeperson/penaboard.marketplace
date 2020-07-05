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
define ('WPLANG', 'ru_RU');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'penoboard_marketplace' );

/** MySQL database username */
define( 'DB_USER', 'penoboard_marketplace' );

/** MySQL database password */
define( 'DB_PASSWORD', 'penoboard_marketplace' );

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
define( 'AUTH_KEY',         'eu5LSgLz$_1dG6>{`}>ZI0$n1uurW(y|Z3;E-XNi6(PL&61Ul@L#]tKe+~&Jc{xI' );
define( 'SECURE_AUTH_KEY',  '@-#8+g[mnMXafPJ+nM|?l^z4)l)5$zK`vsG&s)R:BA%Tbp&oEqISe,ioK)LUc$4S' );
define( 'LOGGED_IN_KEY',    '8dKWeb_JF7[~lb]-0F#cFnIti&Y%IU[k;A8K3+Q#:5OIqRssXy;F9TdZaTtbs7]p' );
define( 'NONCE_KEY',        'U&BtFq~e75`u[I~0foJ!zqYu!{Gca]d;Z28H<c;tfa3(ppiC|2Oeqm:^wV/9)J;V' );
define( 'AUTH_SALT',        ':FmyNj9xC&r2}?0cZn#p8I6U~[|E;uW8;jr=UL]&[1>)4?xKPnfFuory8&M5%{BY' );
define( 'SECURE_AUTH_SALT', 'UD)~#j>-i`]Zt*L)CeKXQ6B4JS$9T8I`X]%D(7MNvq5 FGy{>]&Gw0->rzp<t8mG' );
define( 'LOGGED_IN_SALT',   '2o {POE/)sUQ!2&U{ZD[Zb-D87vo.5oH]HDrgyBgaN:ESheTc: VIodV!!8}$-ie' );
define( 'NONCE_SALT',       'WrSG<RuOTDkT/](GjW5NC=*onk7TM#Q4U{9IeU)K~WvZD #~l}y[rS]*P.VY$guV' );

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
