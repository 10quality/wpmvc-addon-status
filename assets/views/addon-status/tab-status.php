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
?>
<div class="box-wrapper">
    <?php foreach ( $sections as $section => $section_title ) : ?>
        <?php $section_data = array_filter( $data, function( $item ) use( &$section ) {
            return ( array_key_exists( 'section', $item ) && $item['section'] === $section )
                || ( !array_key_exists( 'section', $item ) && $section === 'other' );
        } ) ?>
        <?php if ( empty( $section_data ) ) : continue; endif ?>
        <div id="section-<?php echo esc_attr( $section )?>" class="section">
            <h4><?php echo $section_title ?></h4>
            <div class="section-data">
                <?php foreach ( $section_data as $item ) : ?>
                    <div class="data-item">
                        <div class="item-title"><?php echo $item['title'] ?></div>
                        <div class="item-message"><?php echo is_array( $item['message'] ) ? implode( '<br>', $item['message'] ) : (string)$item['message'] ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
</div>