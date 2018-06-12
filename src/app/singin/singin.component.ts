import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

@Component({
  selector: 'app-singin',
  templateUrl: './singin.component.html',
  styleUrls: ['./singin.component.css']
})
export class SinginComponent {

  formModel = { user: '', pass: '' };

  constructor(
    public http: HttpClient
  ) { }

  onSubmit() {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const body = new HttpParams()
      .set('user', this.formModel.user)
      .set('pass', this.formModel.pass);
    return this.http.post('http://localhost/server/test.php', body.toString(), { headers: headers })
      .subscribe(x => console.log(x));
  }

}
