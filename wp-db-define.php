<?php
$serverName     = $_SERVER['SERVER_NAME'];
$dev            = 'dev.fatto-criativo.com.br';
$qa             = 'www.site.nuova2.com';
$homolog        = 'site.nuovacomunicacao.com';
$prod           = 'www.site.com.br';

switch ($serverName) {
    case $dev       :
        define('DB_HOST',       'localhost');
        define('DB_NAME',       'fatto_criativo');
        define('DB_USER',       'root');
        define('DB_PASSWORD',   'admin');
        break;
    case $qa        :
        define('DB_HOST',       'endereco');
        define('DB_NAME',       'database');
        define('DB_USER',       'database');
        define('DB_PASSWORD',   'database');
        break;
    case $homolog   :
        define('DB_HOST',       'endereco');
        define('DB_NAME',       'database');
        define('DB_USER',       'database');
        define('DB_PASSWORD',   'database');
        break;
    default    :
        define('DB_HOST',       'endereco');
        define('DB_NAME',       'database');
        define('DB_USER',       'database');
        define('DB_PASSWORD',   'database');
        break;
}

define('WP_HOME',       'http://' . $_SERVER['SERVER_NAME']);
define('WP_SITEURL',    'http://' . $_SERVER['SERVER_NAME']);

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');
?>