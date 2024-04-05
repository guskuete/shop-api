<?php
use Illuminate\Support\Facades\File;

function checkDirectory($path)
{
    if (!File::isDirectory($path)) {
        File::makeDirectory($path);
    }
}
