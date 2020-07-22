<?php
/**
 * Tab: Logs - View.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
?>
<div class="box-wrapper">
    <p>
        <a href="<?php echo esc_url( $url ) ?>"><?php _e( '< Back to logs', 'wpmvc-addon-status' ) ?></a>
    </p>
    <div class="logs section">
        <h4><?php _e( 'File information', 'wpmvc-addon-status' ) ?></h4>
        <div class="section-data">
            <div class="data-item">
                <div class="item-title"><?php _e( 'Name' ) ?></div>
                <div class="item-message"><?php echo $log['name'] ?></div>
            </div>
            <?php if ( array_key_exists( 'type', $log ) ) : ?>
                <div class="data-item">
                    <div class="item-title"><?php _e( 'Type' ) ?></div>
                    <div class="item-message"><?php echo $log['type'] === 'wpmvc' ? 'WordPress MVC log file' : $log['type'] ?></div>
                </div>
            <?php endif ?>
            <?php if ( array_key_exists( 'object', $log ) ) : ?>
                <div class="data-item">
                    <div class="item-title"><?php _e( 'Change date', 'wpmvc-addon-status' ) ?></div>
                    <div class="item-message"><?php echo date( 'Y-m-d H:i:s', $log['object']->getCTime() ) ?></div>
                </div>
                <div class="data-item">
                    <div class="item-title"><?php _e( 'Updated date', 'wpmvc-addon-status' ) ?></div>
                    <div class="item-message"><?php echo date( 'Y-m-d H:i:s', $log['object']->getMTime() ) ?></div>
                </div>
            <?php endif ?>
            <?php if ( isset( $delete_url ) ) : ?>
                <div class="data-item">
                    <div class="item-title"><?php _e( 'Actions', 'wpmvc-addon-status' ) ?></div>
                    <div class="item-message"><a href="<?php echo esc_url( $delete_url ) ?>"><?php _e( 'Delete' ) ?></a></div>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="logs section">
        <h4><?php _e( 'File content', 'wpmvc-addon-status' ) ?></h4>
        <pre><?php echo $content ?></pre>
    </div>
</div>