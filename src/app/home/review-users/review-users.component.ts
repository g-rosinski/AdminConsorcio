import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-review-users',
  templateUrl: './review-users.component.html',
  styleUrls: ['./review-users.component.css']
})
export class ReviewUsersComponent implements OnInit {
  constructor(
    public http: HttpClient,
  ) { }

  usuarios: Observable<any>;

  ngOnInit() {
    this.obtenerUsuariosInactivos();
  }

  obtenerUsuariosInactivos() {
    this.usuarios = this.http.get('http://localhost/server/usuario.php');
  }

  marcarUsuarioComoActivo(id) {
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const body = new HttpParams()
      .set('id', id);

    this.http.post('http://localhost/server/marcarComoActivo.php', body.toString(), { headers: headers })
      .subscribe(() => this.obtenerUsuariosInactivos());
  }
}
