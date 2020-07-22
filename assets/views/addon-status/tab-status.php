<?php
/**
 * Tab: Status.
 * WordPress MVC view.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
$export = [];
?>
<div class="box-wrapper">
    <?php foreach ( $sections as $section => $section_title ) : ?>
        <?php $section_data = array_filter( $data, function( $item ) use( &$section ) {
            return ( array_key_exists( 'section', $item ) && $item['section'] === $section )
                || ( !array_key_exists( 'section', $item ) && $section === 'other' );
        } ) ?>
        <?php if ( empty( $section_data ) ) : continue; endif ?>
        <?php $export[$section] = array_values( array_map( function( $item ) {
            unset( $item['section'] );
            return $item;
        }, $section_data ) ) ?>
        <div id="section-<?php echo esc_attr( $section )?>" class="section">
            <h4><?php echo $section_title ?></h4>
            <div class="section-data">
                <?php foreach ( $section_data as $item ) : ?>
                    <div class="data-item <?php echo esc_attr( $item['status'] ) ?>">
                        <div class="item-title"><?php echo $item['title'] ?></div>
                        <div class="item-message"><?php echo is_array( $item['message'] ) ? implode( '<br>', $item['message'] ) : (string)$item['message'] ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
    <?php if ( !empty( $export ) ) : ?>
        <div class="export">
            <small>
                <strong><?php _e( 'Export text', 'wpmvc-addon-status' ) ?></strong>
                <span>- <?php _e( 'The following JSON text can be shared with developers for support.', 'wpmvc-addon-status' ) ?></span>
            </small>
            <pre><?php echo json_encode( $export ) ?></pre>
        </div>
    <?php endif ?>
</div>