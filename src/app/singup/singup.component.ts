import { Component } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-singup',
  templateUrl: './singup.component.html',
  styleUrls: ['./singup.component.css']
})
export class SingupComponent {
  formModel = {
    user: '',
    pass: '',
    repass: '',
    email: '',
    name: '',
    lastName: '',
    dni: ''
  };
  constructor(
    public http: HttpClient,
    private toastr: ToastrService
  ) { }

  onSubmit() {
    this.toastr.error('Hello world!', 'Toastr fun!');
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const body = new HttpParams()
      .set('user', this.formModel.user)
      .set('pass', this.formModel.pass)
      .set('repass', this.formModel.repass)
      .set('name', this.formModel.name)
      .set('lastName', this.formModel.lastName)
      .set('email', this.formModel.email)
      .set('dni', this.formModel.dni.toString());

    return this.http.post('http://localhost/server/registrar.php', body.toString(), { headers: headers })
      .subscribe(x => console.log(x));
  }
}
