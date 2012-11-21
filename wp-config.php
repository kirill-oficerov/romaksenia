<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'santanam_wp1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
$base = '/';
define('DOMAIN_CURRENT_SITE', 'wedigital.by');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
define('WP_ALLOW_MULTISITE', true);

define('FS_METHOD','direct');
define('AUTH_KEY',         'v82ucjNsWnmbWLPd62itb3fv0DwowEyNlbN2hqyDFvO1JLb6yt7BNK1YmogOJKYI');
define('SECURE_AUTH_KEY',  '0X77Y5RzkHyXUa7vaDTQ8iwETOMc2Rtf31bv124nwQlFAI4237vBTafsJ9LkNeIZ');
define('LOGGED_IN_KEY',    'jNCVjKBR3l4ct4EriPvaSUjxahCf56ET7K4hrdPvlFPd6j3ZqmpIFmzEHf2liIL4');
define('NONCE_KEY',        'u2Ie4XTIHWfC4MNMhJKME0KRL0rLAMVIbdd71JcM2hQexifunwdbenYIo1uGeDRt');
define('AUTH_SALT',        'YxPeYeEZiPR18TkErfnn3K5RAtZJ63gblYtxiAhRSSWAxQKX1q2WGhT1HxxWPSBV');
define('SECURE_AUTH_SALT', 'AcNIfAMGoIjiApHCPlxiW33GtkD76LGprHMA1MxKvXZz9BV7Qg8K3Moc5oaSb194');
define('LOGGED_IN_SALT',   'k0qZFIZCIA2upjE1yzUY7Cc0eRYQnnUgtQeULvGBj9cmoEqOP5v4HQFqfRs4EbHp');
define('NONCE_SALT',       'DlADuQOeltZOrcXoAGvmKyp6XdTRagZfVgijIIyaX5waiKMMqutYvFPQ4U0jWnbZ');
define('WP_TEMP_DIR',      '/home/santanam/wedigital.by/wp-content/uploads');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'ru_RU');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
