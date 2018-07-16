import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UnidadService {
  static BASE_URL = 'http://localhost/server/api/actions/unidad';

  constructor(
    public http: HttpClient,
  ) { }

  traerUnidadesParaPropietarios(unidadId: number): Observable<any> {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const params = new HttpParams().set('id_consorcio', unidadId.toString());
    return this.http.get(UnidadService.BASE_URL + '/traerUnidadesParaPropietarios.php', { headers, params });
  }

  traerUnidadesParaInquilinos(unidadId: number): Observable<any> {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const params = new HttpParams().set('id_consorcio', unidadId.toString());
    return this.http.get(UnidadService.BASE_URL + '/traerUnidadesParaInquilinos.php', { headers, params });
  }

  traerUnidadesConDuenioPorConsorcio(id) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const params = new HttpParams().set('id_consorcio', id);
    return this.http.get(UnidadService.BASE_URL + '/traerUnidadesPorConsorcio.php', { headers, params });
  }

  agregarUnidad(formModel): Promise<any> {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = new HttpParams()
      .set('piso', formModel.piso)
      .set('depto', formModel.departamento)
      .set('superficie', formModel.superficie)
      .set('nroUnidad', formModel.nroUnidad)
      .set('id_consorcio', formModel.consorcio);

    return this.http.post(UnidadService.BASE_URL + '/agregarUnidad.php', body.toString(), { headers: headers })
      .toPromise();
  }
}
