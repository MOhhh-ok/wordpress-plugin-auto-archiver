<?php

define("PLUGIN_PATH", __DIR__ . '/plugins/test-plugin');
define("ARCHIVE_PATH", __DIR__ . '/archives');

function incrementPatchVersion($file)
{
    $content = file_get_contents($file);
    if (!$content) {
        throw new Exception("ファイルが読み込めません: {$file}");
    }

    if (preg_match('/^Version:\s*(\d+\.\d+\.)(\d+)/m', $content, $matches)) {
        $newVersion = $matches[1] . ($matches[2] + 1);
        $content = str_replace($matches[0], "Version: " . $newVersion, $content);
        file_put_contents($file, $content);
        return $newVersion;
    } else {
        throw new Exception("Version not found: {$file}");
    }
}

function zipPlugin($srcDir, $zipFile)
{
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        throw new Exception("Can not open the zip file: {$zipFile}");
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($srcDir),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($srcDir) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
}

function getMainFilePath($pluginFolder)
{
    $pluginName = basename($pluginFolder);
    $pluginDir = dirname($pluginFolder);
    return "{$pluginDir}/{$pluginName}/{$pluginName}.php";
}

function generateZipPath($pluginFolder, $version) {
    $pluginName = basename($pluginFolder);
    return ARCHIVE_PATH . '/' . $pluginName . '-' . $version . '.zip';
}

try {
    echo "\n";
    echo "************************\n";
    echo "* Plugin auto archiver *\n";
    echo "************************\n";
    echo "\n";
    echo "Updateing and archiving the plugin...\n";
    $mainFilePath = getMainFilePath(PLUGIN_PATH);
    $newVersion = incrementPatchVersion($mainFilePath);
    echo "New Version: {$newVersion}\n";

    $zipFilePath = generateZipPath(PLUGIN_PATH, $newVersion);
    zipPlugin(PLUGIN_PATH, $zipFilePath);
    echo "Archive success: {$zipFilePath}\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}