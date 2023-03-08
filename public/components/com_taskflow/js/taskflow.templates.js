

class TaskFlowTemplates
{


    constructor(){

    }


    getTaskListTableCheckListTableRow(){
        let text = "NewChekItem";
        let addTime = new Date();
        let finTime = "";
        let finished = false;
        let is_checked = "";
        let finClass = "";
        if (finished){
            is_checked = "checked";
            finClass = "tf-t-check-fin";
        }
let result = `  <tr class='tf-t-checklist-item ${finClass}'>
        <td><input class="uk-checkbox" type="checkbox" aria-label="Checkbox" ${is_checked}></td>
        <td class="uk-table-link">
            <div class="tf_t_check_editable uk-padding-small">${text}</div>
        </td>
        <td class="uk-text-truncate">${addTime}</td>
        <td class="uk-text-nowrap">${finTime}</td>
        <td class="uk-text-nowrap"><span class='tf-event-removecheck u-icon-std u-icon-event uk-text-muted bi-trash'></span></td>
    </tr>`;
    return result;
    }


    getTaskListEditorStepItem(){
        let result = `<form class='tf-task-form-step uk-margin'>

              <div class='tf-task-form-step-body uk-padding-small uk-padding-remove-bottom'>
                  <div class='uk-flex uk-flex-between'>
                    <label class='uk-text-muted'>#1 24.03.2004 14:55</label>
                    <span class="tf-event-removecheck u-icon-std u-icon-event uk-text-muted bi-trash"></span>
                  </div>
                <div class='u-custom-input-awake'>
                  <textarea class="uk-textarea" rows='4' disabled>Helllow</textarea>
                </div>
                  <div class='uk-margin uk-column-1-3'>
                <div class='u-custom-input-awake'>
                  <label class='uk-text-small'>Started at <span class='uk-text-muted'></span></label>
                  <input class="uk-input" disabled type="datetime-local">
                </div>
                <div class='u-custom-input-awake'>
                  <label class='uk-text-small'>Finished at<span class='uk-text-muted'></span></label>
                  <input class="uk-input" disabled type="datetime-local" min='0' max='999'>
                </div>
                <div class='u-custom-input-awake'>
                  <label class='uk-text-small'>Duration  <span class='uk-text-muted'></span></label>
                  <input class="uk-input" disabled type="text" min='0' max='9999'>
            </div>
          </div>
        </div>
      </form>`;
      return $result;
    }


    getTaskCardInCalendar(){
        let id = "item_" + Math.floor(Math.random() * 9999999);
        let result = `<div class='tsm-card tsm-status-done dragitem tsm-vis-hidden'
         draggable="true" ondragstart="drag(event)" id="${id}">
        <div class='tsm-card-row'>
        <div class='tsm-card-pre-header'>
    <div class='tsm-card-padding'>
        ST
            </div>
        </div>

    <div class='tsm-card-header hide-m'>
        <div class='tsm-card-padding'>
            <div class='tsm-card-name'>The super pooper task...</div>
        </div>
        <div class='tsm-card-topbuttons'>
            <div class='tsm-card-button tf_card_event_minifycard' title='hide all'>_</div>
            <div class='tsm-card-button tf_card_event_midifycard' title='toggle content'>=</div>
            <div class='tsm-card-button tf_card_event_expandcard' title='toggle events'>E</div>
        </div>
    </div>
</div>

<div class='tsm-card-row '>
    <div class='tsm-card-pre-body hide-m'>
        <div class='tsm-card-padding'>
            <div>MS</div>
        </div>
        <div>EDT</div>
    </div>

    <div class='tsm-card-body hide-m'>
        <div class='tsm-card-padding tsm-card-content'>
            <div class='uk-text'>And The super pooper task... The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</div>
                <br>
                <div class='uk-text'>Next day i will go to church and see a mitropolis</div>
                <div class='uk-text'>The super pooper truck...</div>
        </div>
    </div>
</div>    
  
<div class='tsm-card-row tsm-mid-mark'>
    <div class='tsm-card-padding'>
        <div>1</div>
        <div>EDT</div>
    </div>
    <div class='hide-m'>
        <div class='tsm-task-session-body tsm-card-padding'>
            <div>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</div>
            <div class='tsm-task-session-date'><div>23.04.2022</div><div>5 hours</div></div>
        </div>
    </div>
</div>  

<div class='tsm-card-row tsm-mid-mark'>
    <div class='tsm-card-padding'><div>2</div>
        <div>EDT</div>
    </div>
  <div>

    <div class='tsm-task-session-body tsm-card-padding hide-m'>
        <div>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</div>
        <div class='tsm-task-session-date'>23.04.2022</div>
        </div>
  </div>
</div>
  
<div class='tsm-card-row'>
  <div class='tsm-card-padding'>INFO</div>
  <div class='hide-m'>
    <div class='tsm-card-footer tsm-card-padding'>
        <div class='tsm-label'>Group</div>
        <div class='tsm-label lilo'>Category</div>
        <div class='tsm-label'>Duration: 132h 32m</div>
        <div class='tsm-label'>Sessions: 19</div>
          <div class='tsm-card-date'>12-01-2045</div>
        </div>
  </div>
</div>
  

</div>
</div>`;
return result;
    }

    getRandomInt() {
        let max = 32000000000;
        return Math.floor(Math.random() * max);
      }

    getTaskCardTempBlock(temp_id){
        let result = "<div class='tf-temp-card' id='" + 
        temp_id + "'><div><span class='tf-t-c-clock bi-arrow-clockwise'></span></div> Inserting...</div>";
        return result;

    }

}