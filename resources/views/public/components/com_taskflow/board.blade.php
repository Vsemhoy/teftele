@extends('public.components.com_taskflow.template')

@php
    $component_meta_title = "Taskflow Board";
    $component_meta_description = "Taskflow Board description";
    $component_meta_keywords = "Taskflow Board keywords";
@endphp

@section('script-definitions')
<script>
    
</script>
@endsection

@section('component-page-content')
<div class="uk-container uk-container-xlarge uk-margin-top">

<div class='tef-switch-board'>
  <ul class='tef-switch-board-nav'>
    <li class='tef-active'><a href="#">Teftele CRM</a></li>
    <li><a href="#">ETC</a></li>
    <li><a href="#">Car</a></li>
  </ul>
  <div class='tef-switch-boards'>

    <div class='tef-switch-board-item' uk-sortable='handle: .uk-sortable-handle' >

    <?php for ($i=0; $i < 3; $i++) { ?>
    
      <div class='tef-task-card-vertical-grouop'>
        <div class='tef-taskgroup-header'>
          <div class='uk-sortable-handle'><span class='tef-task-gr-marker'><i class="bi-arrows-move"></i></span></div>

          <div class="tef-cardgroup-title">Card group super Title</div>
          <div class='tef-taskgroup-header-last'><i class="bi-plus-square"></i><i class="bi-three-dots-vertical"></i></div>
        </div>
        <div class='tef-cardgroup-statusbar'>
          <span class='_queue'>queue</span>
          <span class='_executed'>active</span>
          <span class='_paused tef-active'>paused</span>
          <span class='_finished'>finished</span>
          <span class='_dropped'>dropped</span>
        </div>
        <div class='tef-group-statusgroups'>
          <div class='tef-statusgroup _queue' uk-sortable='group: sortable-group, handle: .uk-sortable-handle-task'>

            <div class='tef-task-card-in-group uk-sortable-handle-task'>
              
              <div class='tef-t-c-g-header'>
              <div class='uk-sortable-handle'><i class="bi-arrows-move"></i></div>
                <div class='tef-task-card-title'>Title of the task</div>
                <div class='tef-taskgroup-header-last'><i class="bi-three-dots-vertical"></i></div>
              </div>
              <div class='tef-task-card-body'>
                <div>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.
                </div>
                <div>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.
                </div>
              </div>

              <div class="tsm-card-footer tsm-card-padding">
        <div class="tsm-label lilo">Activity</div>
        <div class="tsm-label tsm-label-duration">2h 20min</div>
        <div class="tsm-label">4 steps</div>
        <div class="tsm-card-date uk-hidden">12-01-2045</div>
        <div class='tef-taskgroup-header-last'><i class="bi-plus-square "></i><i class="bi-check2-square"></i></div>
        </div>
            
            </div>

            <div class='tef-task-card-in-group uk-sortable-handle-task'>
              
              <div class='tef-t-c-g-header'>
              <div class='uk-sortable-handle'><i class="bi-arrows-move"></i></div>
                <div class='tef-task-card-title'>Title of the task 2</div>
              </div>
              <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</div>
            
            </div>

            <div class='tef-task-card-in-group uk-sortable-handle-task'>
              
              <div class='tef-t-c-g-header'>
              <div class='uk-sortable-handle'><i class="bi-arrows-move"></i></div>
                <div class='tef-task-card-title'>Title of the task 3</div>
              </div>
              <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</div>
            
            </div>

          </div>

          <div class='tef-statusgroup _executed'>

          </div>
          <div class='tef-statusgroup _paused'>

          </div>
          <div class='tef-statusgroup _finished'>

          </div>
          <div class='tef-statusgroup _dropped'>

          </div>

        </div>
      </div>
      <?php }; ?>

      <div class='tef-task-card-vertical-grouop'>
        <div class='uk-sortable-handle'>#</div>
        <h3 class="uk-card-title">Card group super Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
      </div>
      
      <div class='tef-task-card-vertical-grouop'>
  <div class='uk-sortable-handle'>#</div>
  <h3 class="uk-card-title">Card Title</h3>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
</div>

<div class='tef-task-card-vertical-grouop'>
  <div class='uk-sortable-handle'>#</div>
<h3 class="uk-card-title">Card Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
</div>
   
    </div>
  
  </div>
</div>


<br>

<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li ><a href="#">Teftele CRM</a></li>
    <li><a href="#">ETC</a></li>
    <li><a href="#">Car</a></li>
</ul>
<ul class="uk-switcher uk-margin">
    <li>Hello! <a href="#" uk-switcher-item="2">Switch to item 3</a></li>
    <li>Hello again! <a href="#" uk-switcher-item="next">Next item</a></li>
    <li>Bazinga! <a href="#" uk-switcher-item="previous">Previous item</a></li>
</ul>
</div>

<div class="uk-container uk-margin-top">
    <h3>Board</h3>
  <div class="uk-grid-match uk-child-width-1-2@m uk-child-width-1-3@l" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">Card Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
      </div>
    </div>
    <div>
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">Card Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
      </div>
    </div>
    <div>
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">Card Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
      </div>
    </div>
  </div>
  
</div>
@endsection