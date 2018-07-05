import { Injectable, Injector } from '@angular/core';
import { HttpEvent, HttpInterceptor, HttpHandler, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs/Rx';
import 'rxjs/add/observable/throw'
import 'rxjs/add/operator/catch';
import { ToastrService } from 'ngx-toastr';

@Injectable()
export class MyHttpInterceptor implements HttpInterceptor {

    constructor(
        private toast: ToastrService
    ) { }

    intercept(req: HttpRequest<any>, next: HttpHandler):
        Observable<HttpEvent<any>> {
        return next.handle(req)
            .catch((e) => {
                console.log(e);
                this.toast.error('Ops! ha ocurrido un error, por favor intente mas tarde');
                return Observable.throw(e);
            });
    }

}