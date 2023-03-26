//     let headpooler = document.querySelector('#headpool');
// headpooler.addEventListener('click', (e)=> {
//   let header = document.querySelector('header');
//   if (header.classList.contains('dropped-head')){
//     header.classList.remove('dropped-head');
//   }
//   else {
//     header.classList.add('dropped-head');
//   }
// })

var dataToInsert = [
  {'id': '7245434', 'name' : 'New Task', 'date' : '2023-02-21', 'section' : 'q'},
  {'id': '72454434', 'name' : 'Not New Task', 'date' : '2023-02-21', 'section' : 'e'},
    {'id': '78245434', 'name' : 'AND NES STUFF', 'date' : '2023-02-21', 'section' : 'f'},
    {'id': '72445434', 'name' : 'Do something!', 'date' : '2023-02-21', 'section' : 'p'},
      {'id': '724t45434', 'name' : 'OKAY< GO', 'date' : '2023-02-21', 'section' : 'd'},
        {'id': '72445r434', 'name' : 'Thied f fjasdjfdfj djfkasjdfkjj j jkjdf', 'date' : '2023-02-20', 'section' : 'd'},
        {'id': '7244w5434', 'name' : 'Sunday sweet task', 'date' : '2023-02-15', 'section' : 'e', 'text': 'The super text here i will come to home yesterday and will meet my husband. He is so strong, but today he is ill. I strive to do something.'},
];

const TFTEMPLATE = new TaskFlowTemplates();
const TFMODELS = new TaskFlowModels();

class flowCalendarVisual 
{
  normalizeDateFromId(id){
    let raw_date_arr = id.split('_');
    let day = (raw_date_arr[1]).length == 2 ? raw_date_arr[1] : "0" + raw_date_arr[1];
    let mon = (raw_date_arr[2]).length == 2 ? ++raw_date_arr[2] : "0" + ++raw_date_arr[2];
    let target_date = day + '-' + mon + '-' + raw_date_arr[3]; 
    return target_date;
  }
  getSectionNumberFromElem(elem){
    if (elem.classList.contains('col-que')){ return 1;};
    if (elem.classList.contains('col-exec')){ return 2;};
    if (elem.classList.contains('col-paus')){ return 3;};
    if (elem.classList.contains('col-fin')){ return 4;};
    if (elem.classList.contains('col-drop')){ return 5;};
    return 1;
  }
    reload(){
        this.dragcells = document.querySelectorAll('.dragsection');
        for (let index = 0; index < this.dragcells.length; index++) {
            if (!this.dragcells[index].classList.contains("tf-watch")){
                this.dragcells[index].classList.add("tf-watch");
                let element = this.dragcells[index];
                element.addEventListener('dblclick', (e) => {
                  this.target_date  = this.normalizeDateFromId(element.parentElement.id);
                  this.target_status = this.getSectionNumberFromElem(element);
                  this.targetCell_id = element.id;
                  this.current_status = this.getCurrentStateNumber(element.id);
                    if (e.target.innerHTML == ""){

                      this.updateModalSelectorValues();
                        UIkit.modal("#tf_modal_task_editor").show();
                        this.flushInputs();
                        this.current_id = null;
                        //alert("hello");
                    } else {
                        let blockEvent_di = false;
                        let dragitems = element.querySelectorAll('.dragitem');
                        let moX = e.clientX;
                        let moY = e.clientY;
                      
                        // get position and size of each element and make sure that no one element is clicked
                        for (let i = 0; i < dragitems.length; i++) {
                            var rect = dragitems[i].getBoundingClientRect();

                            // Log the position and size of the DIV element
                            // console.log("Top: " + rect.top);
                            console.log("Right: " + rect.right);
                            // console.log("Bottom: " + rect.bottom);
                            console.log("Left: " + rect.left);
                            // console.log("Width: " + rect.width);
                            // console.log("Height: " + rect.height);
                            if (rect.top < moY && rect.bottom > moY && rect.left < moX && rect.right > moX){ 
                                blockEvent_di = true;
                                break;
                            }
                        }
                        if (blockEvent_di == false){
                            this.current_id = null;
                            // alert("blockEvent false");
                            UIkit.modal("#tf_modal_task_editor").show();
                            this.flushInputs();
                            // element.insertAdjacentHTML('beforeend', TFTEMPLATE.getTaskCardInCalendar());
                            // this.cardReload();
                        } else {
                          //UIkit.modal("#tf_modal_task_editor").hide();
                        }
                    }
   
                });
            }
        }


    }

    cardReload(){
      this.dragcitems = document.querySelectorAll('.dragitem');
      for (let index = 0; index < this.dragcitems.length; index++) {
          if (!this.dragcitems[index].classList.contains("tf-watch")){
              this.dragcitems[index].classList.add("tf-watch");
              let element = this.dragcitems[index];
              element.addEventListener('dblclick', (e) => {
                let idNum = (element.id).replace(/[^0-9]/g, '');
                this.current_id = idNum;
                // load task from taskCollection
                TaskCollection.forEach(taskrow => {
                  console.log(taskrow.id);
                  if (taskrow.id == idNum){
                    //alert(taskrow.name);
                    this.fillEditorInputs(taskrow);
                    UIkit.modal("#tf_modal_task_editor").show();

                    }
                  });

                  e.preventDefault;
                  //UIkit.modal("#tf_modal_task_editor").hide();
              });

              if (element.querySelector('.tf_card_event_minifycard') != null){
                element.querySelector('.tf_card_event_minifycard').addEventListener('click', (e)=>{
                  element.classList.add('tsm-vis-hidden');
                  element.classList.remove('tsm-vis-middle');
                });
              }

              if (element.querySelector('.tf_card_event_minifycard') != null){
                element.querySelector('.tf_card_event_midifycard').addEventListener('click', (e)=>{
                  element.classList.remove('tsm-vis-hidden');
                  element.classList.add('tsm-vis-middle');
                });                
              }

              if (element.querySelector('.tf_card_event_minifycard') != null){
                element.querySelector('.tf_card_event_expandcard').addEventListener('click', (e)=>{
                  element.classList.remove('tsm-vis-hidden');
                  element.classList.remove('tsm-vis-middle');
                });
              }
          }
      }
    }



