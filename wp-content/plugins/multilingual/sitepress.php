<?php 
/*
Plugin Name: WPML Multilingual CMS
Plugin URI: http://wpml.org/
Description: WPML Multilingual CMS. <a href="http://wpml.org">Documentation</a>.
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com
Version: 2.0.4.1
*/

/*
    This file is part of ICanLocalize Translator.

    ICanLocalize Translator is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    ICanLocalize Translator is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with ICanLocalize Translator.  If not, see <http://www.gnu.org/licenses/>.
*/

if(defined('ICL_SITEPRESS_VERSION')) return;
define('ICL_SITEPRESS_VERSION', '2.0.4.1');
define('ICL_PLUGIN_PATH', dirname(__FILE__));
define('ICL_PLUGIN_FOLDER', basename(ICL_PLUGIN_PATH));

if(defined('WP_ADMIN') && defined('FORCE_SSL_ADMIN') && FORCE_SSL_ADMIN){
    define('ICL_PLUGIN_URL', rtrim(str_replace('http://','https://',get_option('siteurl')),'/') . '/'. PLUGINDIR . '/' . basename(dirname(__FILE__)) );
}else{
    define('ICL_PLUGIN_URL', rtrim(get_option('siteurl'),'/') . '/'. PLUGINDIR . '/' . basename(dirname(__FILE__)) );
}
if(defined('WP_ADMIN')){
    add_action('admin_notices', 'wpml_new_promotion_notice');
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'wpml_new_promotion_notice_hide') {
            update_option('wpml_new_promotion_notice_show', 0);
            echo 'wpml_new_promotion_notice_hide';
            die();
        } else if ($_GET['action'] == 'wpml_new_promotion_notice_show') {
            update_option('wpml_new_promotion_notice_show', 1);
            echo 'wpml_new_promotion_notice_show';
            die();
        }
    }
    function wpml_new_promotion_notice() {
        $long_message = intval(get_option('wpml_new_promotion_notice_show', 1));
        $mtchs = array(ICL_PLUGIN_FOLDER);
        
        if (!isset($_GET['page']) || !preg_match('@^('.join('|', $mtchs).')/@', $_GET['page'])) {
            return;
        }

        $message = '';
        $message .= '<div id="wpml_new_promotion_notice"';
        $message .= $long_message ? '' : ' style="display:none;"';
        $message .= '>';
        $message .= '<a href="javascript:void(0);" style="float:right;" onclick="jQuery.get(\'admin-ajax.php\', {action: \'wpml_new_promotion_notice_hide\'}); jQuery(\'#wpml_new_promotion_notice\').hide(); jQuery(\'#wpml_new_promotion_notice_short\').show();">hide</a>';
        $message .= '<h4>' . __('WPML has turned commercial','sitepress')
                . '</h4><p>' . __('A new version of WPML is available. This version contains important security fixes, improved performance, new and powerful features and works perfectly with WordPress 3.1.','sitepress')
                . '</p><p><a class="button secondary" href="http://wpml.org/purchase/">'
                . __('Upgrade now','sitepress')
                . '</a> &nbsp; <a href="http://wpml.org/purchase/why-upgrade/">'
                . __('What\'s new and why you should upgrade &raquo;','sitepress')
                . '</a></p></div>';

        $message_short = '';
        $message_short .= '<div id="wpml_new_promotion_notice_short"';
        $message_short .= $long_message ? ' style="display:none;"' : '';
        $message_short .= '>';
        $message_short .= '<a href="javascript:void(0);" style="float:right;" onclick="jQuery.get(\'admin-ajax.php\', {action: \'wpml_new_promotion_notice_show\'}); jQuery(\'#wpml_new_promotion_notice_short\').hide(); jQuery(\'#wpml_new_promotion_notice\').show();">show</a>';
        $message_short .= '<p>' . __('Upgrade available for WPML', 'sitepress') . '</p>' . '</div>';

        $message = $long_message ? $message . $message_short : $message . $message_short;
        echo '<div class="updated message fade">' . $message . '</div>';
    }
    require ICL_PLUGIN_PATH . '/inc/php-version-check.php';
    if(defined('PHP_VERSION_INCOMPATIBLE')) return;
}
require ICL_PLUGIN_PATH . '/inc/not-compatible-plugins.php';
if(!empty($icl_ncp_plugins)){
    return;
}  


if(isset($_REQUEST['action']) && $_REQUEST['action']=='addblog' && false !== strpos($_SERVER['REQUEST_URI'], '/wpmu-edit.php')){
    /**
    * Activate the plugin for WPMU new blogs when WPML is enabled sitewide
    * 
    */
    add_action('wpmu_new_blog', 'icl_wpmu_new_blog');
    function icl_wpmu_new_blog($blog_id){
        $wpmu_sitewide_plugins = (array) maybe_unserialize( get_site_option( 'active_sitewide_plugins' ) );
        if(isset($wpmu_sitewide_plugins[ICL_PLUGIN_FOLDER.'/'.basename(__FILE__)])){
            require ICL_PLUGIN_PATH . '/inc/sitepress-schema.php';
            switch_to_blog($blog_id);
            icl_sitepress_activate();
            restore_current_blog();            
            remove_action('admin_footer', 'icl_display_errors_stack');
        }
    }
    return;
} 

