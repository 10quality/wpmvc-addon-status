<?php

namespace WPMVC\Addons\Status;

use WPMVC\Addon;
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
class StatusAddon extends Addon
{
    /**
     * This static property allows to only create one menu link
     * for all WPMVC projects dependent of the add-on.
     * @since 1.0.0
     * 
     * @var \WPMVC\Addons\Customizer\AdministratorAddon
     */
    protected static $endpoints = [];
    /**
     * Function called when user is on admin dashboard.
     * Add wordpress hooks (actions, filters) here.
     * @since 1.0.0
     */
    public function on_admin()
    {
        add_action( 'admin_menu', [&$this, 'add_endpoints'] );
    }
    /**
     * Adds submenus to admin dashboard menu.
     * @since 1.0.0
     * 
     * @hook admin_menu
     */
    public function add_endpoints()
    {
        // Add option under plugins
        if ( $this->main->config->get( 'type' ) === 'plugin' && !in_array( 'plugin', static::$endpoints ) ) {
            add_submenu_page(
                'plugins.php',
                __( 'System Status', 'wpmvc-addon-status' ),
                __( 'System Status', 'wpmvc-addon-status' ),
                'manage_options',
                'wpmvc-system-status',
                [&$this, 'render_plugins'],
                99999
            );
            static::$endpoints[] = 'plugin';
        }
        // Add options under appereance
        if ( $this->main->config->get( 'type' ) === 'theme' && !in_array( 'theme', static::$endpoints ) ) {
            add_submenu_page(
                'themes.php',
                __( 'System Status', 'wpmvc-addon-status' ),
                __( 'System Status', 'wpmvc-addon-status' ),
                'manage_options',
                'wpmvc-system-status',
                [&$this, 'render_themes'],
                99999
            );
            static::$endpoints[] = 'theme';
        }
    }
    /**
     * Renders system status page.
     * @since 1.0.0
     * 
     * @see self::add_endpoints()
     */
    public function render_plugins()
    {
        $this->mvc->call( 'StatusController@render', '/plugins.php' );
    }
    /**
     * Renders system status page.
     * @since 1.0.0
     * 
     * @see self::add_endpoints()
     */
    public function render_themes()
    {
        $this->mvc->call( 'StatusController@render', '/themes.php' );
    }
}