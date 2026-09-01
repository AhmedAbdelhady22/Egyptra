<?php

/**
 * One-off script: generate a 2× retina logo from the 1× source.
 * Run: php scripts/generate-retina-logo.php
 */

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Intervention\Image\Laravel\Facades\Image;

$source = public_path('images/brand/egyptra-logo.png');
$target = public_path('images/brand/egyptra-logo@2x.png');

if (! file_exists($source)) {
    fwrite(STDERR, "Source logo not found: {$source}\n");
    exit(1);
}

[$width, $height] = getimagesize($source);

$image = Image::decodePath($source)->scale($width * 2, $height * 2);
$image->save($target);

echo 'Generated '.$target.' at '.($width * 2).'×'.($height * 2)."px\n";
