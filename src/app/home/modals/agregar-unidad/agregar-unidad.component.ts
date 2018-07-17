import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material';
import { Observable } from 'rxjs';
import { ConsorcioService } from '../../../services/consorcio.service';
import { UnidadService } from '../../../services/unidad.service';
import { ToastrService } from '../../../../../node_modules/ngx-toastr';

@Component({
    selector: 'app-agregar-unidad',
    templateUrl: './agregar-unidad.component.html',
    styles: [`
        .full-width{
            width: 100%;
        }
    `]
})
export class AgregarUnidadComponent implements OnInit {
    formModel = {
        piso: '',
        departamento: '',
        superficie: '',
        nroUnidad: '',
        consorcio: '',
    };

    consorcios: Observable<any>;

    constructor(
        private dialogRef: MatDialogRef<AgregarUnidadComponent>,
        private consorcioService: ConsorcioService,
        private unidadService: UnidadService,
        private toast: ToastrService,
    ) { }

    ngOnInit() {
        this.consorcios = this.consorcioService.obtenerTodosLosConsorcios();
    }

    onNoClick(): void {
        this.dialogRef.close();
    }

    onSubmit() {
        this.unidadService.agregarUnidad(this.formModel)
            .then(() => {
                this.toast.success('Unidad agregada correctamente');
                this.onNoClick();
            })
    }

}