    checkListReload(){
      this.taskCheckItems = document.querySelectorAll(".tf-t-checklist-item");
      for (let index = 0; index < this.taskCheckItems.length; index++) {
        if (!this.taskCheckItems[index].classList.contains("tf-watch")){
            this.taskCheckItems[index].classList.add("tf-watch");
            this.taskCheckItems[index].querySelector('.tf-event-removecheck').addEventListener('dblclick', (e) => {
                this.taskCheckItems[index].remove();
            });
            this.taskCheckItems[index].querySelector('.tf_t_check_editable').addEventListener('dblclick', (e) => {
              let text = this.taskCheckItems[index].querySelector('.tf_t_check_editable').textContent;
              let height = this.taskCheckItems[index].querySelector('.tf_t_check_editable').style.height;
              var divElement = document.createElement("textarea");
              height += 60;
              divElement.id = "elementos";
              divElement.style.height = height + "px";
              divElement.textContent = text;
              this.taskCheckItems[index].querySelector('.tf_t_check_editable').innerHTML = "";
              this.taskCheckItems[index].querySelector('.tf_t_check_editable').appendChild(divElement);

              let textArea = document.querySelector("#elementos");
              textArea.addEventListener('focusout', (e)=>{
                let textos = textArea.value;
                let parentElement = textArea.parentElement;
                textArea.remove();
                textos = textos.replace(/\n/g, "<br>");
                parentElement.innerHTML = textos;
              })
          });
        }
      }

      
    }

    constructor() {
      // id of task
      this.current_id = null;
      this.current_status = 1;
      this.activeRunner = false;
      this.targetCell = null;
      this.rowCollection = document.querySelector('#rowCollection');
      this.renderStartRows();
      this.addCustomNavButtons();

      this.reload();
        this.cardReload();

        // add templates into TASK CHECKLIST
        this.btnAddCheckItem = document.querySelectorAll(".tf-event-addcheck");
        for (let index = 0; index < this.btnAddCheckItem.length; index++) {
          this.btnAddCheckItem[index].addEventListener('click', (e)=>{
            document.querySelector("#tf_checks_list").insertAdjacentHTML('beforeend', TFTEMPLATE.getTaskListTableCheckListTableRow());
            setTimeout(() => {
              this.checkListReload();
            }, 1000);
          });
      }
      this.sectionMap = this.buildSectionMap();

      // set condition color listeners
      this.cond_phys = document.querySelector("#tf_t_phys_cond");
      this.cond_emo = document.querySelector("#tf_t_emo_cond");
      this.cond_intel = document.querySelector("#tf_t_intel_cond");
      this.cond_color = document.querySelector("#tf_t_cond_color");
      this.cond_phys.addEventListener('mousemove', (e)=>{ this.setConditionColor();}) 
      this.cond_emo.addEventListener('mousemove', (e)=>{ this.setConditionColor();})
      this.cond_intel.addEventListener('mousemove', (e)=>{ this.setConditionColor();})
      this.cond_color.addEventListener('change', (e)=>{ this.setConditionsByColor();})


      // add rows by scroll
      let blockTopScroll = false;
      this.lastInsertedDate = "";
      window.onscroll = (ev)=>{
        this.rowCollection = document.querySelector('#rowCollection');
        var rect = this.rowCollection.getBoundingClientRect();
      //console.log(rect.top, rect.right, rect.bottom, rect.left);
      
        var vscroll = window.pageYOffset;
        let  viewportHeight = window.innerHeight;
        let topOffset = rect.height + this.rowCollection.offsetTop;
      //console.log("offtop is " + topOffset + " < vscroll is " + vscroll + " + viewportHeight is " +  viewportHeight);
      // Scroll bottom
        if (topOffset < vscroll +  viewportHeight + 1){
          this.datetime = this.pastDate;
          for (let i = 0 ; i < 7; i++){
              var additionalDate = new Date();
              additionalDate.setTime(this.datetime.getTime() - ((1 + i) * this.day));
              this.pastDate = additionalDate;
              this.rowCollection.insertAdjacentHTML('beforeend', this.buildRow(additionalDate));
              }
              this.reload();
          }
          
          //console.log(this.rowCollection.offsetTop);
          // scroll top
          if (this.rowCollection.offsetTop > vscroll && !blockTopScroll){
              // console.log("scroll top");
              blockTopScroll = true;
                  setTimeout(() => {
                      this.datetime = this.futDate;
                      for (let i = 0 ; i < 14; i++){
                      var additionalDate = new Date();
                      var msr = document.querySelector("#master-row"); // This is a Top header row
                      additionalDate.setTime(this.datetime.getTime() + ((1 + i) * this.day));
                      this.futDate = additionalDate;
                        // IF APPEARS Duplicated rows, prevent to load FIRST date as LAST INDEX i
                        console.log(additionalDate.getDate() + " CLG_66783");
                        this.rowCollection.insertAdjacentHTML('afterbegin', this.buildRow(additionalDate));
                      }
                      this.rowCollection.prepend(msr); // Transfer top header row
                      blockTopScroll = false;
                      this.reload();
                  }, 500);
        }
      }
      this.addTableResizers();
      this.initModalSelectors();

      // MODAL HANDLE
      let saveBtn = document.querySelector("#tf_btn_savetask");
      saveBtn.addEventListener('click', ()=>{
        this.harvestTaskSave();
      });

      let tsmcounterinbottom = document.querySelector('#tsm_counter');
      setInterval(() => {
        // check if there is not completed tasks and try to complete em (TaskQueue)
        this.taskRunner();
      }, 3000);
      setInterval(() => {
        // change control value in the bottom bar
        if (TaskQueue.length > 0){
          tsmcounterinbottom.classList.remove('tsm-hidden');
          tsmcounterinbottom.querySelector('.tsm-counter-value').innerHTML = TaskQueue.length;
        } else {
          tsmcounterinbottom.classList.add('tsm-hidden');
          tsmcounterinbottom.querySelector('.tsm-counter-value').innerHTML = 0;
        }
      }, 1000);

      window.onload = (event) => {
        console.log("page is fully loaded");
        this.loadTasksIntoBoard(this.pastDate, this.futDate, currentTaskBoard);
      };

      console.log("start drag load");
      // START DRAGGING
      this.sourceCell = null;
      // function allowDrop(ev) {
      //   ev.preventDefault();
      // }
          
      //     // Start dragging
      //     function drag(ev) {
      //       ev.dataTransfer.setData("text", ev.target.id);
      //       sourceCell = ev.target.parentElement;
      //     }
          
      //   function drop(ev) {
      //     ev.preventDefault();
      //     var data = ev.dataTransfer.getData("text");
      //     let element = document.getElementById(data);
      //     if (!ev.target.classList.contains("dragsection")){ 
      //       return false; };
      //       FLOWC.updateTaskState(element, sourceCell, ev.target);
      //       ev.target.appendChild(element);
      //     }

      document.addEventListener("dragover", (event) => {
       if (event.target.classList.contains('dragsection'))
       {
         event.preventDefault();
         //console.log("predef");
       }
      });
       document.addEventListener("dragstart", (event)=>{
        const elementBeingDragged = event.target;
        //if ()
        if (elementBeingDragged.classList.contains('dragitem'))
        {
          console.log(elementBeingDragged.id);
          event.dataTransfer.setData("text", event.target.id);
          this.sourceCell = event.target.parentElement;
        }
       });   

       document.addEventListener("drop", (event) => {
        if (event.target.classList.contains('dragsection'))
        {
          event.preventDefault();
          let data = event.dataTransfer.getData("text");
          let element = document.getElementById(data);
          if (!event.target.classList.contains("dragsection")){ return false; };
            this.updateTaskState(element, this.sourceCell, event.target);
            event.target.appendChild(element);
          }
       });

    }


