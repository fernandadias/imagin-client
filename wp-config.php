<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa user o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'imagin');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'imagin');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'D#tbl5X+fR4H,');

/** Nome do host do MySQL */
define('DB_HOST', 'mysql745.umbler.com');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'xTLh)04[_W6O#NwGSmkrA(wNI{`3|1q4C+|[R&?`}9V>RE{F:h(,#zgqeloL=v7;');
define('SECURE_AUTH_KEY',  'P9Osz34XYdSPkEPGIiR,{pz^hT}P(L?l.K:<`#kZKZ5icHx%1-!dFj5vnnlCSSJ]');
define('LOGGED_IN_KEY',    'pFFdfM{[4y(O=A(t*[SSy=E!eiJ9>c(S8x36K)YT$IWVE=`d}$X62zyqTgQ5k80O');
define('NONCE_KEY',        '^)o_a_Kd)8R/~-*Nq6YPeLANO_7.+>F0u;l=K)r;fifz4F8FP8jUZrP;@*N(*cVh');
define('AUTH_SALT',        'k966[N]=9B1eKEi~c.d )o<Vw&D*FL?M-zX5>%{Xm%])Llw$I{|hcRv7B|;}JgE%');
define('SECURE_AUTH_SALT', '1p/enZJ^|za40Gxq%+84X~?nj-5Wa+Dah>f-?xS<o&>A{ceTFoc45oGgpo^Rk Y^');
define('LOGGED_IN_SALT',   '9bz=h,T`]tB5QUV2)hJU3z9Z+LJok5-:;Bg#p>1sPl[y ;b%!gJu29T6&H6_[QJ>');
define('NONCE_SALT',       'p OKH;DyN4LG^uJHVOL2}:?u| Cfb[e?6)IDt[Yn61hGoQM+];~a*qR!j|bDdD-h');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * para cada um um único prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
