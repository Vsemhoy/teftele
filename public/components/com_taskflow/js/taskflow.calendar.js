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

class flowCalendarVisual 
{
    reload(){
        this.dragcells = document.querySelectorAll('.dragsection');
        for (let index = 0; index < this.dragcells.length; index++) {
            if (!this.dragcells[index].classList.contains("tf-watch")){
                this.dragcells[index].classList.add("tf-watch");
                this.dragcells[index].addEventListener('dblclick', (e) => {
                    if (e.target.innerHTML == ""){
                        UIkit.modal("#tf_modal_task_editor").show();
                        //alert("hello");
                    } else {
                        let blockEvent_di = false;
                        let dragitems = this.dragcells[index].querySelectorAll('.dragitem');
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
                            }
                        }
                        if (blockEvent_di == false){
                            //alert("hello");
                            UIkit.modal("#tf_modal_task_editor").show();
                        }
                    }
   
                });
            }
        }

    }

    constructor() {
        this.addCustomNavButtons();
        this.reload();
    }

    addCustomNavButtons(){
        let target = document.querySelector("#u-custom-nav-component-buttons");
        if (target != undefined){
            
            let today = "<a href='#row-current-date'>NW</a>";
            target.insertAdjacentHTML('afterbegin', today);
        }
    }
}

const FLOWCV = new flowCalendarVisual();

let rowCollection = document.querySelector('#rowCollection');

let row = rowCollection.innerHTML;



let actuators = document.querySelectorAll('.head-act');
for (let i = 0; i < actuators.length; i++)
  {
    actuators[i].addEventListener('click', () => {
      
      let cls = actuators[i].getAttribute('tgc');
      rowCollection.classList.remove('active-que');
      rowCollection.classList.remove('active-exec');
      rowCollection.classList.remove('active-fin');
      rowCollection.classList.remove('active-paus');
      rowCollection.classList.remove('active-drop');
      rowCollection.classList.add(cls);
    })
  }

function getRandomInt() {
  let max = 32000000000;
  return Math.floor(Math.random() * max);
}


function buildRow(date, que = "", exec = "", paus = "", fin = "", drop = "")
{
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
  result += "<div class='col-item col-que dragsection' id='cell_'" + getRandomInt() + " ondrop='drop(event)'' ondragover='allowDrop(event)''>" + que + "</div>";
    result += "<div class='col-item col-exec dragsection' id='cell_'" + getRandomInt() + " ondrop='drop(event)'' ondragover='allowDrop(event)''>" + exec + "</div>";
    result += "<div class='col-item col-paus dragsection' id='cell_'" + getRandomInt() + " ondrop='drop(event)'' ondragover='allowDrop(event)''>" + paus + "</div>";
    result += "<div class='col-item col-fin dragsection' id='cell_'" + getRandomInt() + " ondrop='drop(event)'' ondragover='allowDrop(event)''>" + fin + "</div>";
    result += "<div class='col-item col-drop dragsection' id='cell_'" + getRandomInt() + " ondrop='drop(event)'' ondragover='allowDrop(event)''>" + drop + "</div>";
  result += "";
  result += "</div>" + newMonthRow;
  return result;
}

  var day = (24 * 60 * 60 * 1000);
var pastDate = null;
var futDate = null;
    var datetime = new Date();
    datetime.setTime(datetime.getTime() + (3 * day));
    futDate = datetime;
    pastDate = datetime;

for (let i = 0 ; i < 30; i++){
  var dater = new Date();
    dater.setTime(datetime.getTime() - (i * day));
    pastDate = dater;
  rowCollection.insertAdjacentHTML('beforeend', buildRow(dater));
}

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

let blockTopScroll = false;
 window.onscroll = function(ev){
   rowCollection = rowCollection = document.querySelector('#rowCollection');
   var rect = rowCollection.getBoundingClientRect();
//console.log(rect.top, rect.right, rect.bottom, rect.left);
 
   var vscroll = window.pageYOffset;
   let  viewportHeight = window.innerHeight;
   let topOffset = rect.height + rowCollection.offsetTop;
//console.log("offtop is " + topOffset + " < vscroll is " + vscroll + " + viewportHeight is " +  viewportHeight);
   if (topOffset < vscroll +  viewportHeight + 1){
 //  console.log("scroll bottom");
  //console.log(topOffset);
    datetime = pastDate;
     for (let i = 0 ; i < 7; i++){
        var dater = new Date();
        dater.setTime(datetime.getTime() - ((1 + i) * day));
        pastDate = dater;
        rowCollection.insertAdjacentHTML('beforeend', buildRow(dater));
        }
        FLOWCV.reload();
    }
     
     //console.log(rowCollection.offsetTop);
     if (rowCollection.offsetTop > vscroll && !blockTopScroll){
        // console.log("scroll top");
        blockTopScroll = true;
            setTimeout(() => {
                datetime = futDate;
                for (let i = 0 ; i < 14; i++){
                var dater = new Date();
                var msr = document.querySelector("#master-row");
                dater.setTime(datetime.getTime() + ((1 + i) * day));
                futDate = dater;
                rowCollection.insertAdjacentHTML('afterbegin', buildRow(dater));
                }
                rowCollection.prepend(msr);
                blockTopScroll = false;
                FLOWCV.reload();
            }, 500);
   }
  

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


let sectionMap = buildSectionMap();

function buildSectionMap(){
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
//console.log(sectionMap);

let dataToInsert = [
  {'id': '7245434', 'name' : 'New Task', 'date' : '2023-02-21', 'section' : 'q'},
  {'id': '72454434', 'name' : 'Not New Task', 'date' : '2023-02-21', 'section' : 'e'},
    {'id': '78245434', 'name' : 'AND NES STUFF', 'date' : '2023-02-21', 'section' : 'f'},
    {'id': '72445434', 'name' : 'Do something!', 'date' : '2023-02-21', 'section' : 'p'},
      {'id': '724t45434', 'name' : 'OKAY< GO', 'date' : '2023-02-21', 'section' : 'd'},
        {'id': '72445r434', 'name' : 'Thied f fjasdjfdfj djfkasjdfkjj j jkjdf', 'date' : '2023-02-20', 'section' : 'd'},
        {'id': '7244w5434', 'name' : 'Sunday sweet task', 'date' : '2023-02-15', 'section' : 'e', 'text': 'The super text here i will come to home yesterday and will meet my husband. He is so strong, but today he is ill. I strive to do something.'},
];

//console.log(sectionMap);
SetEventsToChart(dataToInsert, sectionMap);

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
      let index = sectionMap.indexOf(evt.section);
      //console.log("index is  " + index);
      let columns = target.querySelectorAll('.col-item');
      if (columns[index] != null){
        columns[index].insertAdjacentHTML('beforeend', taskTemplate(evt.id, evt.name, evt.text));
      }
    }
  }
}



var x = 0;
var y = 0;
var startX = 0;
var startY = 0;
  // x = e.clientX; 
  // y = e.clientY; 

let comside = document.querySelector("#comside");
let cmsactuator = document.querySelector("#cmsactuator");


FLOWCV.reload();

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