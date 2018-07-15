import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatDatepickerInputEvent } from '@angular/material';
import * as moment from 'moment';
import { GastoService } from '../../../services/gasto.service';
import { ToastrService } from 'ngx-toastr';

@Component({
    selector: 'app-agregar-pago',
    templateUrl: './agregar-pago.component.html',
    styles: [`
    .full {
        width: 100%;
    }

    .mat-card {
        background: #0D47A1 !important;
        color: white;
        width: 100%;
        margin-bottom: 15px;
    }
  `]
})
export class AgregarPagoComponent implements OnInit {

    ordenDePago: number;

    constructor(
        private gastoService: GastoService,
        private dialogRef: MatDialogRef<AgregarPagoComponent>,
        @Inject(MAT_DIALOG_DATA) public data,
        private toast: ToastrService,
    ) { }

    ngOnInit() {
    }

    onNoClick(): void {
        this.dialogRef.close();
    }

    onSubmit() {
        this.gastoService.realizarPago(this.ordenDePago, this.data.idGasto)
            .then(() => {
                this.onNoClick();
                this.toast.success('Pago realizado correctamente')
            });
    }
}
