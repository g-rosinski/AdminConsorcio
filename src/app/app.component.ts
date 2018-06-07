import { Component } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  formModel = { user: '', pass: '' };

  constructor(
    public http: HttpClient
  ) { }

  post() {
    let json = JSON.stringify({ name: 'julian' });

    //El backend recogerá un parametro json
    // let params = "json=" + json;
    const body = new HttpParams()
      .set(`name`, 'aaaaaaaaaaa');
    const lala = 'foo';
    //Establecemos cabeceras
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this.http.post('http://localhost/index.php', body.toString(), { headers: headers })
      .subscribe(x => console.log(x));
  }


  onSubmit() {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const body = new HttpParams()
      .set('user', this.formModel.user)
      .set('pass', this.formModel.pass);
    return this.http.post('http://localhost/index.php', body.toString(), { headers: headers })
      .subscribe(x => console.log(x));
  }
}
