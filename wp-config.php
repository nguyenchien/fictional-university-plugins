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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
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


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}


define('AUTH_KEY',         'xAq8wIo4ONDyNP8vnj5I3zGsQjSDgFFcXjrSjr1KYDfdQQdaJSNINMng6tI4Npbqlkpuyb3oFjTh1N7mdWoYQA==');
define('SECURE_AUTH_KEY',  'BnAF+1yQVkx6LQ/4/hrT8BTPD4jWa0fwjKJs+dq9izzOnttf0TyesfsYoMiwQU7uWh0iVq4LvD090BKTDnkiIA==');
define('LOGGED_IN_KEY',    'Y/lfRf9Cs/ejTlyDgz6m2jKu2oq62JdtgeMHFFMEM7uncB+dzt5NIKwsNBPr20yQ+T+AJKGKeNxagYkuQb/syw==');
define('NONCE_KEY',        'dRSlht+olD3lv/6dtVlibze2OffX4Xg944riA9Z7B2bGcAHPAEAFuFAHmGNUJIVcW2Au/cgAaI0HkWHDXdL0cg==');
define('AUTH_SALT',        'Smn4IDpuMbwZMNxceauvduEpVQp6P3EYqXJb1XkC6wCfEKKvO7tPBR3lR4a/H+KP11+PkQH1XEAxkgOjv/A63g==');
define('SECURE_AUTH_SALT', 'Xvbg+PEl+IVLRAeZmXw8e8PsgH+GbZzHeJ91Qsme9vtfT5+5yNUZk5AEGtMNMZ0lS0iJd4pg7CEHdfS/JRyNng==');
define('LOGGED_IN_SALT',   'qU0+x/nHhfff6w3qgKb6+v1kklV6M/S/rU0CEjhB90bfzHy3XY33C5uPRZS7nynUX/yHg6FZb5afiNNwDsPf7A==');
define('NONCE_SALT',       'TdtzF8ILItqCNIvylcmYsw+POumJo267/VNhrDxnEcAHP8P+KkCV/9w/PrIm+QLscx7fblM0+yR1ec9DDtbjSg==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
