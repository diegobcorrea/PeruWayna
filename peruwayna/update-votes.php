<?php 

/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'tottus_pichanga');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'tottus_full');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '=h%wGK+Xm*sU');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
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
define('AUTH_KEY', '8c?UXmJP|qhD>.jT0K-H+,Fc<k}YiKUw!r,tw~-?T$JiV+9F-<>rEH}-_~||AGT2'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', '%Fz20}z:)R-~i7G[&f?m+ :{ve>|@j?1]mlt]Vr-5b,:0gmdklGl-z(ttb+FFSU8'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', '}d*LxM@(JM{&Z:Rm6RO_4(|YRpoBs.V[xBHRyOY--yvrEXGQn^m9m!-Xo>loBFTa'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', '-RyPu57+n8NAz`F-kE_u$+e+m2<_0_;y|}Tq|ndHM(}=Fpe99|!e-)(K_xl}b5c9'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', '@uhEN@Kr^=&^mnL:v:Db-[$F*L(h2c(ta^g1&3EZU64e-YZ]}*o=..Oe;>Ari;}O'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'U(%Wc5.w_lQ-+<-}`;7W5OZ*AeA}:|eeucF;s4AolF%mLPVoO}5cTos6=@]c/H@s'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', '+KM1qe:k5-({.fH =%;9o07TfEx2#:9v>~ }a&yf=0/[L/uCyob$-YI9 9UZ`Nh$'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', '<SQD8]M-q`NBGj|=R/{|y5@A%P,;b6XaJV#??-wpHFv-|6<L>J;h#;8,|a|j`#ow'); // Cambia esto por tu frase aleatoria.

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
  define('ABSPATH', '../../../');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

require_once('../../../wp-load.php');
require_once('../../../wp-includes/wp-db.php');
require_once('../../../wp-includes/pluggable.php');

$ID = $_POST['id'];
$type = $_POST['type'];

global $wpdb;

$query = new WP_Query( array( 'post_type' => 'fichas', 'post__in' => array( $ID ) ) );

while ($query->have_posts()) : $query->the_post(); 

$number = get_post_meta( $post->ID , 'votes_value', true );

if( $type == 'plus' ):
  $new_number = $number + 1;
else:
  $new_number = $number - 1;
endif;

update_post_meta( $post->ID , 'votes_value', $new_number );

echo $new_number;

endwhile;

?>