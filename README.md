# WordPress plugin auto archiver

This is a tool to archive the wordpress plugin you developed.

Auto increment patch version, and archive directory.

This plugin is compatible with the following formats.

```php
/*
...
Version: 1.0.0
*/
```


# Settings

First, edit the lines below.


```php
// auto-archive.php
define("PLUGIN_PATH", __DIR__ . '/sample/plugins/test-plugin');
define("ARCHIVE_PATH", __DIR__ . '/archives');
```

# Usage

## Before run

Before runnning script, backup your plugin.

## Run

Run the script like below.

```
php auto-archive.php
```
