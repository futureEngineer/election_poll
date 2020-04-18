import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HashLocationStrategy, LocationStrategy } from '@angular/common';
import { AppRoutingModule } from './app-routing.module';
import { MalihuScrollbarModule } from 'ngx-malihu-scrollbar';
import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';


import { AppComponent } from './app.component';
import { DashboardComponent } from './dashboards/dashboard/dashboard.component';
import { Dashboard02Component } from './dashboards/dashboard02/dashboard02.component';
import { Dashboard03Component } from './dashboards/dashboard03/dashboard03.component';
import { Dashboard04Component } from './dashboards/dashboard04/dashboard04.component';
import { Dashboard05Component } from './dashboards/dashboard05/dashboard05.component';

import { CommonDataService } from './common-data.service';
import { AccordionsComponent } from './elements/accordions/accordions.component';
import { AlertsComponent } from './elements/alerts/alerts.component';
import { ColorpickerComponent } from './elements/colorpicker/colorpicker.component';
import { DropdownComponent } from './elements/dropdown/dropdown.component';
import { ListsComponent } from './elements/lists/lists.component';
import { ModalComponent } from './elements/modal/modal.component';
import { NavComponent } from './elements/nav/nav.component';

import { NicescrollComponent } from './elements/nicescroll/nicescroll.component';
import { PricingtableComponent } from './elements/pricingtable/pricingtable.component';

import { DataHtmlTableComponent } from './data-table/data-html-table/data-html-table.component';
import { DataLocalComponent } from './data-table/data-local/data-local.component';
import { DataTableComponent } from './data-table/data-table/data-table.component';
import { DatepickerComponent } from './elements/datepicker/datepicker.component';

import { TabsComponent } from './elements/tabs/tabs.component';
import { TypographyComponent } from './elements/typography/typography.component';
import { PopoverTooltipsComponent } from './elements/popover-tooltips/popover-tooltips.component';
import { ProgressComponent } from './elements/progress/progress.component';
import { SwitchComponent } from './elements/switch/switch.component';
import { Sweetalert2Component } from './elements/sweetalert2/sweetalert2.component';

import { ChartComponent } from './chart/chart.component';
import { CalendarComponent } from './calendar/calendar.component';
import { EditorComponent } from './forms/editor/editor.component';
import { FormInputComponent } from './forms/form-input/form-input.component';
import { InputGroupComponent } from './forms/input-group/input-group.component';
import { ToastrComponent } from './forms/toastr/toastr.component';

import { FontawesomeIconComponent } from './icons/fontawesome-icon/fontawesome-icon.component';
import { ThemifyIconsComponent } from './icons/themify-icons/themify-icons.component';
import { WeatherIconComponent } from './icons/weather-icon/weather-icon.component';
import { WidgetsComponent } from './widgets/widgets.component';
import { ProfileComponent } from './pages/profile/profile.component';
import { ChatComponent } from './chat/chat.component';
import { AppContactsComponent } from './pages/app-contacts/app-contacts.component';

import { LayoutContainerComponent } from './pages/layout-container/layout-container.component';
import { ErrorComponent } from './pages/error/error.component';
import { FaqsComponent } from './pages/faqs/faqs.component';

import { MapsComponent } from './maps/maps.component';
import { TimelineComponent } from './timeline/timeline.component';
import { LoginComponent } from './pages/login/login.component';
import { LayoutComponent } from './pages/layout/layout.component';

import { RegisterComponent } from './auth/register/register.component';
import { LockscreenComponent } from './auth/lockscreen/lockscreen.component';
import { FormValidationComponent } from './forms/form-validation/form-validation.component';
import { FieldErrorDisplayComponent } from './forms/field-error-display/field-error-display.component';

import { Modal1Component } from './shared/_directives/index';
import { ModalService } from './shared/_services/index';
import { RatingComponent } from './shared/_directives/rating/rating.component';
import { ButtonsComponent } from './elements/buttons/buttons.component';
import { MailComponent } from './mail/mail.component';
import { ToastaModule } from 'ngx-toasta';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { ColorPickerModule } from 'ngx-color-picker';

