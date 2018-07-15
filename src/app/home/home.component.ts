import { Component, OnInit } from '@angular/core';
import { UsuarioService } from './../services/usuario.service';
import { RegistroLoginService } from './../services/registro-login.service';
import { GastoService } from '../services/gasto.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  usuario;
  URLMP = '';

  constructor(
    private usuarioService: UsuarioService,
    private session: RegistroLoginService,
    private gs: GastoService,
  ) { }

  ngOnInit() {
    this.usuarioService.obtenerUsuarioFull(this.session.usuario.user)
      .subscribe(u => {
        this.usuario = u
        this.usuario.id_rol = +this.usuario.id_rol;
      });
    this.gs.generarMPBoton().then((data: any) => this.URLMP = data.url)
  }

  redirect(){
    window.location.href = this.URLMP;
  }
}
