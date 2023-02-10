<?php

namespace WPMVC\Addons\Status\PHPUnit\Traits;

/**
 * Trait for handling logs.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-customizer
 * @license MIT
 * @version 1.0.3
 */
trait LogTrait
{
    /**
     * Creates a log file inside assets folder.
     * @since 1.0.3
     * 
     * @var string
     */
    protected $assets_path = __DIR__ . '/../../assets';

    /**
     * Creates a log file inside assets folder.
     * @since 1.0.3
     * 
     * @var string
     */
    protected $logs_path = __DIR__ . '/../../assets/logs';

    /**
     * Creates a log file inside assets folder.
     * @since 1.0.3
     * 
     * @param string $filename
     */
    public function create_log( $filename = null )
    {
        if ( ! is_dir( $this->logs_path ) )
            mkdir( $this->logs_path, 0777, true );
        $filename = $filename
            ? $this->logs_path . '/' . $filename 
            : $this->logs_path . '/' . date('Ymd') . '-' . uniqid() . '.txt';
        file_put_contents( $filename, '[info] test' );
    }

    /**
     * Clears all logs.
     * @since 1.0.3
     */
    public function clear_logs()
    {
        foreach ( glob( $this->logs_path . '/*.txt' ) as $filename ) {
            unlink( $filename );
        }
        if ( is_dir( $this->logs_path ) )
            rmdir( $this->logs_path );
        if ( is_dir( $this->assets_path ) )
            rmdir( $this->assets_path );
    }
}