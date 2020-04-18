import {Component, OnInit,  ViewChild} from '@angular/core';
import {FormGroup, FormBuilder, Validators} from '@angular/forms';
import { ModalService } from './../../shared/_services/index';
import {ValidateService} from './../../shared/_services/validate.service';
import {AuthService} from './../../shared/_services/auth.service';
import {CommonService} from './../../shared/_services/common.service';
import {ConfigurationService} from './../../shared/_services/configuration.service';
import { CommonDataService } from './../../common-data.service';
import {NgbCalendar} from '@ng-bootstrap/ng-bootstrap';
import {UserService} from '../../shared/_services/user.service';
import {Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-participant',
  templateUrl: './participant.component.html',
  styleUrls: ['./participant.component.scss']
})
export class ParticipantComponent implements OnInit {

  @ViewChild('participantForm') participantForm;
  @ViewChild('participantDeleteForm') participantDeleteForm;
  @ViewChild('voteFormModal') voteFormModal;

  public form: FormGroup;
  public edit: boolean;
  public participantList: any;
  public tempParticipant: any;
  public partyList: any;
  public tempParty: any;
  public voteList: any;
  today: any;
  index: any;
  public imagepath: any;
  public role_id: any;
  public is_voted: any;

  constructor(private _commondata: CommonDataService, private modalService: ModalService, public user: UserService,
              public fb: FormBuilder, public validateSService: ValidateService, public auth: AuthService, public router: Router,
              public commonService: CommonService, calendar: NgbCalendar, public config: ConfigurationService) {

    this.form = this.fb.group({
      name : ['', Validators.required],
      mobile : ['', Validators.required],
      age : ['', Validators.required],
      gender : ['', Validators.required],
      qualification : '',
      party : ['', Validators.required],
    });

    this.edit = false;
    this.participantList = [];
    this.tempParticipant = [];
    this.partyList = [];
    this.tempParty = [];
    this.voteList = [];
    this.imagepath = 'http://localhost/election/';
    this.role_id = this.auth.getRoleId();
    this.is_voted = this.auth.checkVoted();
    console.log( this.role_id, ' this.role_id');
    console.log(this.is_voted, 'this.is_voted');
  }

  ngOnInit() {
    this.getParty();
    this.getParticipant();
    this.getVotes();
  }


  getVotes() {
    this._commondata.showLoader(true);
    const data = {
      'platform': 'web',
      'roleid': this.auth.getRoleId(),
      'userid': this.auth.getUserId()
    };
    this.user.getVotes(data).subscribe(
        (successData) => {
          this.votelistSuccess(successData);
        },
        (error) => {
          this.votelistFailure(error);
        }
    );
  }

  votelistSuccess(successData) {
    this._commondata.showLoader(false);
    if (successData.IsSuccess) {
      this.voteList = successData.ResponseObject['records'];
    }
  }

  votelistFailure(error) {
    this.commonService.addToast('', 'Failed to add a company!', 'error');
  }

  getParticipant() {
    this._commondata.showLoader(true);
    const data = {
      'platform': 'web',
      'roleid': this.auth.getRoleId(),
      'userid': this.auth.getUserId()
    };
    this.user.getParticipantList(data).subscribe(
        (successData) => {
          this.listSuccess(successData);
        },
        (error) => {
          this.listFailure(error);
        }
    );
  }

  listSuccess(successData) {
    this._commondata.showLoader(false);
    if (successData.IsSuccess) {
      this.participantList = successData.ResponseObject;
      this.tempParticipant = this.participantList;
    }
  }

  listFailure(error) {
    this.commonService.addToast('', 'Failed to add a company!', 'error');
  }

  public editParticipant(row, id: string) {
    this.edit = true;
    this.index = row.participant_id;
    this.form.controls['name'].patchValue(row.participant_name);
    this.form.controls['age'].patchValue(row.age);
    this.form.controls['mobile'].patchValue(row.mobile);
    this.form.controls['gender'].patchValue(row.gender);
    this.form.controls['party'].patchValue(row.party_id);
    this.modalService.open(id);
  }

  // character should be allowed
  public characterPattern(event: any) {
    this.validateSService.characterPattern(event);
  }

  getParty() {
    this._commondata.showLoader(true);
    const data = {
      'platform': 'web',
      'roleid': this.auth.getRoleId(),
      'userid': this.auth.getUserId()
    };
    this.user.getPartyList(data).subscribe(
        (successData) => {
          this.getPartyListSuccess(successData);
        },
        (error) => {
          this.getPartyListFailure(error);
        }
    );
  }

  getPartyListSuccess(successData) {
    this._commondata.showLoader(false);
    if (successData.IsSuccess) {
      this.partyList = successData.ResponseObject;
      console.log(this.partyList, 'partyList');
      this.tempParty = this.partyList;
    }
  }

