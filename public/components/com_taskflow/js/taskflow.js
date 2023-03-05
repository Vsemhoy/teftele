

class TaskFlow{

    constructor(){
        this.inputAwakers = document.querySelectorAll('.u-custom-input-awake');
        for (let index = 0; index < this.inputAwakers.length; index++) {

            this.inputAwakers[index].addEventListener("dblclick", (e)=> {
                let el = this.inputAwakers[index].querySelector('input');
                if (el == null){
                    el = this.inputAwakers[index].querySelector('textarea');
                }
                if (el == null){
                    el = this.inputAwakers[index].querySelector('checkbox');
                }
                if (el == null){
                    el = this.inputAwakers[index].querySelector('range');
                }
                if (el != null){
                    el.toggleAttribute('disabled');
                }
                console.log("ye");
            });
            
            
        }
    }
}

var TSF = new TaskFlow();