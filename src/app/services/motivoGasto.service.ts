import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MotivoGastoService {
  static BASE_URL = 'http://localhost/server/api/actions/motivogasto';

  constructor(
    public http: HttpClient,
  ) { }

  obtenerTodosLosMotivos(): Observable<any> {
    return this.http.get(MotivoGastoService.BASE_URL + '/obtenerTodosLosMotivoGasto.php');
  }
}
