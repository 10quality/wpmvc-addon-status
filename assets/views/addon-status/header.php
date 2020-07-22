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
<style type="text/css">
.box-wrapper {
    display: flex;
    flex-direction: column;
    padding: 8px;
    margin: 20px 0;
    background-color: #fff;
    border: 1px solid #ccd0d4;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
}
.section {
    margin: 0 0 20px 0;
}
.section h4 {
    margin: 0 0 15px 0;
    padding: 5px;
    background-color: #f1f1f1;
}
.section .section-data {
    padding: 0 5px;
}
.section .data-item {
    display: flex;
    flex-direction: row;
    margin-bottom: 10px;
}
.section .data-item .item-title {
    width: 180px;
    font-weight: 600;
}
.section .data-item .item-message {
    margin-left: 20px;
}
@media (max-width: 650px) {
    .section .data-item {
        flex-direction: column;
    }
    .section .data-item .item-title {
        width: 100px;
        margin-bottom: 5px;
    }
    .section .data-item .item-message {
        margin-left: 0;
    }
}
</style>
<div class="wrap wpmvc addon-status">
    <?php do_action( 'wpmvc_addon_status_header' ) ?>
    <?php do_action( 'wpmvc_addon_status_before_header_' . $tab ) ?>
    <h2><?php _e( 'System Status', 'wpmvc-addon-status' ) ?></h2>
    <?php do_action( 'wpmvc_addon_status_after_header_' . $tab ) ?>
    <?php do_action( 'wpmvc_addon_status_before_nav_tabs_' . $tab ) ?>
    <h3 class="nav-tab-wrapper">
        <?php foreach ( $tabs as $key => $title ) : ?>
            <a class="nav-tab <?php if ( $tab === $key ) :?>nav-tab-active<?php endif ?>"
                href="<?= esc_url( add_query_arg( 'tab', $key, $url ) ) ?>"
            >
                <?php echo $title ?>
            </a>
        <?php endforeach ?>
        <?php do_action( 'wpmvc_addon_status_inside_nav_tab_' . $key, $tab ) ?>
    </h3>
    <?php do_action( 'wpmvc_addon_status_after_nav_tabs_' . $tab ) ?>
    <?php do_action( 'wpmvc_addon_status_before_content_' . $tab ) ?>
    <?php do_action( 'wpmvc_addon_status_content' ) ?>