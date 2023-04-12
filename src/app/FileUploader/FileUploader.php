<?php

namespace App\FileUploader;

abstract class FileUploader
{

    public function handle($request, \Closure $next)
    {
        $data = $next($request);

        if (request()->hasFile($this->fieldParam()))
        {
            $path = request()->file($this->fieldParam())->store($this->dirName(), 'public');

            $data[$this->colName()] = $path;

        }
        return $data;
    }

    abstract public function fieldParam(): string;

    abstract public function colName(): string;

    abstract public function dirName(): string;

}
