<?php
/**
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */


define('WP_DEFAULT_THEME', 'name-theme');


/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-db-define.php');


/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '8fnx-.xNl)P*e[!yye:3M uy;X9Jk0BUvxlT(R!#a)>*8CGfh5pTc_B5NuPoM.;n');
define('SECURE_AUTH_KEY',  '|)DCC+K--OLMu+UH+m,Y*~L05x4wbV+|T^-JD>rLRWOkcr)>RO;r{+u@Q-*U.A^=');
define('LOGGED_IN_KEY',    ')IQp!/)w|V}>UPp1*[f `W1Qqy0#e9>-0+kGpar( khBSjU!4rcP||dXhEO_?T%{');
define('NONCE_KEY',        '/x-9P:uJ.~e5EOQ0xdK4l>am1@!s8@-s5-@wW6!+o[Nu!{<G++}Z i6;s71|V+C+');
define('AUTH_SALT',        'oR||A&4i,)qL7M!NV!;J0_)01p9/$5OfEx>b}+/R?+|Sqd/{nb8=x/+GE%Eum)@3');
define('SECURE_AUTH_SALT', '}r}Ha5)S8CfPWTR^i~5qVdBKb1acS7!D_mjjrW^R~!v3K%BH.q%z^SV|L)pHa{jD');
define('LOGGED_IN_SALT',   '{7!,M%:1^-mex+HWTm#.SLoQ!?*R$*{g6l1F@b|`+c|CNxK^9oP}|x+X+Z>&vt2I');
define('NONCE_SALT',       ':[6*B53b(SB,-o]E#(MZ{%]nDnzkKwrWRey`:J%iyh&yQ!7T77H1r?|1w,h*03t+');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');