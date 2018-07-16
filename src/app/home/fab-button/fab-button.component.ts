import { Component, OnInit, Input } from '@angular/core';
import { Router } from "@angular/router";
import { ToastrService } from 'ngx-toastr';
import { MatDialog } from '@angular/material';
import { AgregarOperadorComponent } from '../modals/agregar-operador/agregar-operador.component';
import { RegistroLoginService } from '../../services/registro-login.service';
import { AgregarConsorcioComponent } from '../modals/agregar-consorcio/agregar-consorcio.component';

@Component({
  selector: 'app-fab-button',
  templateUrl: './fab-button.component.html',
  styleUrls: ['./fab-button.component.css']
})
export class FabButtonComponent implements OnInit {
  @Input() usuario

  constructor(
    private router: Router,
    private toast: ToastrService,
    private dialog: MatDialog,
    private session: RegistroLoginService,
  ) { }

  ngOnInit() {
  }

  openDialog(): void {
    let dialogRef = this.dialog.open(AgregarOperadorComponent, { width: '700px' });
  }

  openAgregarConsorcio() {
    this.dialog.open(AgregarConsorcioComponent, {
      width: '1000px',
    });
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
