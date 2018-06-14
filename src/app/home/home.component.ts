import { Component, OnInit } from '@angular/core';
import { UsuarioService } from './../services/usuario.service';

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
    private usuarioService: UsuarioService
  ) { }

  ngOnInit() {
    this.usuarioService.obtenerUsuariosInactivos().subscribe((x: Array<any>) => this.countUsers = x.length);
  }
}
