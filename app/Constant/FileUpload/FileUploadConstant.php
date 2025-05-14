<?php

namespace App\Constant\FileUpload;

class FileUploadConstant
{

    public const ALLOWED_FILE_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp'];

    public const ALLOWED_IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp'];


    public function getAllowedFileExtension($fileExtension): bool
    {
        if (isset($fileExtension)) {
            return in_array($fileExtension, self::ALLOWED_FILE_TYPES, true);
        } else return false;
    }

    public function getAllowedImageExtension($fileExtension): bool
    {
        if (isset($fileExtension)) {
            return in_array($fileExtension, self::ALLOWED_IMAGE_TYPES, true);
        } else return false;
    }
}
