import { Component, OnInit } from '@angular/core';
import { CommonDataService } from './../../common-data.service';
import { ToastaService, ToastaConfig, ToastOptions, ToastData } from 'ngx-toasta';



@Component({
  selector: 'app-toastr',
  templateUrl: './toastr.component.html',
  styleUrls: ['./toastr.component.scss'],
})
export class ToastrComponent implements OnInit {

    
    public position : string;
    
    constructor(private _commondata: CommonDataService, private toastaService: ToastaService, private toastaConfig: ToastaConfig) {
        // Assign the selected theme name to the `theme` property of the instance of ToastaConfig. 
        // Possible values: default, bootstrap, material
        this.toastaConfig.theme = 'material';
        this.toastaConfig.position = 'top-right';
    }

   

  

    ngOnInit() {
        this._commondata.setExpandDiv('elements');
        setTimeout(_ => this._commondata.showLoader(false), 200);

        
    }
    

    showToast()
    {
        

        var shortCutFunction = (<HTMLInputElement>document.querySelector('.rd:checked')).value;
        
        var msg = (<HTMLInputElement>document.getElementById('message')).value;
        var title = (<HTMLInputElement>document.getElementById('title')).value || '';
        var $showDuration = (<HTMLInputElement>document.getElementById('showDuration')).value;
        
        
       
      
        
        

       


        var toastOptions: ToastOptions = {
            title: title,
            msg: msg,
            showClose: (<HTMLInputElement>document.getElementById('closeButton')).checked,
            timeout: ($showDuration.length) ? parseInt($showDuration) : 2000,
            theme: 'bootstrap'
            
        };



        if (shortCutFunction == "success")
        {
            this.toastaService.success(toastOptions);

          
           
        }

        if (shortCutFunction == "info")
        {
            this.toastaService.info(toastOptions);
        }

        if (shortCutFunction == "warning") {
            this.toastaService.warning(toastOptions);
        }

        if (shortCutFunction == "error") {
            this.toastaService.error(toastOptions);
        }

       
        
       
       
        
    }

    clearAllToasts()
    {
        //this.toastr.clearAllToasts()
        this.toastaService.clearAll();
    }

    

    
};


    


