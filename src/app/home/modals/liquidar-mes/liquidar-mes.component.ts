import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatDatepickerInputEvent } from '@angular/material';
import * as moment from 'moment';
import { GastoService } from '../../../services/gasto.service';
import { ToastrService } from 'ngx-toastr';

@Component({
    selector: 'app-liquidar-mes',
    templateUrl: './liquidar-mes.component.html',
    styles: [`
    .full {
        width: 100%;
    }

    ul {
        list-style-type: none;
    }

    .mat-card:not(#errores) {
        background: #0D47A1 !important;
        color: white;
        width: 100%;
    }
  `]
})
export class LiquidarMesComponent implements OnInit {

    formModel = {
        vencimiento: '',
        consorcios: [],
    };

    errores = [];

    constructor(
        private gastoService: GastoService,
        private dialogRef: MatDialogRef<LiquidarMesComponent>,
        @Inject(MAT_DIALOG_DATA) public data,
        private toast: ToastrService,
    ) { }

    ngOnInit() {
        this.formModel.consorcios = this.data.consorcios;
    }

    onNoClick(): void {
        this.dialogRef.close();
    }

    dateChange(event: MatDatepickerInputEvent<Date>) {
        this.formModel.vencimiento = moment(event.value).format('YYYY-MM-DD');
    }

    onSubmit() {
        if (this.formModel.consorcios.length > 1)
            this.toast.warning('Este proceso puede durar varios segundos.');
        this.gastoService.liquidarMesPorConsorcio(this.formModel)
            .then((e: any[]) => {
                if (e.length) {
                    this.errores = e;
                }
                else {
                    this.onNoClick();
                    this.toast.success('Consorcio liquidado correctamente.')
                }
            });
    }
}
