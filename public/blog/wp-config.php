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
define( 'DB_NAME', "ebdb");

/** MySQL database username */
define( 'DB_USER', "rewards" );

/** MySQL database password */
define( 'DB_PASSWORD', "PerkSweet23" );

/** MySQL hostname */
define( 'DB_HOST', "aaii6l08pswvos.cfd0n89ycgr6.us-east-1.rds.amazonaws.com");

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
define( 'AUTH_KEY',         '%6pX;CE75A9y]_V&/YU(j5d]ifhi?VTkxNU:aITGc~#r:yR2On8wz?V6%.<7?g_ ' );
define( 'SECURE_AUTH_KEY',  '-9zxh#UcN,BGK-[=tHg0(6a~llfAIX a!2q&;gaP_~c1!}cMy#V+QZkVTE>&~Bmk' );
define( 'LOGGED_IN_KEY',    '+BwM!HYw/5dw7oZG34&#cwdY vZ7zh^43<-2/lFlsR2xgtl. yyO`wN3M)>8lHG`' );
define( 'NONCE_KEY',        '3`3,9bV CLsNR(?lUTGmtIQqJ9tbxhC%lanj5Hm*WE#o,0DQo%NL=wi[=szgRKUn' );
define( 'AUTH_SALT',        ';D) n!yD+ees_+jKFy/IrfZV8d#py(UPdhHpalMmb8+2QI_#cLmz5xt2~S;i}5lA' );
define( 'SECURE_AUTH_SALT', '%cBFg3?7VnMD80%+-=eAN_zGL~]pQy1#/]xf1P*b4y}#ypqn(8,RnT1z@QzE>KCj' );
define( 'LOGGED_IN_SALT',   'M|Z+ec{Oa#-dwkTvAOKi&c6o9^#d,qCFWga3XYp8)$-Y?<V1g/-F*1qv%^[-Hhl3' );
define( 'NONCE_SALT',       'n6V65Pjx=W&X@@L;-Dt6eB@WxrU[u;}QoylyYh{lJ_OO?pn}]x47v^?v9c7 }a,f' );

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
