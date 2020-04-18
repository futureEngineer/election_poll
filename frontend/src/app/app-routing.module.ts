import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DashboardComponent } from './dashboards/dashboard/dashboard.component';
import { Dashboard02Component } from './dashboards/dashboard02/dashboard02.component';
import { Dashboard03Component } from './dashboards/dashboard03/dashboard03.component';
import { Dashboard04Component } from './dashboards/dashboard04/dashboard04.component';
import { Dashboard05Component } from './dashboards/dashboard05/dashboard05.component';
import { AccordionsComponent } from './elements/accordions/accordions.component';
import { AlertsComponent } from './elements/alerts/alerts.component';
import { ButtonsComponent } from './elements/buttons/buttons.component';
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
import { MailComponent } from './mail/mail.component';

import { ChartComponent } from './chart/chart.component';
import { CalendarComponent } from './calendar/calendar.component';
import { EditorComponent } from './forms/editor/editor.component';
import { FormInputComponent } from './forms/form-input/form-input.component';
import { FormValidationComponent } from './forms/form-validation/form-validation.component';
import { InputGroupComponent } from './forms/input-group/input-group.component';
import { ToastrComponent } from './forms/toastr/toastr.component';


import { FontawesomeIconComponent } from './icons/fontawesome-icon/fontawesome-icon.component';
import { ThemifyIconsComponent } from './icons/themify-icons/themify-icons.component';
import { WeatherIconComponent } from './icons/weather-icon/weather-icon.component';
import { WidgetsComponent } from './widgets/widgets.component';

import { ProfileComponent } from './pages/profile/profile.component';
import { ChatComponent } from './chat/chat.component';
import { AppContactsComponent } from './pages/app-contacts/app-contacts.component';
import { FileManagerComponent } from './pages/file-manager/file-manager.component';

import { LayoutContainerComponent } from './pages/layout-container/layout-container.component';
import { ErrorComponent } from './pages/error/error.component';
import { FaqsComponent } from './pages/faqs/faqs.component';

import { MapsComponent } from './maps/maps.component';
import { TimelineComponent } from './timeline/timeline.component';
import { LoginComponent } from './pages/login/login.component';
import { LayoutComponent } from './pages/layout/layout.component';
import { AuthGuardService } from './shared/_services/auth-guard.service';


import { RegisterComponent } from './auth/register/register.component';
import { LockscreenComponent } from './auth/lockscreen/lockscreen.component';
import {ParticipantComponent} from './pages/participant/participant.component';


const routes: Routes = [
    { path: '', redirectTo: 'login', pathMatch: 'full' },
    {
        path: '',
        component: LayoutComponent,  canActivate: [AuthGuardService], children: [
            { path: 'dashboard', component: DashboardComponent, data: { breadcrumb: 'Dashboard' } },
            { path: 'participant', component: ParticipantComponent, data: { breadcrumb: 'Dashboard' } },
        ]},
    { path: 'login', component: LoginComponent }
];

@NgModule({
    imports: [
        RouterModule.forRoot(routes, { useHash: true})
    ],
  exports: [RouterModule]
})
export class AppRoutingModule {}


