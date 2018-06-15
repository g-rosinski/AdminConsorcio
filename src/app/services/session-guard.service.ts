import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router';
import { RegistroLoginService } from './registro-login.service';
import { Observable } from 'rxjs';
import { ToastrService } from 'ngx-toastr';
import { Router } from "@angular/router";
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/first';

@Injectable()
export class SessionGuard implements CanActivate {

  constructor(
    private session: RegistroLoginService,
    private toast: ToastrService,
    private router: Router,
  ) { }

  canActivate(): Observable<boolean> {
    return this.session
      .obtenerSession()
      .map((x) => {
        if (!x) {
          this.router.navigate([''])
            .then(x => {
              this.toast.error('Para ver esta pagina por favor Inicie Sesion');
              return false;
            });
        }
        return !!x;
      });
  }

}