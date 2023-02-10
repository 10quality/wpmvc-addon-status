# Status Addon (for Wordpress MVC)

[![Latest Stable Version](https://poser.pugx.org/10quality/wpmvc-addon-status/v/stable)](https://packagist.org/packages/10quality/wpmvc-addon-status)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/10quality/wpmvc-addon-status/test.yml)
[![Total Downloads](https://poser.pugx.org/10quality/wpmvc-addon-status/downloads)](https://packagist.org/packages/10quality/wpmvc-addon-status)
[![License](https://poser.pugx.org/10quality/wpmvc-addon-status/license)](https://packagist.org/packages/10quality/wpmvc-addon-status)

Add-on for [WordPress MVC](http://www.wordpress-mvc.com/).

The add-on will add a "System Status" option inside WordPress admin dashboard, allowing for administrator to see the system status and log files.

Features:

* System status (WP, PHP and DB versions).
* Easy JSON export.
* WordPress MVC log file viewer.

## Install and Configuration

To install, use the following composer command:
```bash
composer require 10quality/wpmvc-addon-status
```

To configure the add-on, simply add it to your projects add-ons list at `[project]/app/Config/app.php`:
```php
    'addons' => [
        'WPMVC\Addons\Status\StatusAddon',
    ],
```

## Hooks

You can add custom status information and sections.

### wpmvc_addon_status_sections

Filter `wpmvc_addon_status_sections` allows to add new sections to the system status report, example:
```php
add_filter( 'wpmvc_addon_status_sections', function( $sections ) {
    $sections['my-plugin'] = __( 'My Plugin', 'my-domain' );
    return $sections;
} );
```

### wpmvc_addon_status_data

Filter `wpmvc_addon_status_data` allows to add new date to the system status report, data can be added as:
* Array
* Class instance of `StatusData`.

#### Using array

Example:
```php
add_filter( 'wpmvc_addon_status_data', function( $data ) {
    $data[] = [
        'section' => 'my-plugin',
        'title' => __( 'API Connection', 'my-domain' );
        'message' => __( 'Yes', 'my-domain' );
        'status' => 1,
    ];
    return $data;
} );
```

| Status | Description |
| --- | --- |
| `0` | Normal status. Displays with black text. |
| `1` | Success status. Displays with green text. |
| `2` | Important status. Displays with blue text. |
| `3` | Danger status. Displays with red text. |

#### Class instance

Example:
```php
namespace MyNamespace\SystemStatus;

use WPMVC\Addons\Status\Abstracts\StatusData;
/**
 * Custom system status data.
 */
class ConnectionData extends StatusData
{
    /**
     * Checks connection.
     * This method is always called by the addon to init data.
     */
    public function check()
    {
        // Do custom code
        $has_connection = true;

        $this->section = 'my-plugin';
        $this->title = __( 'API Connection', 'my-domain' );
        $this->message = $has_connection ? 'Yes' : 'No';
        $this->status = $has_connection ? 1 : 3;
    }
}
```

Then add class to filter:
```php
add_filter( 'wpmvc_addon_status_data', function( $data ) {
    $data[] = new ConnectionData();
    return $data;
} );
```

#### Data status

| Status | Description |
| --- | --- |
| `0` | Normal status. Displays with black text. |
| `1` | Success status. Displays with green text. |
| `2` | Important status. Displays with blue text. |
| `3` | Danger status. Displays with red text. |


## Coding Guidelines

PSR-2 coding guidelines.

## License

MIT License. (c) 2020 [10 Quality](https://www.10quality.com/).