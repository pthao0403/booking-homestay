<?php

namespace Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureViteManifestExists();
    }

    private function ensureViteManifestExists(): void
    {
        $buildPath = public_path('build');

        if (! File::exists($buildPath)) {
            File::makeDirectory($buildPath, 0755, true);
        }

        $manifestPath = $buildPath . DIRECTORY_SEPARATOR . 'manifest.json';

        if (! File::exists($manifestPath)) {
            File::put($manifestPath, json_encode([
                'resources/css/app.css' => [
                    'file' => 'assets/app.css',
                    'src' => 'resources/css/app.css',
                    'isEntry' => true,
                ],
                'resources/js/app.js' => [
                    'file' => 'assets/app.js',
                    'src' => 'resources/js/app.js',
                    'isEntry' => true,
                ],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        $assetsPath = $buildPath . DIRECTORY_SEPARATOR . 'assets';

        if (! File::exists($assetsPath)) {
            File::makeDirectory($assetsPath, 0755, true);
        }

        foreach (['app.css', 'app.js'] as $asset) {
            $assetPath = $assetsPath . DIRECTORY_SEPARATOR . $asset;

            if (! File::exists($assetPath)) {
                File::put($assetPath, '');
            }
        }
    }
}
