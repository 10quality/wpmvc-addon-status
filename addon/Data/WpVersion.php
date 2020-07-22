<?php

namespace WPMVC\Addons\Status\Data;

use WPMVC\Addons\Status\Abstracts\StatusData;
/**
 * WordPress version.
 * WordPress system status data.
 *
 * @author 10 Quality Studio <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
class WpVersion extends StatusData
{
    /**
     * Checks WP version.
     * @since 1.0.0
     */
    public function check()
    {
        global $wp_version;
        if ( isset( $wp_version ) ) {
            $this->section = 'wp';
            $this->title = __( 'Version', 'wpmvc-addon-status' );
            $this->message = $wp_version;
        }
    }
}