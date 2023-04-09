

class TaskFlowTemplates
{


    constructor(){

    }

    getDurationTime($time){
      if ($time == 0){ return "...";}
      let min =  $time / 1000 / 60;
      let time = min.toFixed() + "min";
      if (min / 60 > 1){
        let hr  = Math.floor(min / 60);
        min = Math.floor(min - (hr * 60));
        time = hr + "h " + min + "min";
        if (min == 0){
          time = hr + "h ";
        }
        if (hr / 24 > 1){
          let dy  = Math.floor(hr / 24);
          hr = hr - (dy * 24);
          min = Math.floor(min );
          time = dy + "d " +  hr + "h " + min + "min";
          if (min == 0){
            time = dy + "d " +  hr + "h ";
          }
          if (min == 0 && hr == 0){
            time = dy + "d";
          }
        }
      }
      return time;
    }

    getCurrentTimeString()
    {
      var currentdate = new Date(); 
      var datetime = currentdate.getDate() + "/"
                  + (currentdate.getMonth()+1)  + "/" 
                  + currentdate.getFullYear() + " "  
                  + currentdate.getHours() + ":"  
                  + currentdate.getMinutes();
                  return datetime;
    }

    getTaskListTableCheckListTableRow(checkmodel){
        let id = checkmodel.id;
        let text = checkmodel.text;
        let addTime = checkmodel.addTime;
        let finTime = checkmodel.finTime;
        let is_checked = checkmodel.checked;
        let finClass = "";
        if (is_checked != 0){
            is_checked = "checked";
            finClass = "tf-t-check-fin";
        }
let result = `  <tr id='${id}' class='tf-t-checklist-item ${finClass}'>
        <td><input class="uk-checkbox tf-t-checkbox" type="checkbox" aria-label="Checkbox" ${is_checked}></td>
        <td class="uk-table-link">
            <div class="tf_t_check_editable uk-padding-small">${text}</div>
        </td>
        <td class="uk-text-truncate tf-t-c-addtime">${addTime}</td>
        <td class="uk-text-nowrap tf-t-c-fintime">${finTime}</td>
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


    encodeHTMLEntities(text) {
      let textArea = document.createElement('textarea');
      textArea.innerText = text;
      let encodedOutput=textArea.innerHTML;
      let arr=encodedOutput.split('<br>');
      encodedOutput=arr.join('\n');
      return encodedOutput;
    }

    getTaskCardInCalendar(obj, countSessions = 0){
      let id = obj.id;
      let visual_state = obj.visual_state;
      let name = obj.name;
      let description = obj.description;
      let result_text = obj.result;
      let duration = obj.duration_real;
      let checkButtonClass = "tsm-card-button-disabled";
      if (obj.checklist.length > 0){
        checkButtonClass = "tf_card_event_checkifycard";
      }

      let infoButtonClass = "tsm-card-button-disabled";
      if (obj.description.length > 0 || obj.result.length > 0){
        infoButtonClass = "tf_card_event_midifycard";
      }

      console.log(obj.checklist.length , " CHecklist length", obj.checklist);

        id = "item_" + id;
        let visClass = "";
        if (visual_state == 0){
          visClass = "tsm-vis-hidden";
        } else if (visual_state == 1){
          visClass = "tsm-vis-middle";
        } else if (visual_state == 2){
          visClass = "tsm-vis-cheddle";
        }
        let sessions = "";
        if (countSessions > 0){
          sessions = countSessions + " steps";
        }
        // ondragstart="drag(event)"
        name = this.encodeHTMLEntities(name);
        description = this.encodeHTMLEntities(description);
        result_text = this.encodeHTMLEntities(result_text);
        description = description.replace(/\n/g, "<br>");
        result_text = result_text.replace(/\n/g, "<br>");
        let result = `<div class='tsm-card tsm-status-done dragitem ${visClass}'
         draggable="true"  id="${id}">
        <div class='tsm-card-row'>
        <div class='tsm-card-pre-header' title='${name}'>
    <div class='tsm-card-padding'>
        ST
            </div>
        </div>

    <div class='tsm-card-header hide-m'>
        <div class='tsm-card-padding'>
            <div class='tsm-card-name'>${name}</div>
        </div>
        <div class='tsm-card-topbuttons'>
            <div class='tsm-card-button tf_card_event_minifycard' title='hide all'>_</div>
            <div class='tsm-card-button ${infoButtonClass}' title='toggle content'>=</div>
            <div class='tsm-card-button ${checkButtonClass}' title='toggle checklist'>C</div>
            <div class='tsm-card-button tf_card_event_expandcard' title='toggle events'>E</div>
        </div>
    </div>
</div>`;

if (description != ""){
result += `
<div class='tsm-card-row tsm-content-row'>
    <div class='tsm-card-pre-body hide-m'>
        <div class='tsm-card-padding'>
            <div title='description'><i class='bi-box-arrow-in-down'></i></div>
        </div>
        <div></div>
    </div>

    <div class='tsm-card-body hide-m'>
        <div class='tsm-card-padding tsm-card-content'>
            <div class='uk-text'>
              ${description}
            </div>
        </div>
    </div>
</div>`;    
};
if (result_text != ""){
  result += `
  <div class='tsm-card-row tsm-content-row'>
      <div class='tsm-card-pre-body hide-m'>
          <div class='tsm-card-padding'>
              <div title='result'><i class='bi-box-arrow-up'></i></div>
          </div>
          <div></div>
      </div>
  
      <div class='tsm-card-body hide-m'>
          <div class='tsm-card-padding tsm-card-content'>
              <div class='uk-text'>
                ${result_text}
              </div>
          </div>
      </div>
  </div>`;    
  };

if (obj.checklist.length > 0){
  obj.checklist.forEach((item) => {
    let checkicon = "<div class='tsm-check-selector' title='' check-id='" + item.id + "'><i class='bi-app'></i></div>";
    let rowClass = "";
    if (item.checked == 1){
      checkicon = "<div class='tsm-check-selector' title='done' check-id='" + item.id + "'><i class='bi-check2-square'></i></div>";
      rowClass = "tsm-checked";
    }
    result += `
    <div class='tsm-card-row tsm-check-row ${rowClass}'>
        <div class='tsm-card-pre-body hide-m'>
            <div class='tsm-card-padding'>
                ${checkicon}
            </div>
            <div></div>
        </div>
    
        <div class='tsm-card-body hide-m'>
            <div class='tsm-card-padding tsm-card-content'>
                <div class='uk-text'>
                  ${item.text}
                </div>
            </div>
        </div>
    </div>`;    
    });
  };


result += `
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
  <div class='tsm-card-padding'></div>
  <div class='hide-m'>
    <div class='tsm-card-footer tsm-card-padding'>
        <div class='tsm-label'>Group</div>
        <div class='tsm-label lilo'>project</div>
        <div class='tsm-label tsm-label-duration'>${this.getDurationTime(duration)}</div>
        <div class='tsm-label'>${sessions}</div>
        <div class='tsm-card-date uk-hidden'>12-01-2045</div>
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



    getBoardManagerBoardCard(board, route) {
      const result = `
        <li>
            <div class='grad uk-padding-small'>
                <div class='uk-card uk-card-default '>
                    <div class='uk-card-header uk-padding-small'>
                        <div class='uk-grid-small uk-flex-middle' uk-grid>
                            <div class='uk-width-auto'>
                                <span class='uk-sortable-handle uk-margin-small-right uk-text-center' uk-icon='icon: table'></span>
                            </div>
                            <div class='uk-width-expand'>
                                <h3 class='uk-card-title uk-margin-remove-bottom'>${board.name}</h3>
                                <p class='uk-text-meta uk-margin-remove-top'><time datetime='2016-04-01T19:00'>April 01, 2016</time> <span>200 tasks</span></p>
                            </div>
                        </div>
                    </div>
                    <div class='uk-card-body  uk-padding-small'>
                        <p>${board.description}</p>
                    </div>
                    <div class='uk-card-footer  uk-padding-small'>
                        <a href='${route}calendar/${board.id}' class='uk-button uk-button-text'>Go to board</a>
                    </div>
                </div>
            </div>
        </li>
      `;
      return result;
    }
}