import { NgxDatatableModule } from '@swimlane/ngx-datatable';

import {  HttpClientModule } from '@angular/common/http';
import { HttpModule } from '@angular/http';


import { NgxChartsModule } from '@swimlane/ngx-charts';

import { AgmCoreModule } from '@agm/core';

import { DxVectorMapModule, DxSelectBoxModule, DxTextBoxModule } from 'devextreme-angular';

import { CKEditorModule } from 'ngx-ckeditor';

import { ChartsModule } from 'ng2-charts';

import { CalendarModule } from 'angular-calendar';

import { NgbModalModule } from '@ng-bootstrap/ng-bootstrap';

import { DemoUtilsModule } from './demo-utils/module';

import { LoginService } from './shared/_services/login.service';
import { ConfigurationService} from './shared/_services/configuration.service';
import { AuthService} from './shared/_services/auth.service';
import { AuthGuardService} from './shared/_services/auth-guard.service';
import {CommonService} from './shared/_services/common.service';
import { ParticipantComponent } from './pages/participant/participant.component';

import {UserService} from './shared/_services/user.service';


declare var require: any;

@NgModule({
  declarations: [
    AppComponent,
    DashboardComponent,
    Dashboard02Component,
    Dashboard03Component,
    Dashboard04Component,
    Dashboard05Component,
    AccordionsComponent,
    AlertsComponent,
    ColorpickerComponent,
    DropdownComponent,
    ListsComponent,
    ModalComponent,
    NavComponent,
    NicescrollComponent,
    PricingtableComponent,
    DataHtmlTableComponent,
    DatepickerComponent,
    TabsComponent,
    TypographyComponent,
    PopoverTooltipsComponent,
    ProgressComponent,
    SwitchComponent,
    Sweetalert2Component,
    ChartComponent,
    CalendarComponent,
    EditorComponent,
    FormInputComponent,
    InputGroupComponent,
    ToastrComponent,
    FontawesomeIconComponent,
    ThemifyIconsComponent,
    WeatherIconComponent,
    WidgetsComponent,
    ProfileComponent,
    ChatComponent,
    AppContactsComponent,
    LayoutContainerComponent,
    ErrorComponent,
    FaqsComponent,
    MapsComponent,
    TimelineComponent,
    LoginComponent,
    LayoutComponent,
    RegisterComponent,
    LockscreenComponent,
    Modal1Component,
    RatingComponent,
    ButtonsComponent,
    FormValidationComponent,
    FieldErrorDisplayComponent,
    MailComponent,
    DataLocalComponent,
    DataTableComponent,
      ParticipantComponent],

  imports: [
      BrowserModule,
      AppRoutingModule,
      BrowserAnimationsModule,
      ToastaModule.forRoot(),
      NgbModule.forRoot(),
      NgMultiSelectDropDownModule.forRoot(),
      ReactiveFormsModule,
      FormsModule,
      ChartsModule,
      NgxDatatableModule,
      ColorPickerModule,
      HttpModule,
      NgxChartsModule,
      AgmCoreModule.forRoot({ apiKey: "AIzaSyDjVoaCW3PAn52C7WPpJ7NBBqU1_TUfnSI" }),
      DxVectorMapModule,
      DxSelectBoxModule,
      DxTextBoxModule,
      CKEditorModule,
      MalihuScrollbarModule.forRoot(),
      NgbModalModule.forRoot(),
      CalendarModule.forRoot(),
      DemoUtilsModule,
      HttpClientModule
  ],
  providers: [
    CommonDataService,
    LoginService,
    ConfigurationService,
    CommonService,
    AuthService,
    AuthGuardService,
    ModalService,
      UserService,
    { provide: LocationStrategy, useClass: HashLocationStrategy }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
