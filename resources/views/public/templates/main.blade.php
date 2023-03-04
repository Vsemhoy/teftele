<?php
use App\Http\Controllers\Template\TemplateController;
use App\Http\Controllers\PublicPageController;
// Template switcher view
$template = new TemplateController();
$controller = new PublicPageController;
$topMenu = $controller->getAllTopMenuItems();

?>

@extends('public.templates.' . $template->templateFolderName . '.template')

@section('global-assets')
    <!-- initialize fontawesome -->
    <link rel="stylesheet" href="{{ asset('/public/vendor/bootstrap/icons/bootstrap-icons.css')}}"/>

@endsection