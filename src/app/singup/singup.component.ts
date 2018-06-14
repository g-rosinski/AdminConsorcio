import { Component, OnInit } from '@angular/core';
import { MatRadioChange } from '@angular/material';
import { Observable } from 'rxjs';
import { ConsorcioService } from './../services/consorcio.service';
import { UsuarioService } from './../services/usuario.service';

@Component({
  selector: 'app-singup',
  templateUrl: './singup.component.html',
  styleUrls: ['./singup.component.css']
})
export class SingupComponent implements OnInit {
  formModel = {
    user: '',
    pass: '',
    repass: '',
    email: '',
    name: '',
    lastName: '',
    dni: '',
    rol: 'PROPIETARIO',
    floor: '',
    depto: '',
    size: '',
  };

  error = '';
  consorcios: Observable<any>;
  successSignUp = false;

  constructor(
    private consorcioService: ConsorcioService,
    private usuarioService: UsuarioService,
  ) { }

  ngOnInit() {
    this.obtenerTodosLosConsorcios();
  }

  onSubmit() {
    this.usuarioService.registrar(this.formModel).then(x => {
      if (x && x !== '') this.error = x.toString();
      if (!x || x === '') this.successSignUp = true;
    });
  }

  onRadioChange(e: MatRadioChange) {
    this.formModel.floor = '';
    this.formModel.size = '';
    this.formModel.depto = '';
  }

  obtenerTodosLosConsorcios() {
    this.consorcios = this.consorcioService.obtenerTodosLosConsorcios();
  }
}
