import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router';
import { RegistroLoginService } from './registro-login.service';
import { Observable } from 'rxjs';
import { ToastrService } from 'ngx-toastr';
import { Router } from "@angular/router";
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/first';

@Injectable()
export class LoginGuard implements CanActivate {

  constructor(
    private session: RegistroLoginService,
    private toast: ToastrService,
    private router: Router,
  ) { }

  canActivate(): Observable<boolean> {
    return this.session
      .obtenerSession()
      .map((x) => {
        if (x) {
          this.router.navigate(['home']);
        }
        return !x;
      });
  }

}