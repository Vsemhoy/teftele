<?php
  /**
   * $data - is a combined object created at MainController
   */
  define('DATA', $data);
  $taskTypes = [];

  for ($i = 1; $i <= 20; $i++) {
    $obj = (object) [
        'id' => $i,
        'name' => "Activity $i",
        'color' => "#CC4488",
        'owner' => 1,
        'order' => $i
    ];
    array_push($taskTypes, $obj);
}
  //print_r($data);
?>

@extends('public.components.com_taskflow.template')

@php
    $component_meta_title = "Taskflow Main";
    $component_meta_description = "Taskflow Main description";
    $component_meta_keywords = "Taskflow Main keywords";
@endphp

@section('script-definitions')
<script>
  var currentTaskBoard = '<?php echo DATA->board->id?>';
  var pageCommandStack = [];
  const currentUser = '<?php echo DATA->user->id ; ?>';
  const TaskCollection = [];

  const TaskQueue = [];

  var path = "/com/taskflow/post/";
</script>
@endsection

@section('component-page-content')



<div class="col-container active-exec" id='rowCollection'>
          <div class='col-row' id='master-row'>
            
       <div class='col-item col-date' data-section='t'>
         <div class='uk-text-medium content-mid'><span uk-icon='calendar'></span> <span class='hide-m'>  DEMO</span></div>
            </div>
            
      <div class='col-item col-que tf-head-act' tgc='active-que' data-section='q'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>Q</span> <span class='hide-m'>Waiting tasks</span></div>
            </div>
            
      <div class='col-item col-exec tf-head-act' tgc='active-exec' data-section='e'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>EX</span> <span class='hide-m'>Eecuted active tasks</span></div>
            </div>
            
      <div class='col-item col-paus tf-head-act' tgc='active-paus' data-section='p'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>P</span> <span class='hide-m'>Temporary paused tasks</span></div>
            </div>
            
            <div class='col-item col-fin tf-head-act' tgc='active-fin' data-section='f'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>FN</span> <span class='hide-m'>Finished tasks</span></div>
            </div>
            
            <div class='col-item col-drop tf-head-act' tgc='active-drop' data-section='d'>
         <div class='uk-text-medium content-mid'><span class='uk-text-bold'>D</span> <span class='hide-m'>Dropped tasks</span></div>
            </div>
            
      </div>
      
    
    </div>
   

