<?php
  /**
   * $data - is a combined object created at MainController
   */
  define('DATA', $data);
?>

@extends('public.components.com_taskflow.template')

@php
    $component_meta_title = 'Taskflow Main';
    $component_meta_description = 'Taskflow Main description';
    $component_meta_keywords = 'Taskflow Main keywords';
@endphp

@section('script-definitions')
<script>

  const currentUser = '<?php echo DATA->user->id ; ?>';
  const TaskCollection = [];

  //const TaskQueue = [];

  var path = '/com/taskflow/post/';
</script>
@endsection

@section('script-definitions')
<script>
    
</script>
@endsection

@section('component-page-content')
<style>



</style>
<div class='uk-container uk-container-xlarge uk-margin-top'>

<div class='tf-board-header uk-margin-bottom'>
    <div class='tef-control-group tef-control-rounded'>
        <div class='tef-button tef-button-color-rose'>Create board</div>
        <div class='tef-button tef-button-color-rose'>Hello</div>
    </div>
    <div class='tef-button tef-button-color-rose'>Hello</div>
    <div class='tef-button tef-button-color-rose'>Hello</div>
</div>

<ul class='uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s  uk-child-width-1-3@l uk-child-width-1-5@xl' id='my-sortable'  uk-sortable='handle: .uk-sortable-handle' uk-grid>
    <?php 
function renderCard($board, $route)
{
    $result = "    <li>
        <div class='grad uk-padding-small'>
            <div class='uk-card uk-card-default '>
                <div class='uk-card-header uk-padding-small'>
                    <div class='uk-grid-small uk-flex-middle' uk-grid>
                        <div class='uk-width-auto'>
                            <span class='uk-sortable-handle uk-margin-small-right uk-text-center' uk-icon='icon: table'></span>
                        </div>
                        <div class='uk-width-expand'>
                            <h3 class='uk-card-title uk-margin-remove-bottom'>{$board->name}</h3>
                            <p class='uk-text-meta uk-margin-remove-top'><time datetime='2016-04-01T19:00'>April 01, 2016</time> <span>200 tasks</span></p>
                        </div>
                    </div>
                </div>
                <div class='uk-card-body  uk-padding-small'>
                    <p>{$board->description}</p>
                </div>
                <div class='uk-card-footer  uk-padding-small'>
                    <a href='{$route}calendar/{$board->id}' class='uk-button uk-button-text'>Go to board</a>
                </div>
            </div>
        </div>
    </li>";
    return $result;
}


foreach ($data->board_list AS $board):
    echo renderCard($board, $data->route);

endforeach;
?>
    
</ul>
  
</div>

<script>
  const mySortable = document.getElementById('my-sortable');

  mySortable.addEventListener('moved', (event) => {
    //const movedItem = event.detail[0].parentNode;
    // call your function with the moved item
    console.log(event.target.innerHTML);
    //myFunction(movedItem);
  });

  function myFunction(item) {
    console.log(`Item ${item} was moved!`);
    // your code here
  }



</script>
@endsection