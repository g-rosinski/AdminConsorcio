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
}
