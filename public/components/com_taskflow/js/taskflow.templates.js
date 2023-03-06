

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
}