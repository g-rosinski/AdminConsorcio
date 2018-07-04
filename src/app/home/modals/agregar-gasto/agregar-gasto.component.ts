import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ReclamoService } from '../../../services/reclamo.service';
import { ToastrService } from 'ngx-toastr';
import { ProveedorService } from '../../../services/proveedores.service';
import { Observable } from 'rxjs';
import { MotivoGastoService } from '../../../services/motivoGasto.service';
import { GastoService } from '../../../services/gasto.service';

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
    id_reclamo: '',
  };

  proveedores: Observable<any>;
  motivos: Observable<any>;

  constructor(
    private dialogRef: MatDialogRef<AgregarGastoComponent>,
    @Inject(MAT_DIALOG_DATA) public data,
    private toast: ToastrService,
    private proveedorService: ProveedorService,
    private motivoService: MotivoGastoService,
    private gastoService: GastoService
  ) { }

  ngOnInit() {
    this.formModel.operador = this.data.usuario.user;
    this.formModel.id_reclamo = this.data.reclamo.nroReclamo;
    this.formModel.mensaje = this.data.reclamo.mensaje;
    this.proveedores = this.proveedorService.obtenerTodosLosProveedores();
    this.motivos = this.motivoService.obtenerTodosLosMotivos();
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  onSubmit() {
    this.gastoService.agregarGasto(this.formModel).then(()=> this.onNoClick())
  }

}
