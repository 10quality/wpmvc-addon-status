<?php

namespace WPMVC\Addons\Status\Controllers;

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
 * @version 1.0.0
 */
class StatusController extends Controller
{
    /**
     * Renders system status page.
     * @since 1.0.0
     * 
     * @see StatusAddon::add_endpoints()
     * 
     * @param string $parent Menu parent.
     */
    public function render( $parent )
    {
        // Page tabs
        $tabs = apply_filters( 'wpmvc_addon_status_tabs', [
            'status' => __( 'Status', 'wpmvc-addon-status' ),
            'logs' => __( 'Logs', 'wpmvc-addon-status' ),
        ] );
        // Current tab
        $tab = Request::input( 'tab', apply_filters( 'wpmvc_addon_status_tab', 'status' ) );
        if ( !array_key_exists( $tab, $tabs ) )
            $tab = 'status';
        // Rendering and enqueue
        do_action( 'wpmvc_addon_status_enqueue' );
        do_action( 'wpmvc_addon_status_' . $tab . '_enqueue' );
        $this->view->show( 'addon-status.header', [
            'tabs' => &$tabs,
            'tab' => &$tab,
            'url' => add_query_arg( 'page', Request::input( 'page' ), admin_url( $parent ) ),
        ] );
        switch ( $tab ) {
            case 'status':
                $this->render_status();
                break;
            case 'logs':
                $this->render_logs();
                break;
            default:
                do_action( 'wpmvc_addon_status_tab_' . $tab );
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
     */
    private function render_logs()
    {

    }
}