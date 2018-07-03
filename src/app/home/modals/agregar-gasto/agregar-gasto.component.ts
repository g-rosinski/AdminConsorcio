import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ReclamoService } from '../../../services/reclamo.service';
import { ToastrService } from 'ngx-toastr';
import { ProveedorService } from '../../../services/proveedores.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-agregar-gasto',
  templateUrl: './agregar-gasto.component.html',
  styleUrls: ['./agregar-gasto.component.css']
})
export class AgregarGastoComponent implements OnInit {
  formModel = {
    mensaje: '',
    operador: '',
    proveedor: '',
    motivo: '',
    importe: '',
  };

  proveedores: Observable<any>;

  constructor(
    private dialogRef: MatDialogRef<AgregarGastoComponent>,
    @Inject(MAT_DIALOG_DATA) public data,
    private toast: ToastrService,
    private proveedorService: ProveedorService
  ) { }

  ngOnInit() {
    this.formModel.operador = this.data.usuario.user;
    this.formModel.mensaje = this.data.reclamo.mensaje;
    this.proveedores = this.proveedorService.obtenerTodosLosProveedores();
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  onSubmit() {
    // if (!this.usuario.usuario.id_unidad) this.usuario.usuario.id_unidad = '';
    // this.reclamoService.agregarReclamo(this.formModel, this.usuario.usuario.id_unidad)
    //   .then(() => {
    //     this.toast.info('Reclamo agregado correctamente.');
    //     this.dialogRef.close();
    //   });
  }

}
