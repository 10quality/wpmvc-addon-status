<?php

use WPMVC\Addons\PHPUnit\TestCase;
use WPMVC\Addons\Status\StatusAddon;

/**
 * Test addon class.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-customizer
 * @license MIT
 * @version 1.0.2
 */
class StatusAddonTest extends TestCase
{
    /**
     * Tear down.
     * @since 1.0.2
     */
    public function tearDown(): void
    {
        wpmvc_addon_phpunit_reset();
    }
    /**
     * Test init.
     * @since 1.0.2
     * @group addon
     */
    public function testInit()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new StatusAddon( $bridge );
        // Run
        $addon->on_admin();
        // Assertc
        $this->assertAddedAction( 'admin_menu' );
    }
    /**
     * Test init.
     * @since 1.0.2
     * @group addon
     */
    public function testRenderPlugins()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new StatusAddon( $bridge );
        // Run
        ob_start();
        $addon->render_plugins();
        $render = ob_get_clean();
        // Assertc
        $this->assertNotEmpty( $render );
        $this->assertMatchesRegularExpression( '/class="box-wrapper"/i', $render );
        $this->assertDidAction( 'wpmvc_addon_status_header' );
        $this->assertDidAction( 'wpmvc_addon_status_footer' );
        $this->assertAppliedFilters( 'wpmvc_addon_status_tab' );
    }
    /**
     * Test init.
     * @since 1.0.2
     * @group addon
     */
    public function testRenderThemes()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new StatusAddon( $bridge );
        // Run
        ob_start();
        $addon->render_themes();
        $render = ob_get_clean();
        // Assertc
        $this->assertNotEmpty( $render );
        $this->assertMatchesRegularExpression( '/class="box-wrapper"/i', $render );
        $this->assertDidAction( 'wpmvc_addon_status_header' );
        $this->assertDidAction( 'wpmvc_addon_status_footer' );
        $this->assertAppliedFilters( 'wpmvc_addon_status_tab' );
    }
    /**
     * Test init.
     * @since 1.0.2
     * @group addon
     */
    public function testRenderCache()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $addon = new StatusAddon( $bridge );
        $_GET['tab'] = 'cache';
        // Run
        ob_start();
        $addon->render_plugins();
        $render = ob_get_clean();
        // Assertc
        $this->assertNotEmpty( $render );
        $this->assertMatchesRegularExpression( '/class="box-wrapper"/i', $render );
        $this->assertMatchesRegularExpression( '/Flush/i', $render );
        $this->assertDidAction( 'wpmvc_addon_status_header' );
        $this->assertDidAction( 'wpmvc_addon_status_footer' );
    }
}