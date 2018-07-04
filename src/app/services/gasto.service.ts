import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class GastoService {
  static BASE_URL = 'http://localhost/server/api/actions/gasto';

  constructor(
    public http: HttpClient,
  ) { }

  agregarGasto(formModel) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = new HttpParams()
      .set('descripcion', formModel.mensaje)
      .set('import', formModel.importe)
      .set('id_proveedor', formModel.proveedor)
      .set('id_motivo_gasto', formModel.motivo)
      .set('operador', formModel.operador)
      .set('id_reclamo', formModel.id_reclamo);

    return this.http.post(GastoService.BASE_URL + '/nuevoGasto.php', body.toString(), { headers: headers })
      .toPromise();
  }
}
