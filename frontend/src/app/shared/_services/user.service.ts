
import {throwError as observableThrowError, Observable} from 'rxjs';
import {catchError, map} from 'rxjs/operators';
import {AuthService} from './auth.service';
import {ConfigurationService} from './configuration.service';
import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';


@Injectable()
export class UserService {

    constructor(private http: HttpClient, private configurationService: ConfigurationService, private auth: AuthService) {

    }

    addParticipant(data) {
        const json = JSON.stringify(data);
        const token = this.auth.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*', 'Accesstoken': token})
        };
        const url = this.configurationService.getHost() + 'participant/add';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
    }

    getParticipantList(data) {
        const json = JSON.stringify(data);
        const token = this.auth.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*', 'Accesstoken': token})
        };
        const url = this.configurationService.getHost() + 'participant/lists';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
    }

    updateParticipant(data) {
        const json = JSON.stringify(data);
        const token = this.auth.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*', 'Accesstoken': token})
        };
        const url = this.configurationService.getHost() + 'participant/edit';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
    }

    deleteParticipant(data) {
        const json = JSON.stringify(data);
        const token = this.auth.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*', 'Accesstoken': token})
        };
        const url = this.configurationService.getHost() + 'participant/delete';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
    }

    getPartyList(data) {
        const json = JSON.stringify(data);
        const token = this.auth.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*', 'Accesstoken': token})
        };
        const url = this.configurationService.getHost() + 'common/partyLists';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
    }

    getVotes(data) {
        const json = JSON.stringify(data);
        const token = this.auth.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*', 'Accesstoken': token})
        };
        const url = this.configurationService.getHost() + 'common/getVotes';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
    }

    vote(data) {
        const json = JSON.stringify(data);
        const token = this.auth.getAccessToken();
        const httpOptions = {
            headers: new HttpHeaders({'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*', 'Accesstoken': token})
        };
        const url = this.configurationService.getHost() + 'common/vote';
        return this.http.post(url , json, httpOptions).pipe(
            map(this.extractData ),
            catchError(this.handleError));
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
