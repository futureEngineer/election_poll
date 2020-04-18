import { Injectable } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';


@Injectable({
  providedIn: 'root'
})
export class ValidateService {


  constructor() { }

  //form valid
  validateAllFormFields(formGroup: FormGroup) {
    Object.keys(formGroup.controls).forEach(field => {
      const control = formGroup.get(field);
      if (control instanceof FormControl) {
        control.markAsTouched({ onlySelf: true });
      } else if (control instanceof FormGroup) {
        this.validateAllFormFields(control);
      }
    });
  }

  // character should be allowed
  characterPattern(event) {
    if (event.charCode !== 0) {
      const pattern = /^[a-zA-Z ]+$/;
      const inputChar = String.fromCharCode(event.charCode);
      if (!pattern.test(inputChar)) {
        event.preventDefault();
      }
    }
  }

  // Numbers only allowed
  numberPattern(event) {
    if (event.charCode !== 0) {
      const pattern = /^[0-9]+$/;
      const inputChar = String.fromCharCode(event.charCode);
      if (!pattern.test(inputChar)) {
        event.preventDefault();
      }
    }
  }

  // Special characters not allowed
  specialPattern(event) {
    if (event.charCode !== 0) {
      const pattern = /[a-zA-Z0-9 ]/;
      const inputChar = String.fromCharCode(event.charCode);
      if (!pattern.test(inputChar)) {
        event.preventDefault();
      }
    }
  }
  // Number and dot not allowed
  dotPattern(event) {
    if (event.charCode !== 0) {
      const pattern = /^[a-zA-Z]*\.?[a-zA-Z]*$/;
      const inputChar = String.fromCharCode(event.charCode);
      if (!pattern.test(inputChar)) {
        event.preventDefault();
      }
    }
  }
}
