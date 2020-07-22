<?php

namespace WPMVC\Addons\Status\Data;

use WPMVC\Addons\Status\Abstracts\StatusData;
/**
 * Database version.
 * Database system status data.
 *
 * @author 10 Quality Studio <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
class DbVersion extends StatusData
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
            $this->title = __( 'Version', 'wpmvc-addon-status' );
            $this->message = $wpdb->db_version();
        }
    }
}