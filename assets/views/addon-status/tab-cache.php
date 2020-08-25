<?php
/**
 * Tab: Cache.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.1
 */
?>
<div class="box-wrapper">
    <?php if ( $flushed ) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Cache flushed successfully!', 'wpmvc-addon-status' ) ?></p>
        </div>
    <?php endif ?>
    <a href="<?php echo esc_url( $flush_url ) ?>" class="button button-primary"><?php esc_html_e( 'Flush', 'wpmvc-addon-status' ) ?></a>
</div>