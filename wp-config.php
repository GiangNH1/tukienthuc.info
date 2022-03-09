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
define( 'DB_NAME', 'vupbykxkhosting_46' );

/** MySQL database username */
define( 'DB_USER', 'vupbykxkhosting_46' );

/** MySQL database password */
define( 'DB_PASSWORD', 'oa!p-Sn351' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'k4mru51aztnsxbo5peqonqjcgxa0yojmiaxcgfezpbkd6jyyx6k55wrl8tm9kqfq' );
define( 'SECURE_AUTH_KEY',  'lmmosgbbf9fmnehwfwdtqf0rw5jvm2xg1oywghdxvdrb8qlbksjcpcuu9krgqpjp' );
define( 'LOGGED_IN_KEY',    '0kv1qpagl9mrasfoxqaeupfrmompg8aa8yohu4t8hjq24d44w0cn1nns188luqt4' );
define( 'NONCE_KEY',        'f4p0mn275lkjmraunos0z0x4nceey2tjfdag4ydfgwrztnhotpmcub4hotklsk6z' );
define( 'AUTH_SALT',        '2zgt4jnyudgp4qjipxbmi7jxtap7nyttbiadtqpuychtlobghferx4isu9l8anme' );
define( 'SECURE_AUTH_SALT', '0svfhqcrvsdxo2h4zbk9cxoc0elln6ci6p9n7gu5rwrmtelic7wb9w6zgoj9g4c3' );
define( 'LOGGED_IN_SALT',   'x7eu1byywrtm3r5oxydhgcyfrug8wiqp0rsnevsnxff7hgizcoweazj4tmyrvi5n' );
define( 'NONCE_SALT',       '4b2xgz4ylhbdxqlkmcg6cvd1xyrmeq9pwtc2ow8ddn1m8naymsic8qdtcmytxsok' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpr7_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
