<?php

namespace App\FileUploader;

class FileFileUploader extends FileUploader
{

    public function fieldParam(): string
    {
        return 'file';
    }

    public function colName(): string
    {
        return 'path';
    }

    public function dirName(): string
    {
        return 'pet-shop';
    }
}