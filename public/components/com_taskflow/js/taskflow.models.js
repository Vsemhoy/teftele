
const TaskCardModel =
{
    id: 1,
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


const CardCheckListModel = {
  id : 1,
  todo: "What to do",
  addTime: 534576,
  finTime: 5645634,
  checked: 0
};
const CardSolutionModel = {
  id: 3,
  comment: "Super comment",
  added_at: 543645,
  owner: 1,
  ownerName : "Mark"
}
const CardStepModel = {
  id: 1,
  text : "Step text",
  startTime : 75675,
  endTime: 456345,
  duration: 0
};

const StackTaskModel = {
    id : 0,
    functionName: "demo",
    functionParams : [],
    status : 0,
    attempts : 0
}