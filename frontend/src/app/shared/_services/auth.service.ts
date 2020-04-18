import { Injectable } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';


@Injectable()
export class AuthService {

    constructor(private router: Router) { }

    loggedIn() {
        return (this.getAccessToken() === undefined || this.getAccessToken() === '' || this.getAccessToken() == null) ?  false : true;
    }

    clearToken() {
        sessionStorage.removeItem('userid');
        sessionStorage.removeItem('name');
        sessionStorage.removeItem('accesstoken');
        sessionStorage.removeItem('roleid');
        sessionStorage.removeItem('mobile');
        sessionStorage.removeItem('is_voted');
    }

    checkVoted() {
        return sessionStorage.getItem('is_voted');
    }

    getUserId() {
        return sessionStorage.getItem('userid');
    }

    getUserFirstName() {
        return (sessionStorage.getItem('name') === undefined || sessionStorage.getItem('name') === '' ||
            sessionStorage.getItem('name') == null) ? '': sessionStorage.getItem('name');
    }

    getAccessToken() {
        return sessionStorage.getItem('accesstoken');
    }

    getRoleId() {
        return sessionStorage.getItem('roleid');
    }

    getUserMobile() {
        return (sessionStorage.getItem('mobile') === undefined || sessionStorage.getItem('mobile') === '' ||
            sessionStorage.getItem('mobile') == null) ? '': sessionStorage.getItem('mobile');
    }

    getSessionData(variable) {
        return sessionStorage.getItem(variable);
    }
    setSessionData(variable, value) {
        return sessionStorage.setItem(variable, value);
    }

    /**
     * Checks wether used is logged in
     * and Redirects to users repository
     */
    checkAuthentication() {
        if (this.loggedIn()) {
            this.router.navigate(['/participant']);
        }
    }
}
