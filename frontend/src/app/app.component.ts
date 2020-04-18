import { Component, ViewContainerRef} from '@angular/core';
import { CommonDataService } from './common-data.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

    title = 'app';

    constructor(private _commondata: CommonDataService, vRef: ViewContainerRef) {
        
    }

    ngOnInit() {
       
    }
}
