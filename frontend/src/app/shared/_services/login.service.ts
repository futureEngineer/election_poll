
import {throwError as observableThrowError, Observable} from 'rxjs';

import {catchError, map} from 'rxjs/operators';
import {AuthService} from './auth.service';
import {ConfigurationService} from './configuration.service';
import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';


@Injectable()
export class LoginService {

    constructor(private http: HttpClient, private configurationService: ConfigurationService, private authService: AuthService) {

    }

    logout() {
        const url = this.configurationService.getHost() + 'auth/logout';
        return this.http.get(url);
    }


    doLogin(data) {
        const json = JSON.stringify(data);
        console.log(json);
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*'})
        };
        const url = this.configurationService.getHost() + 'user/login';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
    }

    doForgot(data) {
        console.log(data);
        const json = JSON.stringify(data);
        console.log(json);
        // const token = this.authService.getaccesstoken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*' })
        };
        const url = this.configurationService.getHost() + 'index/forgotPassword';
        return this.http.post(url , json, httpOptions).pipe(

            map(this.extractData ),
            catchError(this.handleError),);

    }





    generateOtp(data) {
        const json = JSON.stringify(data);
        const token = this.authService.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*'})
        };
        const url = this.configurationService.getHost() + 'common/generateOtp' ;
        return this.http.post(url, json, httpOptions).pipe(
            map(this.extractData),
            catchError(this.handleError),);
    }



    private extractData(res: Response) {
        const body = res;
        return body || {};
    }

    private handleError(error: Response | any) {
        let errMsg: string;
        if (error instanceof Response) {
            // const body = error.json() || '';
            const err = error || JSON.stringify(error);
            errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
        } else {
            errMsg = error.message ? error.message : error.toString();
        }
        return observableThrowError(error);
    }

}
