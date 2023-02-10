<?php

namespace WPMVC\Addons\Status\Controllers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use TenQuality\WP\File;
use WPMVC\Cache;
use WPMVC\Request;
use WPMVC\MVC\Controller;
use WPMVC\Addons\Status\Abstracts\StatusData;
use WPMVC\Addons\Status\Data\WpVersion;
use WPMVC\Addons\Status\Data\PhpVersion;
use WPMVC\Addons\Status\Data\DbVersion;
use WPMVC\Addons\Status\Data\DbCharset;
/**
 * Addon class.
 * Wordpress MVC.
 *
 * @link http://www.wordpress-mvc.com/v1/add-ons/
 * @author 10 Quality Studio <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.3
 */
class StatusController extends Controller
{
    /**
     * Renders system status page.
     * @since 1.0.0
     * 
     * @see StatusAddon::add_endpoints()
     * 
     * @param string        $parent Menu parent.
     * @param \WPMVC\Bridge $main
     */
    public function render( $parent, $main )
    {
        // Page tabs
        $tabs = apply_filters( 'wpmvc_addon_status_tabs', [
            'status' => __( 'Status', 'wpmvc-addon-status' ),
            'logs' => __( 'Logs', 'wpmvc-addon-status' ),
            'cache' => __( 'Cache' ),
        ] );
        // Current tab
        $tab = Request::input( 'tab', apply_filters( 'wpmvc_addon_status_tab', 'status' ) );
        if ( !array_key_exists( $tab, $tabs ) )
            $tab = 'status';
        // Rendering and enqueue
        $base_url = add_query_arg( 'page', Request::input( 'page' ), admin_url( $parent ) );
        do_action( 'wpmvc_addon_status_enqueue' );
        do_action( 'wpmvc_addon_status_' . $tab . '_enqueue' );
        $this->view->show( 'addon-status.header', [
            'tabs' => &$tabs,
            'tab' => &$tab,
            'url' => $base_url,
        ] );
        switch ( $tab ) {
            case 'status':
                $this->render_status();
                break;
            case 'logs':
                $this->render_logs( $main, add_query_arg( 'tab', 'logs', $base_url ) );
                break;
            case 'cache':
                $this->render_cache( add_query_arg( 'tab', 'cache', $base_url ) );
                break;
            default:
                do_action( 'wpmvc_addon_status_tab_' . $tab, $main, add_query_arg( 'tab', $tab, $base_url ) );
                break;
        }
        $this->view->show( 'addon-status.footer', [
            'tabs' => &$tabs,
            'tab' => &$tab,
        ] );
    }
    /**
     * Renders system status tab.
     * @since 1.0.0
     */
    private function render_status()
    {
        // Data structures
        $sections = apply_filters( 'wpmvc_addon_status_sections', [
            'wp' => __( 'WordPress', 'wpmvc-addon-status' ),
            'php' => __( 'PHP', 'wpmvc-addon-status' ),
            'db' => __( 'Database', 'wpmvc-addon-status' ),
            'other' => __( 'Other', 'wpmvc-addon-status' ),
        ] );
        $data = apply_filters( 'wpmvc_addon_status_data', [
            new WpVersion(),
            new PhpVersion(),
            new DbVersion(),
            new DbCharset(),
        ] );
        // Convert classes to to array
        $data = array_map( function( $item ) {
            if ( is_object( $item ) && $item instanceof StatusData ) {
                $item->check();
                return $item->to_array();
            }
            return $item;
        }, $data );
        // Filter only valid data
        $data = array_filter( $data, function( $item ) {
            return is_array( $item )
                && array_key_exists( 'title', $item )
                && array_key_exists( 'message', $item )
                && !empty( $item['title'] )
                && !empty( $item['message'] );
        } );
        // Replace status codes
        $data = array_map( function( $item ) {
            if ( array_key_exists( 'status', $item ) ) {
                switch ( $item['status'] ) {
                    case 1:
                        $item['status'] = 'success';
                        break;
                    case 1:
                        $item['status'] = 'important';
                        break;
                    case 2:
                        $item['status'] = 'danger';
                        break;
                    default:
                        $item['status'] = 'normal';
                        break;
                }
            } else {
                $item['status'] = 'normal';
            }
            return $item;
        }, $data );
        // Render
        $this->view->show( 'addon-status.tab-status', [
            'sections' => &$sections,
            'data' => &$data,
        ] );
    }
    /**
     * Renders logs tab.
     * @since 1.0.0
     * 
     * @param \WPMVC\Bridge $main
     * @param string        $base_url
     */
    private function render_logs( $main, $base_url )
    {
        // Delete all?
        $deleted_all = false;
        if ( Request::input( 'delete-all' ) ) {
            foreach ( glob( $main->config->get( 'paths.log' ) . '/*.txt' ) as $filename ) {
                unlink( $filename );
            }
            $deleted_all = true;
            do_action( 'wpmvc_addon_logs_deleted' );
        } 
        // Read
        $logs = [];
        if ( File::auth()->is_dir( $main->config->get( 'paths.log' ) ) ) {
            $dir = new RecursiveDirectoryIterator( $main->config->get( 'paths.log' ), RecursiveDirectoryIterator::SKIP_DOTS );
            foreach ( new RecursiveIteratorIterator( $dir, RecursiveIteratorIterator::SELF_FIRST ) as $filename => $item ) {
                $logs[$item->getCTime()] = [
                    'filename' => $filename,
                    'name' => $item->getBasename(),
                    'type' => 'wpmvc',
                    'object' => $item,
                ];
            }
        }
        $logs = apply_filters( 'wpmvc_addon_status_logs', $logs );
        // Process deletion
        $delete = Request::input( 'delete' );
        if ( $delete && array_key_exists( $delete, $logs ) ) {
            unlink( $logs[$delete]['filename'] );
            unset( $logs[$delete] );
        }
        // Process rendering
        $view = Request::input( 'view' );
        if ( $view && array_key_exists( $view, $logs ) && array_key_exists( 'filename', $logs[$view] ) ) {
            $this->view->show( 'addon-status.tab-logs-view', [
                'log' => $logs[$view],
                'content' => File::auth()->read( $logs[$view]['filename'] ),
                'url' => $base_url,
                'delete_url' => add_query_arg( 'delete', $view, $base_url ),
            ] );
        } else {
            foreach ( $logs as $key => $log ) {
                $logs[$key]['url'] = add_query_arg( 'view', $key, $base_url );
            }
            $this->view->show( 'addon-status.tab-logs', [
                'logs' => &$logs,
                'deleted_all' => $deleted_all,
                'delete_all_url' => add_query_arg( 'delete-all', 1, $base_url ),
            ] );
        }
    }
    /**
     * Renders cache tab.
     * @since 1.0.1
     *
     * @param string $base_url
     */
    private function render_cache( $base_url )
    {
        $flushed = false;
        if ( Request::input( 'flush', false ) == 1 ) {
            Cache::flush();
            $flushed = true;
            do_action( 'wpmvc_addon_cache_flushed' );
        }
        // Process rendering
        $this->view->show( 'addon-status.tab-cache', [
            'flushed' => $flushed,
            'flush_url' => add_query_arg( 'flush', 1, $base_url ),
        ] );
    }
}