<?php

namespace SaTan\Dcat\Extensions\IceEditor\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use SaTan\Dcat\Extensions\IceEditor\DcatIceEditorServiceProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DcatIceEditorController extends Controller
{
    public function trans($key, $replace = [], $locale = null)
    {
        return DcatIceEditorServiceProvider::trans('controller.'.$key, $replace, $locale);
    }

    public function upload(Request $request)
    {
        $upload_name = explode(',',$request->get('upload_name'));

        if (count($upload_name)==1)
        {
            $files = $request->file($upload_name[0]);
        }else if(count($upload_name)==2)
        {
            $files = $request->has($upload_name[0])?
                $request->file($upload_name[0]):
                $request->file($upload_name[1]);
        }else{
            return ['error'=>0];
        }
        $dir = trim($request->get('dir'), '/');
        $disk = $this->disk();
        $return = [];
        //处理多文件上传
        foreach ($files as $file){
        $newName = $this->generateNewName($file);
        if ($disk->putFileAs($dir, $file, $newName))
        {
            $return[] = [
                'url'=>$disk->url("{$dir}/$newName"),
                'name'=>$newName,
                'error'=>0
            ];
        }else{
            $return[] = [
                'url'=>'',
                'name'=>'',
                'error'=>$this->trans('file.upload.error')
            ];
        }
        }

        return $return;
    }

    protected function generateNewName(UploadedFile $file): string
    {
        return uniqid(md5($file->getClientOriginalName())).'.'.$file->getClientOriginalExtension();
    }

    /**
     * @return Filesystem|FilesystemAdapter
     */
    protected function disk()
    {
        $disk = request()->get('disk') ?: config('admin.upload.disk');

        return Storage::disk($disk);
    }
}
