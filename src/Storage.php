<?php
namespace Codx\Comic;

class Storage
{
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function saveFile($file, $directory = '')
    {
        $filePath = $this->basePath . '/' . $directory . '/' . $file['name'];
        
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception('Failed to save file', 500);
        }

        return $filePath;
    }

    public function getFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception('File not found', 404);
        }

        return file_get_contents($filePath);
    }

    public function deleteFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception('File not found', 404);
        }

        if (!unlink($filePath)) {
            throw new Exception('Failed to delete file', 500);
        }
    }
}