<div id="tf_modal_task_editor" class="uk-flex-top uk-modal-container" uk-modal>
  
  <div class="uk-modal-dialog uk-margin-auto-vertical">
    <button class="uk-modal-close-default" type="button" uk-close></button>
        <!-- <div class="uk-modal-header">
            <h2 class="uk-modal-title uk-text-lead">Modal-title</h2>
        </div> -->
        <div uk-overflow-auto >
        <ul class="uk-subnav uk-subnav-pill" uk-switcher style="padding: 6px;">
          <li><a href="#"><span class='bi-calendar2-check'></span> Task</a></li>
          <!-- <li><a href="#"><span class='bi-calendar3'> Schedule</a></li> -->
          <li><a href="#"><span class='bi-card-list'> Steps</a></li>
          <li><a href="#"><span class='bi-gear'> Params</a></li>
          <li><a href="#"><span class='bi-capsule'> Solutions</a></li>
          <li><a href="#"><span class='bi-card-checklist'> Checklist</a></li>
        </ul>
        
        <ul class="uk-switcher uk-margin">
          <li class='u-custom-minheight'>
            <div class="uk-modal-body ">
            <form class='uk-column-1-1@s uk-column-1-2@m '>
        <div class='uk-margin'>
          <label class='uk-text'>Name</label>
          <input class="uk-input" type="text"  id='tf_input_name'>
        </div>
        <div class='uk-margin'>
          <label class='uk-text'>Description</label>
          <textarea class="uk-textarea" rows='5'  maxlength='5000' id='tf_input_description'></textarea>
        </div>
        <div class='uk-margin'>
          <label class='uk-text'>Result</label>
          <textarea class="uk-textarea" rows='5' maxlength='5000' id='tf_input_result'></textarea>
        </div>
        <div class='uk-margin'>
          <label class='uk-text'>Type</label>
          <select class="uk-select" id='tf_input_type'>
            <option value='0'>No Type</option>
            <?php 
              $lastGroup = "";
              foreach (DATA->type_list as $value) {
                if ($lastGroup != $value->group_name){
                  
                  echo "<option class='uk-text-bold' disabled value='" .  $value->id . "'>" . $value->group_name . "</option>";
                }
                echo "<option value='" .  $value->id . "'>  " . $value->name . "</option>";
                $lastGroup = $value->group_name;
              };
              ?>
          </select>
        </div>
        <div class='uk-margin'>
          <label class='uk-text'>Status</label>
          <select class="uk-select" id='tf_input_status'>
            <option value='1'>Waiting</option>
            <option value='2'>Running</option>
            <option value='3'>Paused</option>
            <option value='4'>Finished</option>
            <option value='5'>Removed</option>
            <option></option>
          </select>
        </div>
        <div class='uk-margin'>
          <label class='uk-text'>Board</label>
          <select class="uk-select"  id='tf_input_board'>
            <?php
            $result = "";
            foreach(DATA->board_list AS $board)
            {
              $selected = "";
              if ($board->id == DATA->board->id){
                $selected = "selected='selected'";
              }
              $result .= "<option value='{$board->id}' {$selected}>{$board->name}</option>";
            }
            echo $result;
            ?>
          </select>
        </div>
        <div class='uk-margin'>
          <label class='uk-text'>Group</label>
          <select class="uk-select"  id='tf_input_group'>
            <option value='0'>No Group</option>
            <?php 
              foreach (DATA->group_list as $value) {
                echo "<option value='" .  $value->id . "'>" . $value->name . "</option>";
              };
              ?>
          </select>
        </div>

        <div class='uk-margin'>
          <label class='uk-text'>Project</label>
          <select class="uk-select"  id='tf_input_project'>
            <option value='0'>No project</option>
            <?php 
              foreach (DATA->project_list as $value) {
                echo "<option value='" .  $value->id . "'>" . $value->name . "</option>";
              };
              ?>
          </select>
        </div>
        <div class='uk-margin'>
          <label class='uk-text'>Tags</label>
          <input class="uk-input" type="text"  id='tf_input_tags'>
        </div>

        <div class='uk-margin uk-column-1-3'>
          <div>
            <label class='uk-text'>Days <span class='uk-text-muted'>planned</span></label>
            <input class="uk-input" type="number" min='0' max='999'  id='tf_input_days'>
          </div>
          <div>
            <label class='uk-text'>Hours <span class='uk-text-muted'>planned</span></label>
            <input class="uk-input" type="number" min='0' max='999' id='tf_input_hours'>
          </div>
          <div>
            <label class='uk-text'>Minutes  <span class='uk-text-muted'>planned</span></label>
            <input class="uk-input" type="number" min='0' max='9999' id='tf_input_minutes'>
          </div>
          <div class='uk-hidden'>
            <label class='uk-text'>Totaltime in seconds<span class='uk-text-muted'>planned</span></label>
            <input class="uk-input" type="number" min='0' max='9999' id='tf_input_duration_p'>
          </div>
        </div>
        
        <div class='uk-margin'>
          <label class='uk-text'>Setter</label>
          <select class="uk-select" id='tf_input_setter'>
            <?php 
            echo "<option value='" . DATA->user->id . "'>" . DATA->user->name . "</option>";
            ?>
          </select>
        </div>

        <div class='uk-margin'>
          <label class='uk-text'>Maker</label>
          <select class="uk-select" id='tf_input_executor'>
          <?php 
            echo "<option value='" . DATA->user->id . "'>" . DATA->user->name . "</option>";
            ?>
          </select>
        </div>

      </form>
    </div>
    </li>
    <!-- <li class='u-custom-minheight'>
      <div class='uk-modal-body u-custom-minheight'>
        schedule
      </div>
    </li> -->
    <li>
      <div class='uk-modal-body u-custom-minheight uk-padding-remove' id='tf_t_steplist'>


      </div>
    </li>
    <li class='u-custom-minheight'>
      <div class='uk-modal-body u-custom-minheight'>
            <form class='uk-column-1-1@s uk-column-1-2@m '>
            <div class='uk-margin'>
              <label class='uk-text'>Physical condition</label>
              <input id="tf_t_phys_cond" class="uk-range" min="0" max="255" step="1" type="range">
            </div>
            <div class='uk-margin'>
              <label class='uk-text'>Emotional condition</label>
              <input id="tf_t_emo_cond" class="uk-range" min="0" max="255" step="1" type="range">
            </div>
            <div class='uk-margin'>
              <label class='uk-text'>Intelligence condition</label>
              <input id="tf_t_intel_cond" class="uk-range" min="0" max="255" step="1" type="range">
            </div>
            <div class='uk-margin'>
              <label class='uk-text'>Condition color</label>
              <input id="tf_t_cond_color" class="" type="color">
            </div>
            </form>
        <div class='uk-margin'>
      </div>
    </li>
    <li class='u-custom-minheight'>
      
    <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
        <thead>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-width-small">Comment</th>
                <th class="uk-table-expand">Solution</th>
                <th class="uk-table-small uk-text-nowrap"><div class='uk-text-lead'><span class='tf-event-addcheck u-icon-std u-icon-event bi-plus-square'></span></div></th>
            </tr>
        </thead>
        <tbody id="tf_t_solution_list">

        <tr class='tf-t-checklist-item '>
        <td><input class="uk-checkbox" type="checkbox" aria-label="Checkbox" /></td>
        <td class="uk-text-truncate">
          <div class="tf_t_check_editable uk-padding-small"></div>
          
        </td>
        <td class="uk-table-link uk-padding-small">
          <div class='uk-card uk-card-default uk-padding-small'>
            This is the Deceicions one djklfdj skfjasdjfasj kdfjklasjd kljfasdjdfasj dkjasd jfasldfj asjlkdfj aslk jdflksadklf sdf ....
          </div>
        </td>
        <td class="uk-text-nowrap"><span class='tf-event-removecheck u-icon-std u-icon-event uk-text-muted bi-trash'></span></td>
    </tr>

        </tbody>
    </table>

    </li>
