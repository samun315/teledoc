<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Intervention\Image\Image;
use Illuminate\Support\Facades\File;

trait FileUploader
{

    /**
     * @param Request $requestFile
     * @param $attach
     * @param $directory
     * @return string|null
     */
    public function uploadMedia(Request $requestFile, $attach, $directory): ?string
    {

        // File upload, fit and store inside public folder
        if ($requestFile->hasFile($attach)) {

            // Valid extension check
            $valid_extensions = [
                'jpg', 'jpeg', 'png', 'PNG', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv',
                'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp'
            ];

            $file_ext = $requestFile->file($attach)->getClientOriginalExtension();

            if (in_array($file_ext, $valid_extensions, true)) {

                //Upload New File
                $filenameWithExt = $requestFile->file($attach)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $requestFile->file($attach)->getClientOriginalExtension();
                $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_',
                        $filename) . '_' . time() . '.' . $extension;

                //Crete Folder Location
                $path = public_path('uploads/' . $directory . '/');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                // Move file inside public/uploads/ directory
                $requestFile->file($attach)->move('uploads/' . $directory . '/', $fileNameToStore);
            } else {
                $fileNameToStore = null;
            }
        } else {
            $fileNameToStore = null;
        }

        return $fileNameToStore;
    }

    /**
     * @param Request $requestFile
     * @param $attach
     * @param $directory
     * @return array|null
     */
    public function uploadMultipleMedia(Request $requestFile, $attach, $directory): ?array
    {
        $uploadedFiles = [];

        // Check if files are present in the request
        if ($requestFile->hasFile($attach)) {
            $files = $requestFile->file($attach);

            // Valid extension check
            $valid_extensions = [
                'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv',
                'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp'
            ];

            foreach ($files as $file) {
                $file_ext = $file->getClientOriginalExtension();

                if (in_array($file_ext, $valid_extensions, true)) {
                    // Generate unique filename
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_',
                            $filename) . '_' . time() . '.' . $extension;

                    // Create folder if not exists
                    $path = public_path("uploads/{$directory}/");
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }

                    // Move file inside public/uploads/ directory
                    $file->move("uploads/{$directory}/", $fileNameToStore);
                    $uploadedFiles[] = $fileNameToStore;
                }
            }
        }

        return $uploadedFiles ?: null;
    }

    /**
     * @param Request $request
     * @param $attach
     * @param $directory
     * @param $oldAttach
     * @return mixed|string
     */
    public function updateMedia(Request $request, $attach, $directory, $oldAttach)
    {
        // File upload, fit and store inside public folder
        if ($request->hasFile($attach)) {

            // Valid extension check
            $valid_extensions = array(
                'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv',
                'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp'
            );
            $file_ext = $request->file($attach)->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                $old_attach = public_path('uploads/' . $directory . '/' . $oldAttach);
                if (File::isFile($old_attach)) {
                    File::delete($old_attach);
                }

                //Upload New File
                $filenameWithExt = $request->file($attach)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($attach)->getClientOriginalExtension();
                $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_',
                        $filename) . '_' . time() . '.' . $extension;

                //Crete Folder Location
                $path = public_path('uploads/' . $directory . '/');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                // Move file inside public/uploads/ directory
                $request->file($attach)->move('uploads/' . $directory . '/', $fileNameToStore);
            } else {
                $fileNameToStore = $oldAttach;
            }
        } else {
            $fileNameToStore = $oldAttach;
        }


        return $fileNameToStore;
    }


    /**
     * @param $directory
     * @param $model
     * @return true
     */
    public function deleteMedia($directory, $model)
    {

        // Delete attach
        $attach = public_path('uploads/' . $directory . '/' . $model->attach);
        if (File::isFile($attach)) {
            File::delete($attach);
        }

        return $deleted = true;
    }


    /**
     * @param  Request  $request
     * @param $attach
     * @param $directory
     * @param $model
     * @param $field
     * @return mixed|string
     */
    public function updateMultiMedia(Request $request, $attach, $directory, $model, $field)
    {

        // File upload, fit and store inside public folder
        if ($request->hasFile($attach)) {

            // Valid extension check
            $valid_extensions = [
                'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv',
                'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp'
            ];

            $file_ext = $request->file($attach)->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                $old_attach = public_path('uploads/' . $directory . '/' . $model->$field);
                if (File::isFile($old_attach)) {
                    File::delete($old_attach);
                }

                //Upload New File
                $filenameWithExt = $request->file($attach)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($attach)->getClientOriginalExtension();
                $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_',
                        $filename) . '_' . time() . '.' . $extension;

                //Crete Folder Location
                $path = public_path('uploads/' . $directory . '/');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                // Move file inside public/uploads/ directory
                $request->file($attach)->move('uploads/' . $directory . '/', $fileNameToStore);
            } else {
                $fileNameToStore = $model->$field;
            }
        } else {
            $fileNameToStore = $model->$field;
        }


        return $fileNameToStore;
    }


    /**
     * @param $directory
     * @param $model
     * @param $field
     * @return true
     */
    public function deleteMultiMedia($directory, $model, $field)
    {

        // Delete attach
        $attach = public_path('uploads/' . $directory . '/' . $model->$field);
        if (File::isFile($attach)) {
            File::delete($attach);
        }

        return $deleted = true;
    }

    /**
     * @param  Request  $request
     * @param $attach
     * @param $directory
     * @param $width
     * @param $height
     * @return string|null
     */
    public function uploadImage(Request $request, $attach, $directory, $width, $height)
    {

        // File upload, fit and store inside public folder
        if ($request->hasFile($attach)) {

            // Valid extension check
            $valid_extensions = array('jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp');
            $file_ext = $request->file($attach)->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                //Upload New File
                $filenameWithExt = $request->file($attach)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($attach)->getClientOriginalExtension();
                $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_',
                        $filename) . '_' . time() . '.' . $extension;

                //Crete Folder Location
                $path = public_path('uploads/' . $directory . '/');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                //Resize And Crop as Fit image here ($width width, $height height)
                $thumbnailpath = $path . $fileNameToStore;
                $img = Image::make($request->file($attach)->getRealPath())->resize($width, $height,
                    function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($thumbnailpath);
            } else {
                $fileNameToStore = null;
            }
        } else {
            $fileNameToStore = null;
        }

        return $fileNameToStore;
    }

    /**
     * @param  Request  $request
     * @param $attach
     * @param $directory
     * @param $width
     * @param $height
     * @param $model
     * @param $field
     * @return mixed|string
     */
    public function updateImage(Request $request, $attach, $directory, $width, $height, $model, $field)
    {

        // File upload, fit and store inside public folder
        if ($request->hasFile($attach)) {

            // Valid extension check
            $valid_extensions = array('jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp');
            $file_ext = $request->file($attach)->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                $old_attach = public_path('uploads/' . $directory . '/' . $model->$field);
                if (File::isFile($old_attach)) {
                    File::delete($old_attach);
                }

                //Upload New File
                $filenameWithExt = $request->file($attach)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($attach)->getClientOriginalExtension();
                $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_',
                        $filename) . '_' . time() . '.' . $extension;

                //Crete Folder Location
                $path = public_path('uploads/' . $directory . '/');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                //Resize And Crop as Fit image here ($width width, $height height)
                $thumbnailPath = $path . $fileNameToStore;
                $img = Image::make($request->file($attach)->getRealPath())->resize($width, $height,
                    function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($thumbnailPath);
            } else {
                $fileNameToStore = $model->$field;
            }
        } else {
            $fileNameToStore = $model->$field;
        }

        return $fileNameToStore;
    }
}
