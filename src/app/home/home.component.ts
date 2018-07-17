import { Component, OnInit } from '@angular/core';
import { UsuarioService } from './../services/usuario.service';
import { RegistroLoginService } from './../services/registro-login.service';
import { ActivatedRoute, Router } from '../../../node_modules/@angular/router';
import { MatDialog } from '../../../node_modules/@angular/material';
import { PagoRealizadoComponent } from './modals/pago-realizado/pago-realizado.component';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  usuario;

  constructor(
    private usuarioService: UsuarioService,
    private session: RegistroLoginService,
    private dialog: MatDialog,
    private route: ActivatedRoute,
    private router: Router,
  ) { }

  ngOnInit() {
    this.route.queryParams
      .subscribe(params => {
        if (params && params['collection_status'])
          this.router.navigate(['home'], { preserveQueryParams: false })
            .then(()=> this.openPagoRealizado(params['collection_status']));
      });

    this.usuarioService.obtenerUsuarioFull(this.session.usuario.user)
      .subscribe(u => {
        this.usuario = u
        this.usuario.id_rol = +this.usuario.id_rol;
      });
  }

  openPagoRealizado(modo): void {
    this.dialog.open(PagoRealizadoComponent, {
      width: '500px',
      data: modo,
    })
  }
}
