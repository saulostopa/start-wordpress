<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
    <!-- title -->
    <?php if( is_front_page() ) : ?>
    <title><?php bloginfo('name'); ?></title>
    <?php elseif( is_404() ) : ?>
    <title>Pagina não encontrada - <?php bloginfo('name'); ?></title>
    <?php elseif( is_search() ) : ?>
    <title><?php printf(__ ("Resultados da busca por '%s'", "punchcut"), attribute_escape(get_search_query())); ?> - <?php bloginfo('name'); ?></title>
    <?php else : ?>
    <title><?php wp_title($sep = ''); ?> - <?php bloginfo('name');?></title>
    <?php endif; ?>

    <!-- meta : charset -->
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- always force latest ie rendering engine & chrome frame -->
    <meta http-equiv="X-UA-Compatible"      content="IE=edge,chrome=1">

    <!-- meta : basics -->
    <meta name="author"                     content="Connect Duo - Software & Development - ti@cntd.com.br">
    <meta name="Copyright"                  content="Copyright <?php  bloginfo('name'); echo " ".date("Y"); ?>. Todos direitos reservados.">
    <meta name="description"                content="<?php bloginfo('description'); ?>">
    <meta name="keywords"                   content="">
    <meta name="reply-to"                   content="">
    <meta name="category"                   content="">
    <?php if( is_front_page() ) : ?>
    <meta name="title"                      content="<?php bloginfo('name'); ?>">
    <?php elseif( is_404() ) : ?>
    <meta name="title"                      content="Pagina não encontrada - <?php bloginfo('name'); ?>">
    <?php elseif( is_search() ) : ?>
    <meta name="title"                      content="<?php printf(__ ("Resultados da busca por '%s'", "punchcut"), attribute_escape(get_search_query())); ?> - <?php bloginfo('name'); ?>">
    <?php else : ?>
    <meta name="title"                      content="<?php wp_title($sep = ''); ?> - <?php bloginfo('name');?>">
    <?php endif; ?>

    <meta http-equiv="Cache-Control"        content="no-cache, no-store">
    <meta http-equiv="Pragma"               content="no-cache, no-store">
    <meta http-equiv="expires"              content="Mon, 06 Jan 1990 00:00:01 GMT">
    
	<!-- Metadata -->
	<meta name="DC.title" content="<?php bloginfo('name'); ?>">
	<meta name="DC.subject" content="<?php bloginfo('description'); ?>">
	<meta name="DC.creator" content="Connect Duo - Software & Development - ti@cntd.com.br">    
    
    <!-- Turn off Skype Toolbar -->
    <meta name="skype_toolbar"              content="skype_toolbar_parser_compatible" />
    
    <!-- favicon and icon apple -->
    <link rel="shortcut icon"                           href="<?php bloginfo('template_directory'); ?>/_/img/common/favicon.ico?v=1.0.0" type="image/ico">
    <link rel="apple-touch-icon-precomposed"            href="<?php bloginfo('template_directory'); ?>/_/img/common/apple-touch-icon-144x144-precomposed.png" sizes="144x144">
    <link rel="apple-touch-icon-precomposed"            href="<?php bloginfo('template_directory'); ?>/_/img/common/apple-touch-icon-114x114-precomposed.png" sizes="114x114">
    <link rel="apple-touch-icon-precomposed"            href="<?php bloginfo('template_directory'); ?>/_/img/common/apple-touch-icon-72x72-precomposed.png" sizes="72x72">
    <link rel="apple-touch-icon-precomposed"            href="<?php bloginfo('template_directory'); ?>/_/img/common/apple-touch-icon-57x57-precomposed.png">
    <link rel="shortcut icon"                           href="<?php bloginfo('template_directory'); ?>/_/img/common/apple-touch-icon.png">    

    <!-- meta : viewport -->
    <meta name="viewport"                   content="width=device-width,initial-scale=1">

    <!-- meta : google verification -->
    <meta name="google-site-verification"   content="" />

    <?php wp_head(); ?>

</head>

<body>

    <div id="wrapper">

        <header class="clearfix">
            <a class="logo" href="/" title="<?php bloginfo('name');?>"><img src="/_/img/common/logo-project.png" alt="<?php bloginfo('name');?>" title="<?php bloginfo('name');?>" width="" height="" /></a>

            <hr />

            <nav class="clearfix">
                <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'primary', 'items_wrap' => '<ol>%3$s</ol>' ) ); ?>
            </nav>
        </header>