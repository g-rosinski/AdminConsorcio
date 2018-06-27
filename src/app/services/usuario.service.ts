import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {
  static BASE_URL = 'http://localhost/server/api/actions/usuario';

  usuario = null;

  constructor(
    public http: HttpClient,
  ) { }

  init(user: string) {
    return this.obtenerUsuarioFull(user).toPromise()
      .then(user => this.usuario = user);
  }

  obtenerUsuarioFull(user: string) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const params = new HttpParams().set('user', user);
    return this.http.get(UsuarioService.BASE_URL + '/obtenerUsuarioFull.php', { headers, params });
  }

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
}
