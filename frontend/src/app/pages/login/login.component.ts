import { Component, OnInit } from '@angular/core';
import {Router, ActivatedRoute } from '@angular/router';
import { AppModule } from './../../app.module';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import { CommonDataService } from './../../common-data.service';
import {LoginService} from './../../shared/_services/login.service';
import {AuthService} from './../../shared/_services/auth.service';
import {CommonService} from './../../shared/_services/common.service';


@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
    public form: FormGroup;
    response: any;

    constructor(private _commondata: CommonDataService, public fb: FormBuilder, public loginService: LoginService,
                public authService: AuthService, public route: ActivatedRoute, public router: Router,
                public commonService: CommonService) {
        this.form = this.fb.group({
            'username': ['', Validators.compose([Validators.required, Validators.minLength(10)])],
            'password': ['', Validators.compose([Validators.required, Validators.minLength(5)])]

        });
        this.response = [];
    }

    ngOnInit() {
        this.authService.checkAuthentication();
    }

    validateMobile(event: any) {
        if (event.charCode !== 0) {
            const pattern = /[0-9\\ ]/;
            const inputChar = String.fromCharCode(event.charCode);
            if (!pattern.test(inputChar)) {
                event.preventDefault();
            }
        }
    }

    login(): void {
        if (this.form.valid ) {
            this._commondata.showLoader(true);
            const data = {
                'platform': 'web',
                'mobile': this.form.controls['username'].value,
                'password': this.form.controls['password'].value
            };
            this.loginService.doLogin(data).subscribe(
                (successData) => {
                    this.loginSuccess(successData);
                },
                (error) => {
                    this.loginFailure(error);
                }
            );
        }
    }

    loginSuccess(successData) {
        this.response = successData.ResponseObject;
        this._commondata.showLoader(false);
        if (successData.IsSuccess) {
            this.authService.setSessionData('name', this.response.name);
            this.authService.setSessionData('mobile', this.response.mobile);
            this.authService.setSessionData('roleid', this.response.roleid);
            this.authService.setSessionData('userid', this.response.userid);
            this.authService.setSessionData('is_voted', this.response.is_voted);
            this.authService.setSessionData('accesstoken', this.response.Accesstoken);
            this.router.navigate(['/participant']);
        } else {
            this.commonService.addToast('', 'Login Failure!', 'error');
        }
    }

    loginFailure(error) {
        this.commonService.addToast('', 'Login Failure!', 'error');
    }

}
