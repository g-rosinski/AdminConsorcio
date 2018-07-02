import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ReclamoService } from '../../../services/reclamo.service';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-agregar-reclamo',
  templateUrl: './agregar-reclamo.component.html',
  styleUrls: ['./agregar-reclamo.component.css']
})
export class AgregarReclamoComponent implements OnInit {

  formModel = {
    titulo: '',
    mensaje: '',
  };

  constructor(
    private dialogRef: MatDialogRef<AgregarReclamoComponent>,
    @Inject(MAT_DIALOG_DATA) public usuario,
    private reclamoService: ReclamoService,
    private toast: ToastrService,
  ) { }

  ngOnInit() {
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  onSubmit() {
    if (!this.usuario.usuario.id_unidad) this.usuario.usuario.id_unidad = '';
    this.reclamoService.agregarReclamo(this.formModel, this.usuario.usuario.id_unidad)
      .then(() => {
        this.toast.info('Reclamo agregado correctamente.');
        this.dialogRef.close();
      });
  }

}
