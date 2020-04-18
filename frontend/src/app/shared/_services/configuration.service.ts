import { Injectable } from '@angular/core';
import { environment } from './../../../environments/environment';

declare let numeral: any;

@Injectable()
export class ConfigurationService {

  apiHost: string = environment.apiHost;
  webHost: string = environment.webHost;
  imgUrl: string = environment.imgUrl;

  webhost: string;
  imgurl: string;
  apihost: string;



  constructor() {
    this.webhost = this.webHost;
    this.imgurl = this.imgUrl;
    this.apihost = this.apiHost;
  }
    getHost() {
        return this.apiHost;
    }
    getwebHost() {
        return this.webHost;
    }
    getImageUrl() {
    return this.imgUrl;
    }

}
