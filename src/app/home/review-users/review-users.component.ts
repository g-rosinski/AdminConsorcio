import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { ToastrService } from 'ngx-toastr';
import { UsuarioService } from '../../services/usuario.service';

@Component({
  selector: 'app-review-users',
  templateUrl: './review-users.component.html',
  styleUrls: ['./review-users.component.css']
})
export class ReviewUsersComponent implements OnInit {
  constructor(
    private toast: ToastrService,
    private usuarioServ: UsuarioService,
  ) { }

  usuarios: Observable<any>;

  ngOnInit() {
    this.obtenerUsuariosInactivos();
  }

  obtenerUsuariosInactivos() {
    this.usuarios = this.usuarioServ.obtenerUsuariosInactivos();
  }

  marcarUsuarioComoActivo(id) {
    this.usuarioServ.marcarUsuarioComoActivo(id).then(() => {
      this.toast.success('El usuario ha sido activado correctamente');
      this.obtenerUsuariosInactivos()
    });
  }
}
