import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { MatRadioChange } from '@angular/material';
import { ToastrService } from 'ngx-toastr';
import { Observable } from 'rxjs';

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
    public http: HttpClient,
    private toastr: ToastrService
  ) { }

  ngOnInit() {
    this.obtenerTodosLosConsorcios();
  }

  onSubmit() {
    // this.toastr.error('Hello world!', 'Toastr fun!');
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const body = new HttpParams()
      .set('user', this.formModel.user.toLocaleLowerCase().trim())
      .set('pass', this.formModel.pass)
      .set('repass', this.formModel.repass)
      .set('name', this.formModel.name)
      .set('lastName', this.formModel.lastName)
      .set('email', this.formModel.email)
      .set('dni', this.formModel.dni.toString());

    return this.http.post('http://localhost/server/registrar.php', body.toString(), { headers: headers })
      .subscribe(x => {
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
    this.consorcios = this.http.get('http://localhost/server/consorcio.php');
  }
}
