<?php

namespace WPMVC\Addons\Status\Data;

use WPMVC\Addons\Status\Abstracts\StatusData;
/**
 * Database charset collate.
 * Database system status data.
 *
 * @author 10 Quality Studio <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
class DbCharset extends StatusData
{
    /**
     * Checks DB version.
     * @since 1.0.0
     */
    public function check()
    {
        global $wpdb;
        if ( isset( $wpdb ) ) {
            $this->section = 'db';
            $this->title = __( 'Charset', 'wpmvc-addon-status' );
            $this->message = $wpdb->get_charset_collate();
        }
    }
}