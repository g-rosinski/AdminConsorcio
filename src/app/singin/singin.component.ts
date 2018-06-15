import { Component, OnInit } from '@angular/core';
import { RegistroLoginService } from './../services/registro-login.service';
import {Router} from "@angular/router";

@Component({
  selector: 'app-singin',
  templateUrl: './singin.component.html',
  styleUrls: ['./singin.component.css']
})
export class SinginComponent {

  formModel = { user: '', pass: '' };

  constructor(
    private login: RegistroLoginService,
    private router: Router
  ) { }

  onSubmit() {
    this.login.loguear(this.formModel)
    .then(x=> {
      this.router.navigate(['home']); 
    });
  }

}
