<?php
/**
 * Tab: Logs.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
?>
<div class="box-wrapper">
    <div class="logs section">
        <h4><?php _e( 'Log files', 'wpmvc-addon-status' ) ?></h4>
        <?php foreach ( $logs as $key => $log ) : ?>
            <div id="log-<?php echo esc_attr( $key ) ?>" class="log section-data">
                <div class="item-data">
                    <a href="<?php echo esc_url( $log['url'] ) ?>"><?php echo $log['name'] ?></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>