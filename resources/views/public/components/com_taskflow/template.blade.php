<?php
//use App\Http\Controllers\Template\TemplateController;
// Template switcher view
//$template = new TemplateController();

// this is the global template of component which define styles, scripts and outline
// ahassection('')
?>
@extends('public.templates.main')
<?php // set global template variables ?>

@if (isset($component_meta_title) AND filled($component_meta_title))
    @php
    $meta_title = $component_meta_title;
    @endphp
@else
    @php
        $meta_title = "Component title";
    @endphp
@endif

@if (isset($component_meta_description) AND filled($component_meta_description))
    @php
        $meta_description = $component_meta_description;
    @endphp
@else
    @php
        $meta_description = "Component description";
    @endphp
@endif

@if (isset($component_meta_keywords) AND filled($component_meta_keywords))
    @php
    $meta_keywords = $component_meta_keywords;
    @endphp
@else
    @php
        $meta_keywords = "Component keywords";
    @endphp
@endif


    

@section('page-content')
<div id='component_content'>
    @yield('component-page-content')
</div>
@endsection

@section('component-assets')
<link rel="stylesheet" href="{{ asset('/public/components/com_taskflow/css/taskflow.css') }}" />
    <style>
    
    </style>
@endsection


@section('component-scripts')
<script>
    // com script    
</script>    

@endsection