import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class ExpensaService {
    static BASE_URL = 'http://localhost/server/api/actions/expensa';

    constructor(
        public http: HttpClient,
    ) { }

    listarExpensasPorUnidad(idUnidad): Observable<any> {
        const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
        const params = new HttpParams().set('idUnidad', idUnidad);
        return this.http.get(ExpensaService.BASE_URL + '/listarExpensasPorUnidad.php', { headers, params });
    }
}