  getPartyListFailure(error) {
    this.commonService.addToast('', 'Failed to add a company!', 'error');
  }

  add() {
    if (this.form.valid ) {
      this._commondata.showLoader(true);
      const data = {
        'platform': 'web',
        'roleid': this.auth.getRoleId(),
        'userid': this.auth.getUserId(),
        'party_id': this.form.controls['party'].value,
        'name': this.form.controls['name'].value,
        'age': this.form.controls['age'].value,
        'gender': this.form.controls['gender'].value,
        'mobile': this.form.controls['mobile'].value,
        'qualification': this.form.controls['qualification'].value,
      };
      this.user.addParticipant(data).subscribe(
          (successData) => {
            this.addParticipantSuccess(successData);
          },
          (error) => {
            this.addParticipantFailure(error);
          }
      );
    }
  }

  addParticipantSuccess(successData) {
    this._commondata.showLoader(false);
    this.closeModal('participantFormModal');
    console.log('add');
    this.getParticipant();
    if (successData.IsSuccess) {
      this.commonService.addToast('', 'Participant added successfully', 'success');
    } else {
      this.commonService.addToast('', 'Failed to add a participant', 'error');
    }
  }

  addParticipantFailure(error) {
    this.commonService.addToast('', 'Failed to add a participant', 'error');
  }

  update() {
    if (this.form.valid ) {
      this._commondata.showLoader(true);
      const data = {
        'platform': 'web',
        'roleid': this.auth.getRoleId(),
        'userid': this.auth.getUserId(),
        'participant_id': this.index,
        'party_id': this.form.controls['party'].value,
        'name': this.form.controls['name'].value,
        'age': this.form.controls['age'].value,
        'gender': this.form.controls['gender'].value,
        'mobile': this.form.controls['mobile'].value,
        'qualification': this.form.controls['qualification'].value,
      };
      this.user.updateParticipant(data).subscribe(
          (successData) => {
            this.updateParticipantSuccess(successData);
          },
          (error) => {
            this.updateParticipantFailure(error);
          }
      );
    }
  }

  updateParticipantSuccess(successData) {
    this._commondata.showLoader(false);
    this.closeModal('participantFormModal');
    this.getParticipant();
    if (successData.IsSuccess) {
      this.commonService.addToast('', 'Participant updated successfully', 'success');
    } else {
      this.commonService.addToast('', 'Failed to update a participant', 'error');
    }
  }

  updateParticipantFailure(error) {
    this.commonService.addToast('', 'Failed to update a participant', 'error');
  }

  public delete() {
    const data = {
      'platform': 'web',
      'roleid': this.auth.getRoleId(),
      'userid': this.auth.getUserId(),
      'participant_id': this.index
    };
    this.user.deleteParticipant(data).subscribe(
        (successData) => {
          this.deleteSuccess(successData);
        },
        (error) => {
          this.deleteFailure(error);
        }
    );
  }

  public deleteSuccess(successData) {
    if (successData.IsSuccess) {
      this.commonService.addToast('', successData.ResponseObject, 'success');
      this.getParticipant();
    } else {
      this.commonService.addToast('', 'Failed to update a company', 'error');
    }
  }

  public deleteFailure(error) {
    console.log(error);
  }

  validateNumber(event: any) {
    if (event.charCode !== 0) {
      const pattern = /[0-9\\ ]/;
      const inputChar = String.fromCharCode(event.charCode);
      if (!pattern.test(inputChar)) {
        event.preventDefault();
      }
    }
  }

  openModal(id: string, action: string) {
    if (action === 'add') {
      this.edit = false;
    } else {
      this.edit = true;
    }

    this.modalService.open(id);
  }

  closeModal(id: string) {
    this.form.reset();
    this.modalService.close(id);
  }

  updateFilter(event) {
    const val = event.target.value.toLowerCase();
    const temp = this.participantList.filter(function (d) {
      return d.participant_name.toLowerCase().indexOf(val) !== -1 || !val;
    });
    this.tempParticipant = temp;
  }


  vote(participant_id) {
    this._commondata.showLoader(true);
    const data = {
      'platform': 'web',
      'roleid': this.auth.getRoleId(),
      'userid': this.auth.getUserId(),
      'participant_id': participant_id
    };
    this.user.vote(data).subscribe(
        (successData) => {
          this.voteSuccess(successData);
        },
        (error) => {
          this.voteFailure(error);
        }
    );
  }

  voteSuccess(successData) {
    this._commondata.showLoader(false);
    if (successData.IsSuccess) {
      console.log('voteFormModal');
      this.commonService.addToast('', 'Voted successfully', 'success');
      this.modalService.open('voteFormModal');
    }
  }

  voteFailure(error) {
    this.commonService.addToast('', 'Failed to add a company!', 'error');
  }

  logout() {
    this.auth.clearToken();
    this.router.navigate(['/login']);
  }


}
