
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
  category: 0,
  tags: "",
  planned_time: 0,
  setter: 1,
  executor: 1,
  created_at : null,
  updated_at : null,
  schedule: [],
  steps: [
    {
      id: 1,
      text : "Step text",
      start_time : 75675,
      end_time: 456345,
      duration: 0
    },
  ],
  total_duration : 75896,
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
  viewMode_calendar : 0,
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
getTCM(date, status = 1, id = null){
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
  todo: "What to do",
  addTime: 534576,
  finTime: 5645634,
  checked: 0
};
CardSolutionModel = {
  id: 3,
  comment: "Super comment",
  added_at: 543645,
  owner: 1,
  ownerName : "Mark"
}
CardStepModel = {
  id: 1,
  text : "Step text",
  startTime : 75675,
  endTime: 456345,
  duration: 0
};

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
  getQTM(functionName = 'demo') {
    let qts = structuredClone(this.QueueTaskModel);
    qts.id = "qts_" + (Math.random() * (9999999 - 1000) + 1000).toFixed();
    qts.function = functionName;
    qts.timestamp = new Date().getTime();
    return qts;
  }

};