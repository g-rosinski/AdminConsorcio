import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ConsorcioService {
  static BASE_URL = 'http://localhost/server/api/actions/consorcio';

  constructor(
    public http: HttpClient,
  ) { }

  obtenerTodosLosConsorcios(): Observable<any> {
    return this.http.get(ConsorcioService.BASE_URL + '/obtenerTodosLosConsorcios.php');
  }

  obtenerConsorciosConReclamos(): Observable<any> {
    return this.http.get(ConsorcioService.BASE_URL + '/obtenerConsorciosConReclamo.php');
  }

  obtenerConsorciosConGastos(): Observable<any> {
    return this.http.get(ConsorcioService.BASE_URL + '/obtenerConsorciosConGastos.php');
  }

  crearConsorcio(formModel) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = new HttpParams()
      .set('nombre', formModel.nombre)
      .set('cuit', formModel.cuit)
      .set('calle', formModel.calle)
      .set('altura', formModel.altura)
      .set('superficie', formModel.superficie)
      .set('id_barrio', formModel.id_barrio)
      .set('coordenadaLatitud', formModel.coordenadaLatitud)
      .set('coordenadaLongitud', formModel.coordenadaLongitud)
      .set('telefono', formModel.telefono);

    return this.http.post(ConsorcioService.BASE_URL + '/crearConsorcio.php', body.toString(), { headers: headers })
      .toPromise();
  }
}
