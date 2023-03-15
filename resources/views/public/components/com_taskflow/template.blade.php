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

<div id='component_bottom_bar' class='u-sticky-bottom-bar'>
    <div uk-grid>
        <div class='uk-button '><span uk-icon='more-vertical'></span></div>
        <div class='uk-button uk-button-default'>Board: </div>
        <div>
            <select class="uk-select">
                <option>SPL-module</option>
                <option>Tele-CRM</option>
                <option>Personal Deals</option>
            </select>
        </div>
        <div>
            <div class='tsm-active-counter tsm-hidden' id='tsm_counter'>
                <div class='tsm-counter-preloader'><span class='tf-t-c-clock bi-arrow-clockwise'></span></div> <span class='tsm-counter-value'>0</span>
            </div>
        </div>
    </div>

    <div>
        <div class='uk-button uk-button-default'>New task</div>
    </div>

    <div>
        <div class='uk-button '><span uk-icon='more-vertical'></span></div>
    </div>
</div>

@endsection

@section('component-assets')
<link rel="stylesheet" href="{{ asset('/public/components/com_taskflow/css/taskflow.css') }}" />
    <style>
    
    </style>
@endsection


@section('component-scripts')
<script src="{{ asset('/public/components/com_taskflow/js/taskflow.templates.js')}}"></script>   
<script src="{{ asset('/public/components/com_taskflow/js/taskflow.models.js')}}"></script>   
<script src="{{ asset('/public/components/com_taskflow/js/taskflow.js')}}"></script>   
<script>
</script>    

@endsection