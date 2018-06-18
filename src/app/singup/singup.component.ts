import { Component, OnInit } from '@angular/core';
import { MatRadioChange } from '@angular/material';
import { Observable } from 'rxjs';
import { ConsorcioService } from './../services/consorcio.service';
import { RegistroLoginService } from './../services/registro-login.service';
import { UnidadService } from './../services/unidad.service';

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
    consorcio: '',
    unit: '',
  };

  error = '';
  consorcios: Observable<any>;
  unidades: Observable<any>;
  successSignUp = false;

  constructor(
    private consorcioService: ConsorcioService,
    private registroService: RegistroLoginService,
    private unidadService: UnidadService,
  ) { }

  ngOnInit() {
    this.obtenerTodosLosConsorcios();
  }

  onSubmit() {
    this.registroService.registrar(this.formModel).then(x => {
      if (x && x !== '') this.error = x.toString();
      if (!x || x === '') this.successSignUp = true;
    });
  }

  onRadioChange(e: MatRadioChange) {
    this.formModel.unit = '';
    this.formModel.consorcio = '';
    this.unidades = null;
  }

  onConsorcioChange(e) {
    this.traerUnidades(e.value);
  }

  obtenerTodosLosConsorcios() {
    this.consorcios = this.consorcioService.obtenerTodosLosConsorcios();
  }

  traerUnidades(consorcioId) {
    if (this.formModel.rol === 'PROPIETARIO')
      this.unidades = this.unidadService.traerUnidadesParaPropietarios(consorcioId);
      else
      this.unidades = this.unidadService.traerUnidadesParaInquilinos(consorcioId);
  }
}
