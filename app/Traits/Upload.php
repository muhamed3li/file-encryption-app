<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


trait Upload
{
    public function uploadFile($file, $folder, $get_full_path = false)
    {
        $path = $this->checkFolderIsExists($folder);
        $name = $file->hashName();

        $content = $file->get();

        Storage::disk('public')->put($path . $name, $content, 'public');
        return $get_full_path ? 'storage/' . $this->getPath($folder, $name) : $name;
    }
    protected function checkFolderIsExists($folder)
    {
        $path =  storage_path($this->getPath($folder));

        if (!File::exists($path))
            File::makeDirectory($path, 0777, true);

        return $this->getPath($folder);
    }
    protected function getPath($folder, $file_name = '')
    {
        return "uploads/$folder/$file_name";
    }
}