    //
    //ondrop='drop(event)' ondragover='allowDrop(event)'
// ondrop='drop(event)' ondragover='allowDrop(event)'
// ondrop='drop(event)' ondragover='allowDrop(event)'
// ondrop='drop(event)' ondragover='allowDrop(event)'
// ondrop='drop(event)' ondragover='allowDrop(event)'
    //
    //
    //
    //

    renderStartRows(date = null) {
      this.day = (24 * 60 * 60 * 1000);
      this.pastDate = null;
      this.futDate = null;
          this.datetime = new Date();
          
          if (date != null){
            this.datetime = date;
          }
          this.datetime.setTime(this.datetime.getTime() + (3 * this.day));
          this.futDate = this.datetime;
          this.pastDate = this.datetime;
      
      for (let i = 0 ; i < 30; i++){
        var additionalDate = new Date();
          additionalDate.setTime(this.datetime.getTime() - (i * this.day));
          this.pastDate = additionalDate;
        this.rowCollection.insertAdjacentHTML('beforeend', this.buildRow(additionalDate));
      }
    }

    addCustomNavButtons(){
        let target = document.querySelector("#u-custom-nav-component-buttons");
        if (target != undefined){
            
            let today = "<a href='#row-current-date'>NW</a>";
            target.insertAdjacentHTML('afterbegin', today);
        }
    }

    setConditionColor(){
      let r = this.cond_phys.value;
      let g = this.cond_emo.value;
      let b = this.cond_intel.value;

      let color = "#" + this.decimalToHex(r) + this.decimalToHex(g) + this.decimalToHex(b);
      this.cond_color.value = color;
      // parseInt(hexString, 16); - backward
    }

    setConditionsByColor(){
      let c = this.cond_color.value;
      let r = c.substring(1, 3);
      let g = c.substring(3, 5);
      let b = c.substring(5, 7);
      this.cond_phys.value = parseInt(r, 16);
      this.cond_emo.value = parseInt(g, 16);
      this.cond_intel.value = parseInt(b, 16);
    }

    // service function
    decimalToHex(d, padding) {
      var hex = Number(d).toString(16);
      padding = typeof (padding) === "undefined" || padding === null ? padding = 2 : padding;
  
      while (hex.length < padding) {
          hex = "0" + hex;
      }
  
      return hex;
  }

  getRandomInt() {
    let max = 32000000000;
    return Math.floor(Math.random() * max);
  }

