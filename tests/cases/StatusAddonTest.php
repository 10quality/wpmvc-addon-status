<?php

use WPMVC\Addons\PHPUnit\TestCase;
use WPMVC\Addons\Status\StatusAddon;
use WPMVC\Addons\Status\PHPUnit\Traits\LogTrait;

/**
 * Test addon class.
 * 
 * @author 10 Quality <info@10quality.com>
 * @package wpmvc-addon-customizer
 * @license MIT
 * @version 1.0.3
 */
class StatusAddonTest extends TestCase
{
    use LogTrait;

    /**
     * Tear down.
     * @since 1.0.2
     */
    public function tearDown(): void
    {
        wpmvc_addon_phpunit_reset();
        $this->clear_logs();
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
    public function test_render_plugins()
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
    public function test_render_themes()
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
    public function test_render_cache()
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
    /**
     * Test init.
     * @since 1.0.3
     * @group addon
     */
    public function test_render_logs()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $bridge->config = $this->getConfigMock( __DIR__ . '/../assets' );
        $addon = new StatusAddon( $bridge );
        $this->create_log();
        $_GET['tab'] = 'logs';
        // Run
        ob_start();
        $addon->render_plugins();
        $render = ob_get_clean();
        // Assertc
        $this->assertNotEmpty( $render );
        $this->assertMatchesRegularExpression( '/class="box-wrapper"/i', $render );
        $this->assertMatchesRegularExpression( '/Delete all/i', $render );
        $this->assertMatchesRegularExpression( '/class="log section-data"/i', $render );
        $this->assertDidAction( 'wpmvc_addon_status_header' );
        $this->assertDidAction( 'wpmvc_addon_status_footer' );
    }
    /**
     * Test init.
     * @since 1.0.3
     * @group addon
     */
    public function test_render_logs_delete_all()
    {
        // Prepare
        $bridge = $this->getBridgeMock();
        $bridge->config = $this->getConfigMock( $this->logs_path );
        $addon = new StatusAddon( $bridge );
        $this->create_log();
        $this->create_log();
        $this->create_log();
        $_GET['tab'] = 'logs';
        $_GET['delete-all'] = 1;
        // Run
        ob_start();
        $addon->render_plugins();
        $render = ob_get_clean();
        $files = glob( $this->logs_path . '/*.txt' );
        // Assertc
        $this->assertEmpty( $files );
        $this->assertDidAction( 'wpmvc_addon_logs_deleted' );
    }
}