<li class='u-custom-minheight'>

<table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
        <thead id=''>
            <tr>
                <th class="uk-table-shrink"></th>
                <th class="uk-table-expand">What to do</th>
                <th class="uk-width-small">Added</th>
                <th class="uk-table-shrink uk-text-nowrap">Finished</th>
                <th class="uk-table-shrink uk-text-nowrap"><div class='uk-text-lead'><span class='tf-event-addcheck u-icon-std u-icon-event bi-plus-square'></span></div></th>
            </tr>
        </thead>
        <tbody id="tf_checks_list">

        </tbody>
    </table>
    <div class="uk-padding-small uk-padding-remove-top u-two-col-flex">
      <div>
      <span id='tf_t_countchecked'>4</span> of 
      <span id='tf_t_countchecktotal'>8</span> are finished.</div> 
      <div>
<span class='uk-text tf-event-addcheck'>Add more? <span class=' u-icon-std u-icon-event bi-plus-square'></span></span>
</div>

  </li>


</ul>

</div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button id='tf_btn_savetask' class="uk-button uk-button-primary" type="button">Save</button>
        </div>
    </div>
</div>

@endsection


@section('component-bottom-bar')
<div id='component_bottom_bar' class='u-sticky-bottom-bar'  style='background: rgb(131,58,180);
    background: linear-gradient(90deg, rgba(131,58,180,0.7) 0%, rgba(163,34,182,0.7) 45%, rgba(252,69,69,0.7) 100%);'>
    <div uk-grid>
        <div class='uk-button '><span uk-icon='more-vertical'></span></div>
        <form >
        <select class="uk-select uk-form-small" id='tf_select_to_go' style='padding-right: 18px; background: none;
    color: white;
    font-size: medium;
    font-weight: 900;
    line-height: 1.9rem;'>
            <?php
            $result = "";
            foreach(DATA->board_list AS $board)
            {
              $selected = "";
              if ($board->id == DATA->board->id){
                $selected = "selected='selected'";
              }
              $result .= "<option value='{$board->id}' {$selected}>{$board->name}</option>";
            }
            echo $result;
            ?>
          </select>
            </form>
        <div>
            <div class='tsm-active-counter tsm-hidden' id='tsm_counter'>
                <div class='tsm-counter-preloader'><span class='tf-t-c-clock bi-arrow-clockwise'></span></div> <span class='tsm-counter-value'>0</span>
            </div>
        </div>
    </div>


    <div>
        <div class='uk-button '><span uk-icon='more-vertical'></span></div>
    </div>
</div>
<script>
  let boardChanger = document.querySelector('#tf_select_to_go');
  boardChanger.addEventListener('change', (ev)=> {
    let val = boardChanger.options[boardChanger.selectedIndex].value;
    window.location.href = "{{ route('taskflow.calendar')}}/" + val;
 
  });
</script>
@endsection


@section('page-scripts')
<script src="{{ asset('/public/components/com_taskflow/js/taskflow.calendar.js')}}"></script>
<script>

</script>

@endsection