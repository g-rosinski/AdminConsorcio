import { Component, OnInit } from '@angular/core';
import { Router } from "@angular/router";
import { ToastrService } from 'ngx-toastr';
import { MatDialog } from '@angular/material';
import { AgregarOperadorComponent } from '../modals/agregar-operador.component';
import { RegistroLoginService } from '../../services/registro-login.service';

@Component({
  selector: 'app-fab-button',
  templateUrl: './fab-button.component.html',
  styleUrls: ['./fab-button.component.css']
})
export class FabButtonComponent implements OnInit {
  constructor(
    private router: Router,
    private toast: ToastrService,
    private dialog: MatDialog,
    private session: RegistroLoginService,
  ) { }

  ngOnInit() {
  }

  openDialog(): void {
    let dialogRef = this.dialog.open(AgregarOperadorComponent, { width: '500px' });
  }

  logout() {
    this.session.logout()
      .then(() => {
        this.router.navigate([''])
          .then(x => {
            this.toast.info('Ha salido correctamente de su cuenta');
          });
      });
  }

}