  addTableResizers(){
    let actuators = document.querySelectorAll('.tf-head-act');
    for (let i = 0; i < actuators.length; i++)
    {
      actuators[i].addEventListener('click', () => {
        
        let cls = actuators[i].getAttribute('tgc');
        this.rowCollection.classList.remove('active-que');
        this.rowCollection.classList.remove('active-exec');
        this.rowCollection.classList.remove('active-fin');
        this.rowCollection.classList.remove('active-paus');
        this.rowCollection.classList.remove('active-drop');
        this.rowCollection.classList.add(cls);
      })
    }
  }


  buildRow(date, que = "", exec = "", paus = "", fin = "", drop = "")
  {
    let day = (24 * 60 * 60 * 1000);
  //   console.log(date);
    if (date.getFullYear() < 2023){return "";};
  let formattedDate = date.getDate();
  let formattedMonth = date.toLocaleString('default', { month: 'long' });
    let currentDate = "";
    let currentDateId = "";
      let weekend = "";
    if (date.getDay() == 6 || date.getDay() == 0){
      weekend = " row-weekend";
    } else {
      weekend = " row-" + date.getDay();
    }
    
    if (formattedDate == new Date().getDate() &&
       date.getMonth() == new Date().getMonth()
       && date.getYear() == new Date().getYear()
       ){ currentDate = " row-today";
      currentDateId = "id='row-current-date'";
      }
    
    let newMonthRow = "";
    if (formattedDate == 1){
      date.setTime(date.getTime() - (1 * day));
      newMonthRow = "<div class='col-row col-row-delimeter uk-padding-small'>" + date.toLocaleString('default', { month: 'long'}) + " - " + date.getFullYear() + "</div>";
    }
    
  
    let id = "R_" + formattedDate + "_" + date.getMonth() + "_" + date.getFullYear();
    let result = "<div class='col-row" + currentDate + weekend + "' id='" + id +"'>";
    result += "<div " + currentDateId + " class='col-item col-date'><div class='uk-text-medium content-mid-reverse'><span class='hide-m'>  " + formattedMonth + "</span> <span class='uk-text-bold'>" + formattedDate + "</span></div></div>";
    result += "<div class='col-item col-que dragsection'  condition='1' id='cell_" + this.getRandomInt() + "'  >" + que + "</div>";
    result += "<div class='col-item col-exec dragsection' condition='2' id='cell_" + this.getRandomInt() + "'  >" + exec + "</div>";
    result += "<div class='col-item col-paus dragsection' condition='3' id='cell_" + this.getRandomInt() + "'  >" + paus + "</div>";
    result += "<div class='col-item col-fin dragsection'  condition='4' id='cell_" + this.getRandomInt() + "'  >" + fin + "</div>";
    result += "<div class='col-item col-drop dragsection' condition='5' id='cell_" + this.getRandomInt() + "'  >" + drop + "</div>";
    result += "";
    result += "</div>" + newMonthRow;
    return result;
  }


  getSessionCount(steps){
    if (steps.length == 0){ return ""};
    let counter = 0;
    steps.forEach((stp) => {
      console.log(stp.event_code + " evc");
      if (stp.event_code == 2){
        counter++;
      }
    });
    return counter;
  }

  

  buildSectionMap(){
  let result = [];
  let divs  = document.querySelector('#master-row').querySelectorAll("div");
  for (let i = 0; i < divs.length; i++){
    let att = divs[i].getAttribute('data-section');
    if (att != undefined && att != null){
    result.push(att);
    }
  }
  return result;
}

getCurrentStateNumber(cell_id)
{
  let element = document.querySelector('#' + cell_id);
  if (element != null){
    if (element.classList.contains("col-que")){
      return 1;
    } else if (element.classList.contains("col-exec")){
      return 2;
    } else if (element.classList.contains("col-paus")){
      return 3;
    } else if (element.classList.contains("col-fin")){
      return 4;
    } else if (element.classList.contains("col-drop")){
      return 5;
    } else {
      return 1;
    }
  }
  return 1;
}

getStateClass(number)
{
  let classe = "";
    if (number == 1){
      classe = "col-que" ; 
    } else if (number == 2){
      classe = "col-exec"; 
    } else if (number == 3){
      classe = "col-paus"; 
    } else if (number == 4){
      classe = "col-fin" ; 
    } else if (number == 5){
      classe = "col-drop"; 
    }
    return classe;
  }


getCardVisualState(raw_id){
  let element = document.querySelector('#' + raw_id);
  if (element != null){
    if (element.classList.contains("tsm-vis-hidden")){
      return 0;
    } else if (element.classList.contains("tsm-vis-middle")){
      return 1;
    } else {
      return 2;
    }
  }
  return 0;
}

// DROP STATE TASKE EVENTS

updateTaskState(task, sourceCell, targetCell){
  console.log("sourceCell = " + sourceCell.id);
 console.log(targetCell.id);
 // get conditions:
 let firstCondition = +sourceCell.getAttribute('condition');
 let secondCondition = +targetCell.getAttribute('condition');
 console.log(firstCondition);
 let num_id = task.id.replace("item_", "");
 console.log(num_id);

 // get task object
 let index = -1;
 for (let i = 0; i < TaskCollection.length; i++) {
   const element = TaskCollection[i];
   if (element.id == num_id){
     index = i;
     //alert(i);
     break;
   }
 }
 if (index == -1){
   console.log("can't find target task in collection");
   return false;
 }
 console.log(TaskCollection[index].steps);
 // get row date and current timestamp
 // we're set duration only if task moved from "2" status to other
 let count = TaskCollection[index].steps.length;
 let now = Date.now();
 let dat = this.normalizeDateFromId(targetCell.parentElement.id)
 let stepnow = TFMODELS.getCSM(count, secondCondition, dat, now);
 console.log(firstCondition, secondCondition);
 if (count > 0 && secondCondition != 2 && firstCondition == 2)
 {
  stepnow.duration = now  - TaskCollection[index].steps[TaskCollection[index].steps.length - 1].event_time;
  if (TaskCollection[index].date_start_real == null){
    // real start date can set once
    TaskCollection[index].date_start_real = dat;
  }
 }
 if (count > 0 && secondCondition == 4 && firstCondition != 4){
  TaskCollection[index].date_finish_real = dat;
 }
 TaskCollection[index].steps.push(stepnow);
 if (count > 0 && secondCondition != 2 && firstCondition == 2)
 {
  // count total duration
  let todur = 0;
  TaskCollection[index].steps.forEach((stp)=>{
    todur += stp.duration;
  });
  // get visual state
  TaskCollection[index].duration_real = todur;
  
}
  TaskCollection[index].date_set = dat;
  TaskCollection[index].status = secondCondition;
  TaskCollection[index].visual_state = this.getCardVisualState(task.id);
  
  // push it to task STACK
  let qts = TFMODELS.getQTM('update');
  qts.object = TaskCollection[index];
  qts.params = {
    'temp_id' : num_id, 
    'target_cell_id' : targetCell.id
  }
  let replaced = false;
  // it STACK already has a task with this ID, rewrite em
  for (let i = 0; i < TaskQueue.length; i++) {
    if (TaskQueue[i].object.id == num_id){
      qts.object = TaskCollection[index];
      replaced = true;
      break;
    } 
  }
  if (replaced == false){
    TaskQueue.push(qts);
  }
  console.log(TaskCollection[index]);
}


// MODAL WWINDOW TASK EDITOR //


