@extends('public.components.com_taskflow.template')

@php
    $component_meta_title = "Taskflow Main";
    $component_meta_description = "Taskflow Main description";
    $component_meta_keywords = "Taskflow Main keywords";
@endphp

@section('script-definitions')
<script>
    
</script>
@endsection

@section('component-page-content')



<div class="col-container active-exec" id='rowCollection'>
          <div class='col-row' id='master-row'>
            
       <div class='col-item col-date' data-section='t'>
         <div class='uk-text-medium content-mid'><span uk-icon='calendar'></span> <span class='hide-m'>  DEMO</span></div>
            </div>
            
<div class='col-item col-que head-act' tgc='active-que' data-section='q'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>Q</span> <span class='hide-m'>Waiting tasks</span></div>
            </div>
            
<div class='col-item col-exec head-act' tgc='active-exec' data-section='e'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>EX</span> <span class='hide-m'>Eecuted active tasks</span></div>
            </div>
            
<div class='col-item col-paus head-act' tgc='active-paus' data-section='p'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>P</span> <span class='hide-m'>Temporary paused tasks</span></div>
            </div>
            
            <div class='col-item col-fin head-act' tgc='active-fin' data-section='f'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>FN</span> <span class='hide-m'>Finished tasks</span></div>
            </div>
            
            <div class='col-item col-drop head-act' tgc='active-drop' data-section='d'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>D</span> <span class='hide-m'>Dropped tasks</span></div>
            </div>
            
      </div>
      
    
    </div>
   
  

@endsection

@section('page-scripts')
<script src="{{ asset('/public/components/com_taskflow/js/taskflow.calendar.js')}}"></script>
<script>

</script>

@endsection