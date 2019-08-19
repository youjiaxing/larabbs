<?php
/**
 *
 * @author : 尤嘉兴
 * @version: 2019/8/19 10:01
 */

namespace App\Handlers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'jpeg', 'gif'];
    protected $allowed_mime = ['image/jpeg', 'image/png', 'image/x-ms-bmp', 'image/gif', 'image/png'];

    public function save(UploadedFile $file, $folder, $file_prefix, $max_width = false)
    {
        // 确认是否图片
//        $file->getMimeType()

        // 确认存储路径
        $folder_name = "uploads/images/$folder/" . date('Ym/d');
        $uploaded_path = public_path($folder_name);

        // 扩展名
        $extension = strtolower($file->getClientOriginalExtension()) ?: "png";
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $this->allowed_mime)) {
            return false;
        }

        // 拼接文件名
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        $file->move($uploaded_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->reduceSize($uploaded_path . "/" . $filename, $max_width);
        }

        return [
            'path' => asset($folder_name) . "/$filename"
        ];

    }

    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);

        $image->resize($max_width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save();
    }
}