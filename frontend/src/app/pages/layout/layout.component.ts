import { Component, OnInit, EventEmitter, Input, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CommonDataService } from './../../common-data.service';
import { MalihuScrollbarModule } from 'ngx-malihu-scrollbar';
import {AuthService} from './../../shared/_services/auth.service';
import {Router, ActivatedRoute } from '@angular/router';


declare var document: any;

@Component({
    selector: 'app-layout',
    templateUrl: './layout.component.html',
    styleUrls: ['./layout.component.scss']
})
export class LayoutComponent implements OnInit {
    isSearchActive:boolean = false;
    isSlideMenu:boolean = false;
    firstName: string;
    lastName: string;
    mobile: string;

    public scrollbarOptions = { axis: 'yx', theme: 'minimal'}

    constructor(public _commondata: CommonDataService, public auth: AuthService, public router: Router) {
        this.firstName = this.auth.getUserFirstName();
        this.mobile = this.auth.getUserMobile();

    }

    ngOnInit() {
      this._commondata.showLoader(true);

    }

    toggleSearch(){
      this.isSearchActive = !this.isSearchActive;
    }
    toggleMenu(){
      this.isSlideMenu = !this.isSlideMenu;
    }

    expandCollpse(sectionName) {
        let CurrentCls = document.getElementById(sectionName).getAttribute('class');
        if (CurrentCls == 'collapse' || CurrentCls == 'collapse hide')
        {
            document.getElementById(sectionName).setAttribute("class", "collapse show");
            document.getElementById(sectionName).previousElementSibling.setAttribute("aria-expanded", 'true');
        }
        else {
            document.getElementById(sectionName).setAttribute("class", "collapse hide");
            document.getElementById(sectionName).previousElementSibling.setAttribute("aria-expanded", "false");
        }
  }

  logout(){
        this.auth.clearToken();
        this.router.navigate(['/login']);
  }

  toggleFullscreen(elem) {
    elem = elem || document.documentElement;
    if (!document.fullscreenElement && !document['mozFullScreenElement'] &&
        !document.webkitFullscreenElement && !document['msFullscreenElement']) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen(Element['ALLOW_KEYBOARD_INPUT']);
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document['msExitFullscreen']) {
            document['msExitFullscreen']();
        } else if (document['mozCancelFullScreen']) {
            document['mozCancelFullScreen']();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    }
}
}
