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

    traerDetalleDeUnaExpensa(id) {
        const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
        const params = new HttpParams().set('idExpensa', id);
        return this.http.get(ExpensaService.BASE_URL + '/traerDatosDeExpensa.php', { headers, params });
    }

    controlarExpensasPorConsorcio(ids: any[]) {
        const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
        let body = new HttpParams()

        ids.forEach((id, index) => {
            body = body.append(`id_consorcio[${index}]`, id);
        });

        return this.http.post(ExpensaService.BASE_URL + '/controlarExpensasPorConsorcio.php', body.toString(), { headers: headers })
            .toPromise();
    }
}
