<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/25
 * @createTime: 22:52
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Dcat\Extensions\IceEditor\Form;

use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;
use Illuminate\Support\Str;
use Throwable;

class IceEditor extends \Dcat\Admin\Form\Field
{
    /**
     * 编辑器配置
     * @var array
     */
    protected $options = [
        'disk' => 'local',
        'uploadDirectory'=>'satan/ice-editor',
        'loadJs' => '',
        'uploadFileName'=>'file',
        'uploadImageName'=>'file',
    ];

    /**
     * 视图
     * @var string
     */
    protected $view = 'death_satan.dcat-ice-editor::ice-editor';


    /**
     * Js required by this field.
     *
     * @var array
     */
    protected static $js = [
        '@extension/death_satan/dcat-ice-editor/js/iceEditor.min.js'
    ];

    /**
     * 设置图片上传input name属性
     * @param string $field
     * @return $this
     */
    public function imageUploadName(string $field):self
    {
        $this->options['uploadImageName'] = $field;
        return $this;
    }

    /**
     * 设置文件上传的input name属性
     * @param string $field
     * @return $this
     */
    public function fileUploadName(string $field):self
    {
        $this->options['uploadFileName'] = $field;
        return $this;
    }

    /**
     * 配置上传驱动
     * @param string $disk
     * @return $this
     */
    public function disk(string $disk = 'local'):self
    {
        $this->options['disk'] = $disk;
        return $this;
    }


    public function load(string $js):self
    {
        $this->options['loadJs'] = $js;
        return $this;
    }

    /**
     * 获取默认上传地址
     * @return string
     */
    protected function defaultUploadUrl():string
    {
        return $this->formatUrl(route(admin_api_route_name('satan-ice-editor.upload.file')));
    }

    /**
     * 格式化url
     * @param string $url
     * @param string $type
     * @return string
     */
    protected function formatUrl(string $url,string $type='video'): string
    {
        return Helper::urlWithQuery($url, [
            'disk' => $this->options['disk'],
            'dir' => $this->options['uploadDirectory'],
            'upload_name'=>$this->options['uploadImageName'].','.$this->options['uploadFileName']
        ]);
    }

    /**
     * 设置上传路径
     * @param string $path
     * @return $this
     */
    public function path(string $path):self
    {
        $this->options['uploadDirectory'] = $path;
        return $this;
    }

    /**
     * 设置上传地址
     * @param string $server
     * @return $this
     */
    public function server(string $server):self
    {
        $this->options['server'] = $server;
        return $this;
    }

    /**
     * 生成id
     * @return string
     */
    protected function generateId():string
    {
        return 'ice-editor-'.Str::random(8);
    }


    public function render()
    {
        $this->addVariables(['name'=>$this->column]);

        //设置图片上传地址
        //设置视频上传地址
        empty($this->options['server']) && $this->options['server'] = $this->defaultUploadUrl();

        $this->addVariables(['id'=>$id = $this->generateId()]);
        $this->options['id'] = $id;

        $this->addVariables(['options'=>JavaScript::format($this->options)]);
        return parent::render();
    }
}
