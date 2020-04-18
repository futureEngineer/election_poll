import {Component, Injectable} from '@angular/core';
import {ToastaService, ToastaConfig, ToastOptions, ToastData} from 'ngx-toasta';

@Injectable()
export class CommonService {
    constructor(private toastaService: ToastaService, private toastaConfig: ToastaConfig) {
        // Assign the selected theme name to the `theme` property of the instance of ToastaConfig.
        // Possible values: default, bootstrap, material
        this.toastaConfig.theme = 'bootstrap';
        this.toastaConfig.position = 'top-right';
    }

    addToast(title, msg, type) {
        // Just add default Toast with title only
       // this.toastaService.error('Hi there');
        // Or create the instance of ToastOptions
        const toastOptions: ToastOptions = {
            title: title,
            msg: msg,
            showClose: true,
            timeout: 5000,
            theme: type,
            onAdd: (toast: ToastData) => {
                // console.log('Toast ' + toast.id + ' has been added!');
            },
            onRemove: function (toast: ToastData) {
               // console.log('Toast ' + toast.id + ' has been removed!');
            }
        };

        switch (type) {
            case 'default':
                this.toastaService.default(toastOptions);
                break;
            case 'info':
                this.toastaService.info(toastOptions);
                break;
            case 'success':
                this.toastaService.success(toastOptions);
                break;
            case 'wait':
                this.toastaService.wait(toastOptions);
                break;
            case 'error':
                this.toastaService.error(toastOptions);
                break;
            case 'warning':
                this.toastaService.warning(toastOptions);
                break;
        }
    }
}
