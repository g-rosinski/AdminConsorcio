import { Component, OnInit } from '@angular/core';
import { RegistroLoginService } from './../services/registro-login.service';
import { Router } from "@angular/router";
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-singin',
  templateUrl: './singin.component.html',
  styleUrls: ['./singin.component.css']
})
export class SinginComponent {

  formModel = { user: '', pass: '' };

  constructor(
    private login: RegistroLoginService,
    private router: Router,
    private toast: ToastrService
  ) { }

  onSubmit() {
    this.login.loguear(this.formModel)
      .then(x => {
        if (x)
          this.toast.error(x);
        else
          this.router.navigate(['home']);
      });
  }

}
