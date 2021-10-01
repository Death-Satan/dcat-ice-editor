<?php

namespace SaTan\Dcat\Extensions\IceEditor;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use SaTan\Dcat\Extensions\IceEditor\Form\IceEditor;

class DcatIceEditorServiceProvider extends ServiceProvider
{

	public function register()
	{

	}

	public function init()
	{
		parent::init();

		Form::extend('iceEditor',IceEditor::class);

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
