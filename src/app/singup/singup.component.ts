import { Component, OnInit } from '@angular/core';
import { MatRadioChange } from '@angular/material';
import { ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs';
import { ConsorcioService } from './../services/consorcio.service';
import { RegistroLoginService } from './../services/registro-login.service';
import { UnidadService } from './../services/unidad.service';
import 'rxjs/add/operator/filter';

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
  emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  consorcios: Observable<any>;
  unidades: Observable<any>;
  successSignUp = false;
  isSignupOperator = false;

  constructor(
    private consorcioService: ConsorcioService,
    private registroService: RegistroLoginService,
    private unidadService: UnidadService,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.isSignupOperator = false;
    this.obtenerTodosLosConsorcios();
    this.route.queryParams
      .filter(params => params.operator)
      .subscribe(params => {
        if (params.operator !== '' && this.emailRegex.test(params.operator)) {
          this.formModel.email = params.operator;
          this.formModel.rol = 'OPERADOR'
          this.isSignupOperator = true;
        }
      });
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
