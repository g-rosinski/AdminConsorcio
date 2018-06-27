import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReclamoService {
  static BASE_URL = 'http://localhost/server/api/actions/reclamo';

  constructor(
    public http: HttpClient,
  ) { }

  traerTodosLosReclamosPorUsuario(user: string): Observable<any> {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const params = new HttpParams().set('user', user);
    return this.http.get(ReclamoService.BASE_URL + '/verEstadoDeReclamosPorUsuario.php', { headers, params });
  }

  agregarReclamo(formModel, id) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = new HttpParams()
      .set('titulo', formModel.titulo)
      .set('id_unidad', id)
      .set('mensaje', formModel.mensaje);

    if (formModel.rol !== 'OPERADOR' || formModel.rol !== 'ADMINISTRADOR') {
      body = body.set('consorcio', formModel.consorcio);
      body = body.set('unit', formModel.unit);
    }

    return this.http.post(ReclamoService.BASE_URL + '/agregarReclamo.php', body.toString(), { headers: headers })
      .toPromise();
  }
}