require ICL_PLUGIN_PATH . '/inc/constants.inc';
    
require ICL_PLUGIN_PATH . '/inc/pre-wp3-compatibility.php';
require ICL_PLUGIN_PATH . '/inc/sitepress-schema.php';
require ICL_PLUGIN_PATH . '/inc/template-functions.php';
require ICL_PLUGIN_PATH . '/inc/icl-recent-comments-widget.php';
require ICL_PLUGIN_PATH . '/sitepress.class.php';
require ICL_PLUGIN_PATH . '/inc/functions.php';
require ICL_PLUGIN_PATH . '/inc/hacks.php';
require ICL_PLUGIN_PATH . '/inc/upgrade.php';
require ICL_PLUGIN_PATH . '/inc/functions-string-translation.php';
require ICL_PLUGIN_PATH . '/inc/compatibility-packages/functions-packages.php';
require ICL_PLUGIN_PATH . '/inc/compatibility-packages/wpml-package.class.php';
require ICL_PLUGIN_PATH . '/inc/affiliate-info.php';
require ICL_PLUGIN_PATH . '/inc/language-switcher.php';
require ICL_PLUGIN_PATH . '/inc/import-xml.php';

if(is_admin() || defined('XMLRPC_REQUEST')){
    require ICL_PLUGIN_PATH . '/lib/icl_api.php';
    require ICL_PLUGIN_PATH . '/lib/xml2array.php';
    require ICL_PLUGIN_PATH . '/lib/Snoopy.class.php';
    require ICL_PLUGIN_PATH . '/inc/translation-management/translation-management.class.php';
    require ICL_PLUGIN_PATH . '/inc/translation-management/pro-translation.class.php';
    require ICL_PLUGIN_PATH . '/inc/quote.php';
    $ICL_Pro_Translation = new ICL_Pro_Translation();    
}



if( !isset($_REQUEST['action'])     || ($_REQUEST['action']!='activate' && $_REQUEST['action']!='activate-selected') 
    || (($_REQUEST['plugin'] != basename(ICL_PLUGIN_PATH).'/'.basename(__FILE__)) 
        && !in_array(basename(ICL_PLUGIN_PATH).'/'.basename(__FILE__), (array)$_REQUEST['checked']))){
        
    $sitepress = new SitePress();
    $sitepress_settings = $sitepress->get_settings();    
    
    // modules load
    // CMS Navigation
    if(isset($_GET['enable-cms-navigation'])){
        $sitepress_settings['modules']['cms-navigation']['enabled'] = intval($_GET['enable-cms-navigation']);
        $sitepress->save_settings($sitepress_settings);
    }    
    if($sitepress_settings['modules']['cms-navigation']['enabled']){
        require ICL_PLUGIN_PATH . '/modules/cms-navigation/cms-navigation.php';
        $iclCMSNavigation = new CMSNavigation();
    }
    
    // Sticky Links
    if(isset($_REQUEST['icl_enable_alp'])){
        $sitepress_settings['modules']['absolute-links']['enabled'] = intval($_REQUEST['icl_enable_alp']);
        $sitepress->save_settings($sitepress_settings);
    }
    if($sitepress_settings['modules']['absolute-links']['enabled']){
        require ICL_PLUGIN_PATH . '/modules/absolute-links/absolute-links-plugin.php';
        $iclAbsoluteLinks = new AbsoluteLinksPlugin();
    }

    
    // Comments translation
    if($sitepress_settings['existing_content_language_verified']){
        require ICL_PLUGIN_PATH . '/inc/comments-translation/functions.php';
    }
	
	if (is_admin() && isset($_GET['page']) && $_GET['page'] == ICL_PLUGIN_FOLDER . '/menu/support.php'){
		require_once ICL_PLUGIN_PATH . '/inc/support.php';
		$icl_support = new SitePress_Support();
	}
    
    require ICL_PLUGIN_PATH . '/inc/compatibility-packages/init-packages.php';
    require ICL_PLUGIN_PATH . '/modules/cache-plugins-integration/cache-plugins-integration.php';
    require ICL_PLUGIN_PATH . '/inc/upgrade_plugins.php';
    
}
 
// activation hook
register_activation_hook( __FILE__, 'icl_sitepress_activate' );
register_deactivation_hook(__FILE__, 'icl_sitepress_deactivate');

add_filter('plugin_action_links', 'icl_plugin_action_links', 10, 2); 

?>
