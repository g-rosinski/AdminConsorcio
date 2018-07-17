import { Component, OnInit, Input } from '@angular/core';
import { MatDialog, MatSelectChange } from '@angular/material';
import { Observable } from 'rxjs/internal/Observable';
import { ConsorcioService } from '../../../services/consorcio.service';
import { GastoService } from '../../../services/gasto.service';
import { AgregarPagoComponent } from '../../modals/agregar-pago/agregar-pago.component';

@Component({
    selector: 'app-listar-gastos-historico',
    templateUrl: './listar-gastos-historico.component.html',
    styles: [`
    :host /deep/ .mat-badge-content{
      margin-bottom: 8px;
    }
    
    .mat-expansion-panel-header-description {
      justify-content: flex-end;
    }

    .table thead th {
      border-top: 0;
    }
  
    .table th, .table td {
      font-size: 13px;
      /* padding: 0.75rem 0; */
      vertical-align: middle;
      text-align: center;
      text-transform: capitalize;
    }
`]
})
export class ListarGastosHistoricosComponent implements OnInit {
    @Input() usuario;
    gastos: Observable<any>;
    periodos: Observable<any>;
    consorcios: Observable<any>;

    constructor(
        private dialog: MatDialog,
        private gastoService: GastoService,
        private consorcioService: ConsorcioService,
    ) { }

    ngOnInit() {
        this.consorcios = this.consorcioService.obtenerTodosLosConsorcios();
    }

    onConsorcioChange(e: MatSelectChange) {
        this.periodos = this.gastoService.listarPeriodosLiquidados(e.value);
    }

    onPeriodoChange(e: MatSelectChange) {
        this.gastos = this.gastoService.listarGastosHistoricosPorMes(e.value);
    }
}
