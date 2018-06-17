import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class RegistroLoginService {
    static BASE_URL = 'http://localhost/server/api/actions/loginRegistro';
    usuario = null;
    constructor(
        public http: HttpClient,
    ) { }

    loguear(formModel: any): Promise<any> {
        const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
        const body = new HttpParams()
            .set('user', formModel.user.toLocaleLowerCase().trim())
            .set('pass', formModel.pass)

        return this.http.post(RegistroLoginService.BASE_URL + '/loguear.php', body.toString(), { headers: headers }).toPromise();
    }

    logout(): Promise<any> {
        return this.http.get(RegistroLoginService.BASE_URL + '/logout.php')
            .toPromise();
    }

    obtenerSession(): Observable<any> {
        return this.http.get(RegistroLoginService.BASE_URL + '/obtenerSession.php')
            .map(x => {
                if (x) this.usuario = x;
                return x;
            });
    }

    registrar(formModel: any): Promise<any> {
        const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
        const body = new HttpParams()
            .set('user', formModel.user.toLocaleLowerCase().trim())
            .set('pass', formModel.pass)
            .set('repass', formModel.repass)
            .set('name', formModel.name)
            .set('lastName', formModel.lastName)
            .set('email', formModel.email)
            .set('consorcio', formModel.consorcio)
            .set('unit', formModel.unit)
            .set('rol', formModel.rol)
            .set('dni', formModel.dni.toString());

        return this.http.post(RegistroLoginService.BASE_URL + '/registrar.php', body.toString(), { headers: headers })
            .toPromise();
    }
}