  /**
   * Create a new object task
   * Harvest data from Task modal and return it to queue
   */
  harvestTaskSave(){
    let temp_id = null;
    let targetCell = null;
    let t_duration = 0;
    let t_duration_p = 0;
    let tmp = this.harvestTasModalData();
    targetCell = document.querySelector("#" + this.targetCell_id);
    if (tmp.task_name.trim() == ""){
      alert('The name input should not be empty! Fill em now!');
      return;
    }
    if (this.current_id == null){
      temp_id = "temp_card_" + this.getRandomInt();
      targetCell.insertAdjacentHTML("beforeend", TFTEMPLATE.getTaskCardTempBlock(temp_id));
    }
    let qts = TFMODELS.getQTM('create');
    if (this.current_id != null){
      qts.function = 'update';
      for (let i = 0; i < TaskCollection.length; i++) {
        if (TaskCollection[i].id == this.current_id){
          qts.object = TaskCollection[i];
          t_duration = TaskCollection[i].duration_real;
          t_duration_p = TaskCollection[i].duration_planned;
          break;
        } 
      }
      temp_id = this.current_id;
      document.querySelector("#item_" + temp_id).classList.add("tf-temp-updated-card");
      document.querySelector("#item_" + temp_id).setAttribute('draggable', false);
    } else {
      qts.object = TFMODELS.getTCM(this.target_date, this.target_status);
    }
    qts.params = {
      'temp_id' : temp_id, 
      'target_cell_id' : targetCell.id
    }
    if (this.current_id != null){
      qts.object.visual_state = this.getCardVisualState("item_" + temp_id);
    }
    qts.object.id                 = this.current_id        ;
    qts.object.name               = tmp.task_name          ;
    qts.object.description        = tmp.task_description   ;
    qts.object.result             = tmp.task_result        ;
    qts.object.status             = tmp.task_status        ;
    qts.object.board              = tmp.task_board         ;
    qts.object.group              = tmp.task_group         ;
    qts.object.type               = tmp.task_type          ;
    qts.object.project            = tmp.task_project      ;
    qts.object.tags               = tmp.task_tags          ;
    qts.object.days               = tmp.task_days          ;
    qts.object.hours              = tmp.task_hours         ;
    qts.object.minutes            = tmp.task_minutes       ;
    qts.object.duration_planned   = tmp.task_duration_planned;
    qts.object.duration_real      = t_duration;
    qts.object.setter             = tmp.task_setter        ;
    qts.object.executor           = tmp.task_executor      ;
    qts.object.condition_phys     = tmp.task_condition_phys  ;
    qts.object.condition_emo      = tmp.task_condition_emo   ;
    qts.object.condition_intel    = tmp.task_condition_intel ;
    // qts.object.steplist      = task_steplist      ;
    // qts.object.solution_list = task_solution_list ;
    // qts.object.checklist     = task_checklist     ;
    TaskQueue.push(qts);
    console.log(qts);
    UIkit.modal("#tf_modal_task_editor").hide();
  }


  /**
   * 
   * @param {id} integer 
   * @returns std object with data from Modal fields
   */
  harvestTasModalData(id = null){
    let obj = {
      'task_id'                : id,
      'task_name'              : this.task_name.value         ,
      'task_description'       : this.task_description.value  ,
      'task_result'            : this.task_result.value       ,
      'task_status'            : this.task_status.value       ,
      'task_board'             : this.task_board.value        ,
      'task_group'             : this.task_group.value        ,
      'task_type'              : this.task_type.value         ,
      'task_project'           : this.task_project.value     ,
      'task_tags'              : this.task_tags.value         ,
      'task_duration_planned'  : this.task_duration_planned.value,
      'task_setter'            : this.task_setter.value       ,
      'task_executor'          : this.task_executor.value     ,
      'task_steplist'          : this.task_steplist.value     ,
      'task_solution_list'     : this.task_solution_list.value,
      'task_checklist'         : this.task_checklist.value    ,
      'task_condition_phys'    : this.task_phys_condition.value,
      'task_condition_emo'     : this.task_emo_condition.value,
      'task_condition_intel'   : this.task_intel_condition.value,
      'task_days'              : this.task_days.value         ,
      'task_hours'             : this.task_hours.value        ,
      'task_minutes'           : this.task_minutes.value      ,
    }
    let days    = this.task_days.value     ;
    let hours   = this.task_hours.value    ;
    let minutes = this.task_minutes.value  ;
    obj.task_duration_planned = (days * 24 * 60 * 60 * 1000) + (hours * 60 * 60 * 1000) + (minutes * 60 * 1000);
    return obj;
  }
  
