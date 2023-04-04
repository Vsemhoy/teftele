
class TaskFlowModels {

TaskCardModel =
{
  id: 1,
  temp_id : 0,
  parent_id : null,
  name: "",
  description: "",
  result: "",
  status: 1,
  board: 1,
  type: 3,
  group: 1,
  group_order : 1,
  project: 0,
  tags: "",
  setter: 1,
  executor: 1,
  created_at : null,
  updated_at : null,
  schedule: [],
  steps: [
    {
      id: 1,
      event_code: [0, 1],
      text : "Step text",
      start_time : 75675,
      end_time: 456345,
      duration: 0
    },
  ],
  duration_real : 0,
  duration_planned: 0,
  solutions : [{
    id: 3,
    comment: "Super comment",
    added_at: 543645,
    owner: 1,
    owner_name : "self"
  }],
  checklist: [{
    id : 1,
    todo: "What to do",
    add_time: 534576,
    fin_time: 5645634,
    checked: 0
  }],
  checks_total: 0,
  checks_checked: 0,
  checks_percent: 0,
  condition_phys: 100,
  condition_emo: 100,
  condition_intel: 100,
  visual_state : 0,
  date_set : null,
  date_start_real: null,
  date_finish_real: null,
  date_start_plan: null,
  date_finish_plan: null,
};
/**
 * Create a task object model with default data
 * 
 */
getTaskCardModel(date, status = 1, id = null){
  let qtm = structuredClone(this.TaskCardModel);
  qtm.id = null;
  qtm.steps = [];
  qtm.solutions = [];
  qtm.checklist = [];
  qtm.status = status;
  qtm.date_set = date;
  qtm.board = 0;
  qtm.type = 0;
  qtm.group = 0;
  return qtm;
}


CardCheckListModel = {
  id : 1,
  text: "What to do",
  addTime: 534576,
  finTime: 5645634,
  checked: 0
};
getCheckListItemModel(id = null, text = "", addtime = "", fintime = "", checked = 0)
{
  let chm = structuredClone(this.CardCheckListModel);
  chm.id = id;
  if (id == null){
    chm.id = "checkitem_" + Date.now() + '' + (Math.random(0, 999999) * 10000).toFixed();
  }
  chm.text = text;
  chm.addTime = addtime;
  if (addtime == ""){
    chm.addTime = this.getCurrentTimeString();
  }
  chm.finTime = fintime;
  chm.checked = checked;
  return chm;
}

CardSolutionModel = {
  id: 3,
  comment: "Super comment",
  added_at: 543645,
  owner: 1,
  ownerName : "Mark"
}
// CardStepModel = {
//   id: 1,
//   event_codes: [0, 1],
//   event_dates: [0, 0],
//   event_times: [0, 0],
//   text : "Step text",
//   duration: 0 // in seconds
// };
// getCardStepModel(id, codes, dates, times, text = "", duration = 0)
// {
//   let csm = structuredClone(this.CardStepModel);
//   csm.id = id;
//   csm.event_codes = codes;
//   csm.event_dates = dates;
//   csm.event_times = times;
//   csm.text = text,
//   csm.duration = duration;
//   return csm;
// }

CardStepModel = {
  id: 1,
  event_code: 0,
  event_date: 0,
  event_time: 0,
  text : "Step text",
  duration: 0 // in seconds related to parent event
};
getCardStepModel(id, code, date, time, text = "", duration = 0)
{
  let csm = structuredClone(this.CardStepModel);
  csm.id = id;
  csm.event_code = code;
  csm.event_date = date;
  csm.event_time = time;
  csm.text = text,
  csm.duration = duration;
  return csm;
}

QueueTaskModel = {
    id : "qts_" + (Math.random() * (9999999 - 1000) + 1000).toFixed(),
    function: "demo",
    params : {},
    object: {},
    status : 0,
    attempts : 0,
    timestamp: new Date().getTime(),
}
  /**
   * 
   * @param {*function_name} string (create, update, remove, move, step)
   * @returns Object of QueueTask Model with new ID 
   */
  getQueueTaskModel(functionName = 'demo') {
    let qts = structuredClone(this.QueueTaskModel);
    qts.id = "qts_" + (Math.random() * (9999999 - 1000) + 1000).toFixed();
    qts.function = functionName;
    qts.timestamp = new Date().getTime();
    return qts;
  }


  getCurrentTimeString()
  {
    var currentdate = new Date(); 
    var datetime = currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes();
                // + ":" 
                //+ currentdate.getSeconds();
                return datetime;
  }
};