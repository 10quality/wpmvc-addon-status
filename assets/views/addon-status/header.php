<?php
/**
 * Page header.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
?>
<div class="wrap wpmvc addon-status">
    <?php do_action( 'wpmvc_addon_status_header' ) ?>
    <?php do_action( 'wpmvc_addon_status_before_header_' . $tab ) ?>
    <h2><?php _e( 'System Status', 'wpmvc-addon-status' ) ?></h2>
    <?php do_action( 'wpmvc_addon_status_after_header_' . $tab ) ?>
    <?php do_action( 'wpmvc_addon_status_before_nav_tabs_' . $tab ) ?>
    <h3 class="nav-tab-wrapper">
        <?php foreach ( $tabs as $key => $title ) : ?>
            <a class="nav-tab <?php if ( $tab === $key ) :?>nav-tab-active<?php endif ?>"
                href="<?= esc_url( add_query_arg( 'tab', $tab, $url ) ) ?>"
            >
                <?php echo $title ?>
            </a>
        <?php endforeach ?>
        <?php do_action( 'wpmvc_addon_status_inside_nav_tab_' . $key, $tab ) ?>
    </h3>
    <?php do_action( 'wpmvc_addon_status_after_nav_tabs_' . $tab ) ?>
    <?php do_action( 'wpmvc_addon_status_before_content_' . $tab ) ?>
    <?php do_action( 'wpmvc_addon_status_content' ) ?>