  initModalSelectors(){  
    this.task_name              = document.querySelector("#tf_input_name");
    this.task_description       = document.querySelector("#tf_input_description");
    this.task_result            = document.querySelector("#tf_input_result");
    this.task_status            = document.querySelector("#tf_input_status");
    this.task_board             = document.querySelector("#tf_input_board");
    this.task_group             = document.querySelector("#tf_input_group");
    this.task_type              = document.querySelector("#tf_input_type");
    this.task_project           = document.querySelector("#tf_input_project");
    this.task_tags              = document.querySelector("#tf_input_tags");
    this.task_days              = document.querySelector("#tf_input_days");
    this.task_hours             = document.querySelector("#tf_input_hours");
    this.task_minutes           = document.querySelector("#tf_input_minutes");
    this.task_duration_planned  = document.querySelector("#tf_input_duration_p");
    this.task_setter            = document.querySelector("#tf_input_setter");
    this.task_executor          = document.querySelector("#tf_input_executor");
    this.task_steplist          = document.querySelector("#tf_t_steplist");
    this.task_solution_list     = document.querySelector("#tf_t_solution_list");
    this.task_checklist         = document.querySelector("#tf_checks_list");
    this.task_phys_condition    = document.querySelector("#tf_t_phys_cond");
    this.task_emo_condition     = document.querySelector("#tf_t_emo_cond");
    this.task_intel_condition   = document.querySelector("#tf_t_intel_cond");
  }


  // updateModalSelectorValues(){
  //   this.ms_task_name               = document.querySelector("#tf_input_name").value;
  //   this.ms_task_description        = document.querySelector("#tf_input_description").value;
  //   this.ms_task_result             = document.querySelector("#tf_input_result").value;
  //   this.ms_task_status             = document.querySelector("#tf_input_status").value;
  //   this.ms_task_board              = document.querySelector("#tf_input_board").value;
  //   this.ms_task_group              = document.querySelector("#tf_input_group").value;
  //   this.ms_task_type               = document.querySelector("#tf_input_type").value;
  //   this.ms_task_project            = document.querySelector("#tf_input_project").value;
  //   this.ms_task_tags               = document.querySelector("#tf_input_tags").value;
  //   this.ms_task_days               = document.querySelector("#tf_input_days").value;
  //   this.ms_task_hours              = document.querySelector("#tf_input_hours").value;
  //   this.ms_task_minutes            = document.querySelector("#tf_input_minutes").value;
  //   this.ms_task_duration_planned   = document.querySelector("#tf_input_duration_p").value;
  //   this.ms_task_setter             = document.querySelector("#tf_input_setter").value;
  //   this.ms_task_executor           = document.querySelector("#tf_input_executor").value;

  //   this.ms_task_duration_planned = 0;
  //   // this.ms_task_steplist    = document.querySelector("#tf_t_steplist");
  //   // this.ms_task_solution_list = document.querySelector("#tf_t_solution_list").value;
  //   // this.ms_task_checklist  = document.querySelector("#tf_checks_list").value;
  // }

  flushInputs(){
    this.task_name.value = "";
    this.task_description.value = "";
    this.task_result.value = "";
    this.task_status.value = this.current_status;

    this.task_duration_planned.value = 0;
    this.task_executor.value = currentUser;
    this.task_setter.value = currentUser;
    this.task_steplist.innerHTML = "";
    this.task_solution_list.innerHTML = "";
    this.task_checklist.innerHTML = "";
  }

  fillEditorInputs(obj){
    console.log("filleditorinputs", obj);
    this.task_name.value        = obj.name;
    this.task_description.value = obj.description;
    this.task_result.value      = obj.result;
    this.task_status.value      = obj.status;
    this.task_board.value       = obj.board;
    this.task_group.value       = obj.group;
    this.task_type.value        = obj.type;
    this.task_project.value    = obj.project;
    this.task_tags.value        = obj.tags;
    this.task_executor.value    = obj.executor;
    this.task_setter.value      = obj.setter;
    this.task_steplist.innerHTML = "";
    this.task_solution_list.innerHTML = "";
    this.task_checklist.innerHTML = "";
    this.task_duration_planned.value = obj.duration_planned;
    let m = 0;
    let h = 0;
    let d = 0;
    if (obj.duration_planned > 0){
      let oper = obj.duration_planned / 1000;
      m = Math.floor(oper / 60);
      if (m > 60){
        h = Math.floor(m / 60);
        m = (m % 60);
      }
      if (h > 24){
        d = (h / 24).floor();
        h = (h % 24);
      }
    }
    this.task_days.value        = d;
    this.task_hours.value       = h;
    this.task_minutes.value     = m;
  }

