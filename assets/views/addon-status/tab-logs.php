<?php
/**
 * Tab: Logs.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.3
 */
?>
<div class="box-wrapper">
    <?php if ( $deleted_all ) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'All logs were deleted successfully!', 'wpmvc-addon-status' ) ?></p>
        </div>
    <?php endif ?>
    <div class="logs section">
        <h4><?php _e( 'Log files', 'wpmvc-addon-status' ) ?></h4>
        <p id="section-actions">
            <a href="<?php echo esc_url( $delete_all_url ) ?>" class="button button-primary"><?php esc_html_e( 'Delete all', 'wpmvc-addon-status' ) ?></a>
        </p>
        <?php foreach ( $logs as $key => $log ) : ?>
            <div id="log-<?php echo esc_attr( $key ) ?>" class="log section-data">
                <div class="item-data">
                    <a href="<?php echo esc_url( $log['url'] ) ?>"><?php echo $log['name'] ?></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>