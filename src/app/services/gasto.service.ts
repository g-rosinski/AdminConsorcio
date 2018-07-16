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
      .set('importe', formModel.importe)
      .set('id_proveedor', formModel.proveedor)
      .set('id_motivo_gasto', formModel.motivo)
      .set('operador', formModel.operador)
      .set('id_consorcio', formModel.id_consorcio)
      .set('id_reclamo', formModel.id_reclamo);

    return this.http.post(GastoService.BASE_URL + '/nuevoGasto.php', body.toString(), { headers: headers })
      .toPromise();
  }

  obtenerGastoPorConsorcio(id: any) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const params = new HttpParams().set('id_consorcio', id);
    return this.http.get(GastoService.BASE_URL + '/listarGastosPorConsorcio.php', { headers, params });
  }

  liquidarMesPorConsorcio(formModel) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = new HttpParams()
      .set('vencimiento', formModel.vencimiento);

    formModel.consorcios.forEach((consorcio, index) => {
      body = body.append(`id_consorcio[${index}]`, consorcio.id_consorcio);
    });

    return this.http.post(GastoService.BASE_URL + '/liquidarMesPorConsorcio.php', body.toString(), { headers: headers })
      .toPromise();
  }

  realizarPago(orderPago, idGasto) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = new HttpParams()
      .set('nro_orden_pago', orderPago)
      .set('id_gasto', idGasto);

    return this.http.post(GastoService.BASE_URL + '/realizarPago.php', body.toString(), { headers: headers })
      .toPromise();
  }

  generarMPBoton() {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let params = new HttpParams()
      .set('id', '0')
      .set('titulo', 'Liquidacion del mes de enero')
      .set('importe', '1000.77')
      .set('success', 'localhost/home')
      .set('fail', 'localhost/home')
      .set('pend', 'localhost/home');      

    return this.http.get('http://localhost/server/api/actions/testMP.php',{ headers, params })
      .toPromise();
  }
}
