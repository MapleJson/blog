<?php

use App\Admin\Extensions\WangEditor;
use Encore\Admin\Form;

Form::forget(['map', 'editor']);

Form::extend('editor', WangEditor::class);

app('view')->prependNamespace('admin', resource_path('views/admin'));
