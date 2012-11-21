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
define('DB_NAME', 'santanam_wp_test');

/** MySQL database username */
define('DB_USER', 'santanam_wp1');

/** MySQL database password */
define('DB_PASSWORD', 'Gp^VmjUMiMy^3');

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
define('AUTH_KEY',         'cK/)!1BqVR|ni c^`$}9P3s^(Zn9|(<`]|{&yUo0/p+^5vB)[rmC,QurJDz]z;yv');
define('SECURE_AUTH_KEY',  '|e+1h,%$}jh.~G_Tdn9-LYc6]=pf8t-D3R_<&Ytpc$g7lXFRr5Y)cc|3#5?||,M-');
define('LOGGED_IN_KEY',    '|3On]|f]pN@w{|#E+_,*-E<CWBO6U1x}gQ@8uc3R5v_z+TG;|LpBrnbR-;=t) 7p');
define('NONCE_KEY',        '?vUl~8rwp}{?@}wh+/Ac`})zO?xc|]EdvMJ}[|-@!Mk-;M8=SV}T +V3#GlqYS8D');
define('AUTH_SALT',        'U|R~?gJD$+0%TaFJ[3:q0 Cf*Hb>Ndd_Z[oj]|kBb/V}m4t..qHeZMD?tvtny /5');
define('SECURE_AUTH_SALT', 'y1}q9e}_@;.^zHC$vaPzmz9RSfw gJD*`|/}hr-=a6tu5#Va|k0W-bP{yXV=p0z<');
define('LOGGED_IN_SALT',   'y|pH9QwhlM6&rCct^a||5LXfm8D9%Zx`n*Pj0aM+woNZomfDAmy5,6B#YQ0yPy-f');
define('NONCE_SALT',       '+u7yoel^k4*r:J[8pnjv{Jq8lBQaO$vi/K$25VogpIr?<T7h9U._`[~C-=(Q(8+@');

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
define('WPLANG', '');

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
