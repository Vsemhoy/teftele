
class TaskFlowModels {

TaskCardModel =
{
    id: 1,
    temp_id : 0,
    parent_id : null,
  name: "name",
  description: "descripty",
  status: 1,
  board: 1,
  type: 3,
  group: 1,
  groupOrder : 1,
  category: 0,
  tags: "",
  planned_time: 52645478,
  setter: 1,
  executor: 1,
  created_at : 7870,
  updated_at : 87809789,
  schedule: [],
  steps: [
    {
      id: 1,
      text : "Step text",
      startTime : 75675,
      endTime: 456345,
      duration: 0
    },
  ],
  totalDuration : 75896,
  solutions : [{
    id: 3,
    comment: "Super comment",
    added_at: 543645,
    owner: 1,
    ownerName : "self"
  }],
  checklist: [{
    id : 1,
    todo: "What to do",
    addTime: 534576,
    finTime: 5645634,
    checked: 0
  }],
  totalChecks: 1,
  doneChecks: 0,
  percentChecks: 0,
  condition_phys: 100,
  condition_emo: 100,
  condition_intel: 100,
  viewMode_calendar : 0,
};


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