  /* QUEUE HANDLERS */
  timer = ms => new Promise(res => setTimeout(res, ms));
  async taskRunner()
  {
    if (TaskQueue.length > 0){
      this.activeRunner = true;
      for (let i = 0; i < TaskQueue.length; i++){
        console.log("len " + TaskQueue.length);
        let t = TaskQueue[i];
        //console.log(t);
        switch (t.function) {
          case 'create':
            this.t_CreateTask(t);
            await this.timer(1000);
            break;

            case 'update':
              // let result = this.t_CreateTask(t);
              this.t_UpdateTask(t);
              await this.timer(1000);
              break; 
        
          default:
            break;
        }
      }

    } else {
      this.activeRunner = false;

    }
  }


  // TASK HANDLERS //

  /**
   * Inserts a new task object into database
   * @param {TaskCardModel} task object
   */
  async t_CreateTask(task){
    let code = 300;
    let anchorList = [];

    let response = await fetch(path + code, {
    method: 'POST',
    credentials: 'same-origin',
    headers: {
        "Content-Type": "application/json;charset=utf-8",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": token
    },
    body: JSON.stringify(task.object)
    });
    response.json().then(data => {
          // new task  
          console.log(data.message);
          if (data.message == "CSRF token mismatch."){
            // placed in main template as script section
            authRelogger();
          }
          if (data.code == 0 && data.item_id > 0){
            if (document.querySelector("#" + task.params.temp_id) != null){

              document.querySelector("#" + task.params.temp_id).remove();

              // temp data
              let id = Math.floor(Math.random() * 9999999);
              task.object.id = id;
              let element = document.querySelector("#" + task.params.target_cell_id);
              element.insertAdjacentHTML('beforeend', 
              TFTEMPLATE.getTaskCardInCalendar(id, 0, task.object.name, task.object.description,
                 task.object.result));
              this.cardReload();
              // Insert object into global task collection
              TaskCollection.push(task.object);
              for (let i = 0; i < TaskQueue.length; i++) {
                let element = TaskQueue[i];
                if (element.id == task.id){
                  TaskQueue.splice(i, 1);
                  break;
                }
              }
            }
          } else {
            console.log(data.message);
          }
      });
  }

  /**
   * Inserts a new task object into database
   * @param {TaskCardModel} task object
   */
  async t_UpdateTask(task){
    let code = 400;
    let anchorList = [];

    let response = await fetch(path + code, {
    method: 'POST',
    credentials: 'same-origin',
    headers: {
        "Content-Type": "application/json;charset=utf-8",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": token
    },
    body: JSON.stringify(task.object)
    });
    response.json().then(data => {
          // new task  
          console.log(data.message);
          if (data.message == "CSRF token mismatch."){
            // placed in main template as script section
            authRelogger();
          }
          if (data.code == 0){
            if (document.querySelector("#item_" + task.params.temp_id) != null){
              document.querySelector("#item_" + task.params.temp_id).classList.remove("tf-temp-updated-card");
              document.querySelector("#item_" + task.params.temp_id).setAttribute('draggable', true);
              document.querySelector("#item_" + task.params.temp_id).remove();
              let element = document.querySelector("#" + task.params.target_cell_id);

              let sesscount = this.getSessionCount(task.object.steps);
              element.insertAdjacentHTML('beforeend', 
              TFTEMPLATE.getTaskCardInCalendar(task.object.id, task.object.visual_state, 
                task.object.name, task.object.description, task.object.result, 
                task.object.duration_real, sesscount));
              this.cardReload();
              // Insert object into global task collection
              //TaskCollection.push(task.object);
              for (let index = 0; index < TaskCollection.length; index++) {
                if (TaskCollection[index].id == task.object.id){
                  TaskCollection[index] = task.object;
                  break;
                }
              }
              for (let i = 0; i < TaskQueue.length; i++) {
                let element = TaskQueue[i];
                if (element.params.temp_id == task.params.temp_id){
                  TaskQueue.splice(i, 1);
                  break;
                }
              }
            }
          } else {
            console.log(data.message);
          }
      });
  }


