<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
get_header(); ?>

        <section>
            <h1><?php _e( 'Not Found', 'twentyten' ); ?></h1>
            <p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'twentyten' ); ?></p>
            <?php get_search_form(); ?>            
        </section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>