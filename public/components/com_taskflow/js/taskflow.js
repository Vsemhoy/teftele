

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

                    if (el.disabled == true){
                        
                        for (let i = 0; i < this.inputAwakers.length; i++) {
                            let ele = this.inputAwakers[i].querySelector('input');
                            if (ele == null){
                                ele = this.inputAwakers[i].querySelector('textarea');
                            }
                            if (ele == null){
                                ele = this.inputAwakers[i].querySelector('checkbox');
                            }
                            if (ele == null){
                                ele = this.inputAwakers[i].querySelector('range');
                            }
                            if (ele != null){

                            ele.disabled = true;
                            }
                        }
                    }
                }
            });
            
            
        }
    }
}

var TSF = new TaskFlow();