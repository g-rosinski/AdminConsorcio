import { Component, OnInit, Input } from '@angular/core';
import { MatDialog, MatSelectChange } from '@angular/material';
import { Observable } from 'rxjs/internal/Observable';
import { ConsorcioService } from '../../../services/consorcio.service';
import { GastoService } from '../../../services/gasto.service';
import { AgregarPagoComponent } from '../../modals/agregar-pago/agregar-pago.component';

@Component({
  selector: 'app-listar-gastos',
  templateUrl: './listar-gastos.component.html',
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
export class ListarGastosComponent implements OnInit {
  consorcios: Observable<any>;
  gastos: Observable<any>;
  consorcioActual = 0;
  isOpen = false;
  @Input() usuario;

  constructor(
    private dialog: MatDialog,
    private consorcioService: ConsorcioService,
    private gastoService: GastoService,
  ) { }

  ngOnInit() {
    this.consorcios = this.consorcioService.obtenerConsorciosConGastos();
  }

  openAgregarPago(gasto): void {
    this.dialog.open(AgregarPagoComponent, {
      width: '500px',
      data: gasto,
    }).afterClosed()
      .subscribe(() => {
        this.gastos = this.gastoService.obtenerGastoPorConsorcio(this.consorcioActual);
      });
  }

  onOpenClosePanel() {
    this.isOpen = !this.isOpen;
  }

  onConsorcioChange(e: MatSelectChange) {
    this.consorcioActual = e.value;
    this.gastos = this.gastoService.obtenerGastoPorConsorcio(this.consorcioActual);
  }
}
