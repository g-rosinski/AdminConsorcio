import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class BarrioService {
    static BASE_URL = 'http://localhost/server/api/actions/barrio';

    constructor(
        public http: HttpClient,
    ) { }

    obtenerTodosLosBarrios(): Observable<any> {
        return this.http.get(BarrioService.BASE_URL + '/traerTodosLosBarrios.php');
    }
}
