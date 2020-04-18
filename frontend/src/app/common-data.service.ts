import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable()
export class CommonDataService {

    public loader: BehaviorSubject<boolean> = new BehaviorSubject<boolean>(false);


    constructor() { }

    showLoader(value: boolean) {
        this.loader.next(value);
        console.log(value);
    }

     setExpandDiv(id)
    {
        document.getElementById(id).setAttribute("class", "collapse show");
        document.getElementById(id).previousElementSibling.setAttribute("aria-expanded", "true");

    }
}
