import { Component, OnInit } from '@angular/core';
import { UsuarioService } from './../services/usuario.service';
import { RegistroLoginService } from './../services/registro-login.service';

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
  ) { }

  ngOnInit() {
    this.usuarioService.obtenerUsuarioFull(this.session.usuario.user)
      .subscribe(u => {
        this.usuario = u
        this.usuario.id_rol = +this.usuario.id_rol;
      });
  }
}
