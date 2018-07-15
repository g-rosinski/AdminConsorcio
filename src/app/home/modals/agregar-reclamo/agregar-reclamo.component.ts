import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatSelectChange } from '@angular/material';
import { ReclamoService } from '../../../services/reclamo.service';
import { ToastrService } from 'ngx-toastr';
import { ConsorcioService } from '../../../services/consorcio.service';
import { Observable } from 'rxjs';
import { UnidadService } from '../../../services/unidad.service';

@Component({
  selector: 'app-agregar-reclamo',
  templateUrl: './agregar-reclamo.component.html',
  styleUrls: ['./agregar-reclamo.component.css']
})
export class AgregarReclamoComponent implements OnInit {

  consorcios: Observable<any>;
  unidades: Observable<any>;

  formModel = {
    titulo: '',
    mensaje: '',
    id_unidad: '',
  };

  constructor(
    private dialogRef: MatDialogRef<AgregarReclamoComponent>,
    @Inject(MAT_DIALOG_DATA) public usuario,
    private reclamoService: ReclamoService,
    private toast: ToastrService,
    private consorcioService: ConsorcioService,
    private unidadService: UnidadService,
  ) { }

  ngOnInit() {
    this.consorcios = this.consorcioService.obtenerTodosLosConsorcios();
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  onConsorcioChange(e: MatSelectChange) {
    this.unidades = this.unidadService.traerUnidadesConDuenioPorConsorcio(e.value);
  }

  onSubmit() {
    if (this.usuario.usuario.id_rol > 2)
      this.formModel.id_unidad = this.usuario.usuario.id_unidad;
    this.reclamoService.agregarReclamo(this.formModel, this.formModel.id_unidad)
      .then(() => {
        this.toast.success('Reclamo agregado correctamente.');
        this.dialogRef.close();
      });
  }

}