  async loadTasksIntoBoard(pastDate, futDate, boards)
  {
      let code = 200;
      let obj = {
        'startdate' : pastDate,
        'findate'   : futDate,
        'boards'    : boards
      }

      let response = await fetch(path + code, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
          "Content-Type": "application/json;charset=utf-8",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": token
      },
      body: JSON.stringify(obj)
      });
      response.json().then(data => {
            // new task  
            console.log(data.message);
            if (data.message == "CSRF token mismatch."){
              // placed in main template as script section
              authRelogger();
            }
            if (data.code == 0){
              console.log(data.objects);
              if (data.objects.length > 0){
                data.objects.forEach((taskobj) =>{
                  let date = new Date(taskobj.date_set);
                  let formattedDate = date.getDate();
                  let row_id = "R_" + formattedDate + "_" + date.getMonth() + "_" + date.getFullYear();
                  let set_row = document.querySelector("#" + row_id);
                  if (set_row != null){
                    let set_cell = set_row.querySelectorAll("." + this.getStateClass(taskobj.status));
                    if (set_cell.length > 0){
                      let sesscount = this.getSessionCount(JSON.parse(taskobj.steps));
                      set_cell[0].insertAdjacentHTML("beforeend", 
                      TFTEMPLATE.getTaskCardInCalendar(taskobj.id, taskobj.visual_state, taskobj.name,
                         taskobj.description, taskobj.result, taskobj.duration_real, sesscount));

                      let newobject = TFMODELS.getTCM(taskobj.date_set, taskobj.status);
                      newobject.id                 = taskobj.id        ;
                      newobject.name               = taskobj.name          ;
                      newobject.description        = taskobj.description   ;
                      newobject.result             = taskobj.result        ;
                      newobject.status             = taskobj.status        ;
                      newobject.board              = taskobj.board_id        ;
                      newobject.group              = taskobj.group_id         ;
                      newobject.type               = taskobj.type_id          ;
                      newobject.project            = taskobj.project_id      ;
                      newobject.tags               = taskobj.tags          ;
                      // newobject.days               = taskobj.days          ;
                      // newobject.hours              = taskobj.hours         ;
                      // newobject.minutes            = taskobj.minutes       ;
                      newobject.duration_planned   = taskobj.duration_planned;
                      newobject.duration_real      = taskobj.duration_real;
                      newobject.setter             = taskobj.setter        ;
                      newobject.executor           = taskobj.executor      ;
                      newobject.condition_phys     = taskobj.condition_phys  ;
                      newobject.condition_emo      = taskobj.condition_emo   ;
                      newobject.condition_intel    = taskobj.condition_intel ;
                      newobject.steps              = JSON.parse(taskobj.steps)   ;
                      // qts.object.solution_list = task_solution_list ;
                      // qts.object.checklist     = task_checklist     ;
                      // console.log(taskobj.steps);
                      TaskCollection.push(newobject);
                    }
                    //TFTEMPLATE.
                  }
                  
                  console.log(row_id);
                  
                  
                  
                });
                this.cardReload();
              }
              // if (document.querySelector("#item_" + task.params.temp_id) != null){
                // let formattedMonth = date.toLocaleString('default', { month: 'long' });
              //   document.querySelector("#item_" + task.params.temp_id).classList.remove("tf-temp-updated-card");
              //   document.querySelector("#item_" + task.params.temp_id).setAttribute('draggable', true);
              //   document.querySelector("#item_" + task.params.temp_id).remove();
              //   let element = document.querySelector("#" + task.params.target_cell_id);
              //   console.log(task.object.visual_state);
              //   element.insertAdjacentHTML('beforeend', 
              //   TFTEMPLATE.getTaskCardInCalendar(task.object.id, task.object.visual_state, task.object.name, task.object.description, task.object.result));
              //   this.cardReload();
              //   // Insert object into global task collection
              //   TaskCollection.push(task.object);
              //   for (let index = 0; index < TaskCollection.length; index++) {
              //     if (TaskCollection[index].id = task.object.id){
              //       TaskCollection[index] = task.object;
              //       break;
              //     }
              //   }
              //   for (let i = 0; i < TaskQueue.length; i++) {
              //     let element = TaskQueue[i];
              //     if (element.id == task.id){
              //       TaskQueue.splice(i, 1);
              //       break;
              //     }
              //   }
              // }
            } else {
              console.log(data.message);
            }
        });
  }


}

const FLOWCV = new flowCalendarVisual();


      
      
      
      











function taskTemplate(id, name, text = ""){
 let result = `<div class='dragitem uk-card uk-card-default dragcard' draggable='true' ondragstart='drag(event)' id='${id}'>
<div class='uk-heading'>M</div>
 <div class='uk-text hide-m'>
 <div>${name}</div>
 <div>${text}</div>
 </div>
</div>
</div>`;
  return result;
}



//console.log(sectionMap);



//console.log(sectionMap);



FLOWCV.reload();


function SetEventsToChart(events, map)
{
  for (let i = 0; i < events.length; i++){
    let evt  = events[i];
    let date = new Date(evt.date);
    //console.log(date)
    let d = date.getDate();
    let m = date.getMonth();
    let y = date.getYear();
    let idn = "R_" + d + "_" + m + "_" + y;
    //console.log(idn);
    
    let target = document.querySelector("#" + idn);
    if (target != null){
      let index = map.indexOf(evt.section);
      //console.log("index is  " + index);
      let columns = target.querySelectorAll('.col-item');
      if (columns[index] != null){
        columns[index].insertAdjacentHTML('beforeend', taskTemplate(evt.id, evt.name, evt.text));
      }
    }
  }
}

SetEventsToChart(dataToInsert, FLOWCV.sectionMap);




class TaskCardHandlers{


}

const TCH = new TaskCardHandlers();


var x = 0;
var y = 0;
var startX = 0;
var startY = 0;
  // x = e.clientX; 
  // y = e.clientY; 

let comside = document.querySelector("#comside");
let cmsactuator = document.querySelector("#cmsactuator");



// cmsactuator.addEventListener("click", (e)=> {
//   comside.classList.toggle('cms-hidden');
//     console.log(" - I toggle you - ");
// });

// cmsactuator.addEventListener("mousedown", (e)=> {
//   startX = e.clientX;
//   //comside.classList.add('cms-hidden');
//   //comside.style.right = -200 + "px";
// });
// comside.addEventListener("mousedown", (e)=> {
//   startX = e.clientX;
// });

// cmsactuator.addEventListener("mouseup", (e)=> {
//   console.log(startX);
//   console.log(e.clientX);
  
//   if (startX =  e.clientX + 10){
//     comside.classList.remove('cms-hidden');
//   }
//     if (startX < e.clientX + 10){
//     comside.classList.add('cms-hidden');
//   }
// });

// comside.addEventListener("mouseup", (e)=> {
  
//   // if (startX = e.clientX ){
//   //   comside.classList.remove('cms-hidden');
//   // }
//   //   if (startX < (e.clientX + 100)){
//   // console.log(startX + " - start");
//   // console.log(e.clientX);
//   //  comside.classList.add('cms-hidden');
//   // };
//   //comside.style.removeProperty('right');
// });