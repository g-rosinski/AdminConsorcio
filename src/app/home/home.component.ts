import { Component, OnInit } from '@angular/core';
import { UsuarioService } from './../services/usuario.service';
import { RegistroLoginService } from './../services/registro-login.service';
import { Router } from "@angular/router";
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  name = '';
  consorcio = '';
  countUsers = 0;

  constructor(
    private usuarioService: UsuarioService,
    private session: RegistroLoginService,
    private router: Router,
    private toast: ToastrService,
  ) { }

  ngOnInit() {
    this.usuarioService.obtenerUsuariosInactivos().subscribe((x: Array<any>) => this.countUsers = x.length);
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
