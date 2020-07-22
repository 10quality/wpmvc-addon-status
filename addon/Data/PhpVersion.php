<?php

namespace WPMVC\Addons\Status\Data;

use WPMVC\Addons\Status\Abstracts\StatusData;
/**
 * PHP version.
 * PHP system status data.
 *
 * @author 10 Quality Studio <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
class PhpVersion extends StatusData
{
    /**
     * Checks PHP version.
     * @since 1.0.0
     */
    public function check()
    {
        $this->section = 'php';
        $this->title = __( 'Version', 'wpmvc-addon-status' );
        $this->message = phpversion();
    }
}