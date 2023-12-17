# WordPress plugin auto archiver

This is a tool to archive the wordpress plugin you developed.

Auto increment patch version, and archive directory.

# Settings

First, edit the lines below.

File: /auto-archive.php

```php
define("PLUGIN_PATH", __DIR__ . '/plugins/test-plugin');
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
