<?php
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
		'footer' => __( 'Footer Menu', 'twentyten' ),
		'agencia' => __( 'Agência Menu', 'twentyten' ),
	) );


}
endif;


function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return '';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */


/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'twentyten' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'twentyten' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'twentyten' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'twentyten' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'twentyten' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'twentyten' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;



// ############## Custom functions NUOVA ##############


    // remove itens menu for uses
    function remove_menus () {
        if (!current_user_can( 'edit_themes' )) {
            global $menu;
            $restricted = array(
                // __('Dashboard'),
                __('Posts'),
                __('Media'),
                __('Links'),
                // __('Pages'),
                // __('Appearance'),
                __('Tools'),
                // __('Users'),
                __('Settings'),
                __('Comments'),
                // __('Plugins')
            );

            end ($menu);
            while (prev($menu)){
                $value = explode(' ',$menu[key($menu)][0]);
                if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
            }
        } else {
            return false;
        }
    }
    add_action('admin_menu', 'remove_menus');
    // end

    //Remove os itens do dashboard
    function remove_dashboard_widgets() {
        global $wp_meta_boxes;
    	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    }
    add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


    //Adiciona contagem no painel agora na area do admin
    add_action('right_now_content_table_end', 'post_type_totals_rightnow');
    function post_type_totals_rightnow() {
        $post_types = get_post_types( array( '_builtin' => false ), 'objects' );
        if (count($post_types) > 0)
        foreach( $post_types as $pt => $args ) {
            if($pt == 'acf') continue;
            else {
                $url = 'edit.php?post_type='.$pt;
                echo '<tr><td class="b"><a href="'. $url .'">'. wp_count_posts($pt)->publish .'</a></td><td class="t"><a href="'. $url .'">'. $args->labels->name .'</a></td></tr>';
            }
        }
    }


    // Order menu admin
    function custom_menu_order($menu_ord) {
        if (!$menu_ord) return true;
        return array(
            'index.php', // aba principal do painel
            'edit.php', // esta Ã© a aba padrÃ£o de psotagem
            'edit.php?post_type=page',
            'edit.php?post_type=cliente',
            'edit.php?post_type=portfolios'
            // 'edit.php?post_type=bebidas',
            // 'edit.php?post_type=promocao',
        );
    }
    add_filter('custom_menu_order', 'custom_menu_order');
    add_filter('menu_order', 'custom_menu_order');
    // Aplicamos o fintro da funÃ§Ã£o e pronto, menu organizado.


    //Custom Post Types **** PORTFOLIO ****
    add_action('init', 'portfolio_register');
    function portfolio_register(){

        $labels = array(
            'name' => _x('Portfolio', 'post type general name'),
            'singular_name' => _x('Portfolio Item', 'post type singular name'),
            'add_new' => _x('Adicionar novo', 'portfolio item'),
            'add_new_item' => __('Adicionar novo item no Portfolio'),
            'edit_item' => __('Editar item do portfolio'),
            'new_item' => __('Novo item no portfolio'),
            'view_item' => __('Ver item do portfolio'),
            'search_items' => __('Busca no portfolio'),
            'not_found' =>  __('Nenhum item encontrado'),
            'not_found_in_trash' => __('Nada foi encontrado na lixeira'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'public_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => get_stylesheet_directory_uri() . '/_/img/common/ico-port.png',
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title','editor','thumbnail','comments', 'excerpt', 'custom-fields', 'revisions', 'trackbacks')
        );

        register_post_type( 'portfolios' , $args );
        flush_rewrite_rules();
    }
    // Register taxonomy
    register_taxonomy("portfolio", "portfolios",
    array(
        "label" => "Categorias",
        "singular_label" => "Categoria",
        "rewrite" => true,
        "hierarchical" => true
    ));
    // end


    //Custom Post Types **** CLIENTES ****
    add_action('init', 'clientes_register');
    function clientes_register(){

        $labels = array(
            'name' => _x('Clientes', 'post type general name'),
            'singular_name' => _x('Cliente Item', 'post type singular name'),
            'add_new' => _x('Adicionar novo', 'cliente item'),
            'add_new_item' => __('Adicionar novo item em clientes'),
            'edit_item' => __('Editar item dos clientes'),
            'new_item' => __('Novo item em clientes'),
            'view_item' => __('Ver item dos clientes'),
            'search_items' => __('Busca em clientes'),
            'not_found' =>  __('Nenhum item encontrado'),
            'not_found_in_trash' => __('Nada foi encontrado na lixeira'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'public_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => get_stylesheet_directory_uri() . '/_/img/common/ico-clients.png',
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title','editor','thumbnail','comments', 'excerpt', 'custom-fields', 'revisions', 'trackbacks')
        );

        register_post_type( 'cliente' , $args );
        flush_rewrite_rules();
    }

    // Register taxonomy
    register_taxonomy("cliente", "cliente",
    array(
        "label" => "Categorias",
        "singular_label" => "Categoria",
        "rewrite" => true,
        "hierarchical" => true
    ));
    // end


    // remove junk from head
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    // admin_bar


    // Disable the Admin Bar.
    add_filter( 'show_admin_bar', '__return_false' );
    remove_action( 'personal_options', '_admin_bar_preferences' );
    // end


    //Remove Class Menu
    add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
    add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
    function my_css_attributes_filter($var) {
        if(is_array($var)){
            $varci= array_intersect($var, array('current-menu-item'));
            $cmeni = array('current-menu-item');
            $selava   = array('active');
            $selavaend = array();
            $selavaend = str_replace($cmeni, $selava, $varci);
        }
        else{
            $selavaend= '';
        }
    return $selavaend;
    }
    //end

    // function wp_list_categories_remove_title_attributes($output) {
        // $output = preg_replace('` title="(.+)"`', 'title="Ver Itens"', $output);
        // return $output;
    // }
    // add_filter('wp_list_categories', 'wp_list_categories_remove_title_attributes');


    //Modifica o link para a logo na página de login do Wordpress
    function custom_loginpage_logo_link($url) {
    	return get_bloginfo('wpurl');
    }
    add_filter("login_headerurl","custom_loginpage_logo_link");


    //Modifica o titulo da logo na pagina de login do Wordpress
    function custom_loginpage_logo_title($message) {
    	return get_bloginfo('name');
    }
    add_filter("login_headertitle","custom_loginpage_logo_title");


    //Remove wp logo do footer admin
    function remove_footer_admin () {
    $ano  = date('Y');
    echo '&copy; Nuova | inteligência + comunicação + tecnologia '. $ano .' - Todos direitos reservados';
    }
    add_filter('admin_footer_text', 'remove_footer_admin');


    //Troca o tema padrao do admin
    function my_admin_head() {
        echo '<link rel="stylesheet" type="text/css" href="/_/css/section/custom-admin.css">';
        if (!current_user_can( 'edit_themes' )) {
            echo '<link rel="stylesheet" type="text/css" href="/_/css/section/custom-user.css">';
        }
    }
    add_action('admin_head', 'my_admin_head');


    //Alteracao do email padrao do wordpress
    add_filter ("wp_mail_from", "nuova_mail_from");
    add_filter ("wp_mail_from_name", "nuova_mail_from_name");

    function nuova_mail_from() {
        return "contato@nuova.com.br";
    }
    function nuova_mail_from_name() {
        return "Site nuova!";
    }


    //Total de items do portfolio - para poder fazer a paginacao na single-portfolios.php
    $totalDePortfolio = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'portfolios'");
    if (0 < $numposts) $totalDePortfolio = number_format($totalDePortfolio);


    //Coluna customizada na pagina de posts - CASE
    add_filter('manage_edit-portfolios_columns', 'add_columns');
    function add_columns($columns) {
        $columns['case'] = 'Case';
        $columns['destaque'] = 'Destaque';
        $columns['categorias'] = 'Categorias';
        unset($columns['comments']);
        return $columns;
    }

    //Remove a coluna de comentarios dos posts -  Clientes
    add_filter('manage_edit-cliente_columns', 'remove_columns');
    function remove_columns($columns) {
        unset($columns['comments']);
        return $columns;
    }

    //Adiciona os valores nos novos campos
    add_action('manage_posts_custom_column',  'case_show_columns');
    function case_show_columns($name) {
        global $post;
        switch ($name) {
            case 'case':
                $case = get_post_meta($post->ID, 'port_case', true);
                echo ($case) ? '<input type="checkbox" class="case-port" checked data-id="'. $post->ID .'" />' : '<input type="checkbox" class="case-port" data-id="'. $post->ID .'" />';
                break;

            case 'destaque' :
                $destaque = get_post_meta($post->ID, 'port_dest', true);
                echo ($destaque) ? '<input type="checkbox" class="dest-port" checked data-id="'. $post->ID .'" />' : '<input type="checkbox" class="dest-port" data-id="'. $post->ID .'" />';
                break;
            case 'categorias' :
                $taxonomy = 'portfolio';
                $termos   = get_the_terms($post->ID, $taxonomy);

                if (!empty($termos)) {
                    foreach ( $termos as $termo )
                        $post_termos[] = $termo->name;
                    echo join(', ', $post_termos);
                }
                else echo '';
        }
    }

    //Registra script na pagina de admin
    function nuova_admin_js($hook) {
    	if ($hook == 'post.php' || $hook == 'post-new.php') {
    		wp_register_script('nuova-admin', '/_/js/common/jquery.custom.admin.js', 'jquery');
    		wp_enqueue_script('nuova-admin');
    	}
    }
    add_action('admin_enqueue_scripts','nuova_admin_js',10,1);

    //Adiciona o jquery de ajax do destaque do portfolio
    function ajax_destaque_portfolio($hook) {
        global $post;
        if ($hook == 'edit.php') {
            if ('portfolios' === $post->post_type) {
                wp_enqueue_script('ajax_portfolio', get_bloginfo('wpurl').'/_/js/common/ajax_portfolio.js');
            }
        }
    }
    add_action('admin_enqueue_scripts', 'ajax_destaque_portfolio', 10, 1);


    //Funcao para fazer o update do ajax no banco de dados
    function atualiza_destaque_portfolio() {
            $id    = $_POST['id'];
            $valor = $_POST['val'];
            update_post_meta($id,'port_dest',$valor);
    }
    add_action('wp_ajax_atualiza_destaque_portfolio', 'atualiza_destaque_portfolio');
    add_action('wp_ajax_nopriv_atualiza_destaque_portfolio', 'atualiza_destaque_portfolio');

    //Funcao para retornar o total de destaques selecionados
    function total_destaque() {
        global $wpdb;

        $totalDestaque = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->postmeta WHERE meta_key = 'port_dest' AND meta_value = 1");
        if (0 < $numposts) $totalDestaque = number_format($totalDestaque);
           die($totalDestaque);
    }
    add_action('wp_ajax_total_destaque', 'total_destaque');
    add_action('wp_ajax_nopriv_total_destaque', 'total_destaque');

    //Funcao para fazer o update do ajax no banco de dados
    function atualiza_case_portfolio() {
            $id    = $_POST['id'];
            $valor = $_POST['val'];
            update_post_meta($id,'port_case',$valor);
    }
    add_action('wp_ajax_atualiza_case_portfolio', 'atualiza_case_portfolio');
    add_action('wp_ajax_nopriv_atualiza_case_portfolio', 'atualiza_case_portfolio');


    // Remove pages from search
    function mySearchPostsFilter($query){
        if ($query->is_search){
         $query->set('post_type', 'post');
        }
        return $query;
    }
    add_filter('pre_get_posts','mySearchPostsFilter');

    //Change WordPress Dashboard Menu Items Text
    function menu_item_text( $menu ) {
         $menu = str_ireplace( 'Painel', 'Home', $menu );
         $menu = str_ireplace( 'Post', 'Artigo', $menu );
         return $menu;
    }
    add_filter('gettext', 'menu_item_text');
    add_filter('ngettext', 'menu_item_text');

    // Inserir imagem no editor do portfolio
    add_filter( 'get_media_item_args', 'force_send' );
    function force_send($args){
    	$args['send'] = true;
    	return $args;
    }

    //Customiza o typo de tiny_mce h1/h2/h3...
    add_filter('tiny_mce_before_init', 'change_mce_dropdown' );
    function change_mce_dropdown( $initArray ) {
        $initArray['theme_advanced_blockformats'] = 'p,h3,strong';
        return $initArray;
    }

    /* post thumbnails */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 150, 150, true );
    add_image_size( 'thumb-peq', 85, 100, true );
    add_image_size( 'thumb-gr', 373, 342, true );

    // Custom url search
    function search_url_rewrite_rule() {
        if ( is_search() && !empty($_GET['s'])) {
            wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
            exit();
        }
    }
    add_action('template_redirect', 'search_url_rewrite_rule');


    function custom_loginpage_head() {
    ?>
        <link rel="stylesheet" href="<?php echo site_url(); ?>/_/css/section/custom-login.css" type="text/css" media="screen" />
    <?php
    }
    add_action("login_head","custom_loginpage_head");


    //Adiciona a pagina com os emails enviados pela pagina de contato.
    add_action('admin_menu', 'mostra_contatos');
    //Make our function to call the WordPress function to add to the correct menu.
    function mostra_contatos() {
    	add_menu_page('Emails', 'Emails', 8, 'emails', 'mostra_emails', '/wp-admin/images/generic.png');
    }
    //Adiciona conteudo na pagina de contato
    function mostra_emails() {
    ?>
        <div class="wrap">
        	<div id="icon-options-general" class="icon32"></div>
        	<h2>Emails recebidos</h2>
        	<p>Aqui você encontra a lista de email recebidos pela página de contato</p>

            <h3>Emails</h3>
            <ul>
            <style > .linha-contato { background: #f5f5f5; border: #DFDFDF 1px solid; padding: 12px; position: relative; margin-bottom: 20px; } .linha-contato p { max-width: 70%; } .linha-contato strong { color: #ff6600; } .linha-contato em { background: #ff6600; border: solid 1px #e05a00; color: #fff; font-size: 12px; left: -5px; padding: 1px 6px; position: absolute; top: -8px; -webkit-border-radius: 20px; -moz-border-radius: 2px; border-radius: 20px; } </style>
            <?php
                global $wpdb;
                $emails = $wpdb->get_results("SELECT * FROM nva_contato");
                $i = 1;
                foreach($emails as $email){
                    $data = date_i18n(get_option('date_format'). ' - G:i:s'  ,strtotime($email->data));
                    echo '<li class="linha-contato"><em>'. $i++ .'</em><p><strong>Data: </strong>'. $data .'</p><p><span><strong>Nome: </strong>'. $email->nome . '</span> | <span><strong>Email: </strong>'. $email->email . '</span></p><p><span><strong>Telefone: </strong>'. $email->telefone . '</span>  | <span><strong>Empresa: </strong>'. $email->empresa . '</span></p><p><span><strong>Cidade: </strong>'. $email->cidade . '</span> | <span><strong>Estado: </strong>'. $email->estado . '</span></p><p><span><strong>Mensagem: </strong>'. $email->mensagem . '</span></p></li>';
                }
             ?>
            </ul>
        </div>
    <?php
    }


    //Redireciona os posts portfolio para a reordenacao
    function redirectParaReordenar($post_id) {
        $post = get_post($post_id);

        if($post->post_type == 'portfolios' && $_POST['original_publish']){
            wp_redirect('edit.php?post_type=portfolios&page=order-post-types-portfolios&action=sucesso'); exit;
        }
    }
    add_action('save_post', 'redirectParaReordenar');


    // add scripts and styles for custom page templates
    add_action('wp_print_styles', 'nva_scripts');
    function nva_scripts()
	{
        $load_in_footer = false;
        $template       = get_bloginfo('template_directory');

		// default Scripts
        wp_enqueue_script('modernizr',      $template.'/_/js/libs/modernizr-2.6.2.min.js',$load_in_footer);
        wp_enqueue_script('loader',         $template.'/_/js/common/loader.js',$load_in_footer);

        // default Styles
        wp_enqueue_style('screen',          $template.'/_/css/screen.css', array(),  $load_in_footer, 'screen, projection, print');
        if(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
        wp_enqueue_style('specificIE',      $template.'/_/css/ie-specific.css', array('screen'),  $load_in_footer, 'screen, projection, print');
        }
        wp_enqueue_style('print',           $template.'/_/css/print.css', array('screen'),  $load_in_footer, 'print');

        // home page
        // if(is_page_template('page-home.php') || is_page('home'))
		// {
            // wp_enqueue_script('home',   .$template.'/_/js/section/home.js',array('loader'), $load_in_footer);
            // wp_enqueue_style('home',    .$template.'/_/css/section/home.css', array('screen'),  $load_in_footer, 'screen');
        // }
    }

?>