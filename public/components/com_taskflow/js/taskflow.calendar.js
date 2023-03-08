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

class flowCalendarVisual 
{
    reload(){
        this.dragcells = document.querySelectorAll('.dragsection');
        for (let index = 0; index < this.dragcells.length; index++) {
            if (!this.dragcells[index].classList.contains("tf-watch")){
                this.dragcells[index].classList.add("tf-watch");
                let element = this.dragcells[index];
                element.addEventListener('dblclick', (e) => {
                  this.targetCell = element.id;
                    if (e.target.innerHTML == ""){
                      element.insertAdjacentHTML('beforeend', TFTEMPLATE.getTaskCardInCalendar());
                      this.cardReload();
                        UIkit.modal("#tf_modal_task_editor").show();
                        //alert("hello");
                    } else {
                        let blockEvent_di = false;
                        let dragitems = element.querySelectorAll('.dragitem');
                        let moX = e.clientX;
                        let moY = e.clientY;
                        console.log(moX);
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
                            //alert("hello");
                            UIkit.modal("#tf_modal_task_editor").show();
                            element.insertAdjacentHTML('beforeend', TFTEMPLATE.getTaskCardInCalendar());
                            this.cardReload();
                        } else {
                          UIkit.modal("#tf_modal_task_editor").hide();
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
                  //UIkit.modal("#tf_modal_task_editor").show();
                  e.preventDefault;
                  UIkit.modal("#tf_modal_task_editor").hide();
                  alert("Hello");
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
      
      window.onscroll = (ev)=>{
        this.rowCollection = document.querySelector('#rowCollection');
        var rect = this.rowCollection.getBoundingClientRect();
      //console.log(rect.top, rect.right, rect.bottom, rect.left);
      
        var vscroll = window.pageYOffset;
        let  viewportHeight = window.innerHeight;
        let topOffset = rect.height + this.rowCollection.offsetTop;
      //console.log("offtop is " + topOffset + " < vscroll is " + vscroll + " + viewportHeight is " +  viewportHeight);
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
          if (this.rowCollection.offsetTop > vscroll && !blockTopScroll){
              // console.log("scroll top");
              blockTopScroll = true;
                  setTimeout(() => {
                      this.datetime = this.futDate;
                      for (let i = 0 ; i < 14; i++){
                      var additionalDate = new Date();
                      var msr = document.querySelector("#master-row");
                      additionalDate.setTime(this.datetime.getTime() + ((1 + i) * this.day));
                      this.futDate = additionalDate;
                      this.rowCollection.insertAdjacentHTML('afterbegin', this.buildRow(additionalDate));
                      }
                      this.rowCollection.prepend(msr);
                      blockTopScroll = false;
                      this.reload();
                  }, 500);
        }
      }
      this.addTableResizers();
    }

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
    
  
    let id = "R_" + formattedDate + "_" + date.getMonth() + "_" + date.getYear();
    let result = "<div class='col-row" + currentDate + weekend + "' id='" + id +"'>";
    result += "<div " + currentDateId + " class='col-item col-date'><div class='uk-text-medium content-mid-reverse'><span class='hide-m'>  " + formattedMonth + "</span> <span class='uk-text-bold'>" + formattedDate + "</span></div></div>";
    result += "<div class='col-item col-que dragsection'    id='cell_" + this.getRandomInt() + "' ondrop='drop(event)' ondragover='allowDrop(event)' >" + que + "</div>";
      result += "<div class='col-item col-exec dragsection' id='cell_" + this.getRandomInt() + "' ondrop='drop(event)' ondragover='allowDrop(event)' >" + exec + "</div>";
      result += "<div class='col-item col-paus dragsection' id='cell_" + this.getRandomInt() + "' ondrop='drop(event)' ondragover='allowDrop(event)' >" + paus + "</div>";
      result += "<div class='col-item col-fin dragsection'  id='cell_" + this.getRandomInt() + "' ondrop='drop(event)' ondragover='allowDrop(event)' >" + fin + "</div>";
      result += "<div class='col-item col-drop dragsection' id='cell_" + this.getRandomInt() + "' ondrop='drop(event)' ondragover='allowDrop(event)' >" + drop + "</div>";
    result += "";
    result += "</div>" + newMonthRow;
    return result;
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

}

const FLOWCV = new flowCalendarVisual();














 function allowDrop(ev) {
      ev.preventDefault();
    }
    
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
    }
    
    function drop(ev) {
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
    //  console.log(data);
    //  console.log("HELLO");
      if (!ev.target.classList.contains("dragsection")){ 
        //console.log("STOP!");
        return false; };
      ev.target.appendChild(document.getElementById(data));
    }



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

  constructor(){
    this.task_id = null;
    let saveBtn = document.querySelector("#tf_btn_savetask");
    saveBtn.addEventListener('click', ()=>{
      this.harvestTaskSave();
    });
  }

  harvestTaskSave(){
    if (this.task_id == null){
      let temp_id = "temp_card_" + FLOWCV.getRandomInt();
      let targetCell = document.querySelector("#" + FLOWCV.targetCell);
      targetCell.insertAdjacentHTML("beforeend", TFTEMPLATE.getTaskCardTempBlock(temp_id));
    }

    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;
    this.task_= document.querySelector("#tf_input_").value;

  }

};

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