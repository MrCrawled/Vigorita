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
define( 'DB_NAME', 'vigorita');

/** MySQL database username */
define( 'DB_USER', 'root');
/** MySQL database password */
define( 'DB_PASSWORD', 'root');

/** MySQL hostname */
define( 'DB_HOST', 'db');

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

	
define( 'WP_HOME', 'http://vigorita.local:8080' );
define( 'WP_SITEURL', 'http://vigorita.local:8080' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '9b4784975b168b7420ed6e0b77c30c9dff5a2734');
define( 'SECURE_AUTH_KEY',  '66432228786d039e9dfff4cfa8d4d76d5f054ac9');
define( 'LOGGED_IN_KEY',    'c2f8b46056f4b882b9e0e52fd992bc7b440bf181');
define( 'NONCE_KEY',        '683ee96611c82501d9ef2b38afd5b5c6e4dbb944');
define( 'AUTH_SALT',        '75ae133f1f6a8d1f2ea3d74c680666a48b72fd15');
define( 'SECURE_AUTH_SALT', 'c71dcd44f9caa2367266a8d4da85b781d811553b');
define( 'LOGGED_IN_SALT',   '4af0ba0c27ffb364b0424568eb889ecb7d3e2375');
define( 'NONCE_SALT',       '4ff254aa808c4c604169543c9d397ec85618fd1a');

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

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
