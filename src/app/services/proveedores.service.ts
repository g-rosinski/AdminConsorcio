import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProveedorService {
  static BASE_URL = 'http://localhost/server/api/actions/proveedor';

  constructor(
    public http: HttpClient,
  ) { }

  obtenerTodosLosProveedores(): Observable<any> {
    return this.http.get(ProveedorService.BASE_URL + '/obtenerTodosLosProveedores.php');
  }
}
