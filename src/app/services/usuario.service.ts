import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {
  static BASE_URL = 'http://localhost/server/api/actions/usuario';

  constructor(
    public http: HttpClient,
  ) { }


  obtenerUsuariosInactivos(): Observable<any> {
    return this.http.get(UsuarioService.BASE_URL + '/obtenerTodosLosUsuariosInactivos.php');
  }

  marcarUsuarioComoActivo(id): Promise<any> {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const body = new HttpParams()
      .set('id', id);

    return this.http.post(UsuarioService.BASE_URL + '/marcarComoActivo.php', body.toString(), { headers: headers })
      .toPromise();
  }

  registrar(formModel: any): Promise<any> {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const body = new HttpParams()
      .set('user', formModel.user.toLocaleLowerCase().trim())
      .set('pass', formModel.pass)
      .set('repass', formModel.repass)
      .set('name', formModel.name)
      .set('lastName', formModel.lastName)
      .set('email', formModel.email)
      .set('dni', formModel.dni.toString());

    return this.http.post(UsuarioService.BASE_URL + '/registrar.php', body.toString(), { headers: headers })
      .toPromise();

  }
}
