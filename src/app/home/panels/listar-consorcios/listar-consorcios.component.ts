import { Component, OnInit } from '@angular/core';
import { ConsorcioService } from '../../../services/consorcio.service';
import { Observable } from 'rxjs';
import { VerConsorcioComponent } from '../../modals/ver-consorcio/ver-consorcio.component';
import { MatDialog } from '@angular/material';
import { LiquidarMesComponent } from '../../modals/liquidar-mes/liquidar-mes.component';
import { ExpensaService } from '../../../services/expensas.service';
import { ToastrService } from '../../../../../node_modules/ngx-toastr';
@Component({
  selector: 'app-listar-consorcios',
  templateUrl: './listar-consorcios.component.html',
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
    
    .mat-button {
      line-height: 0;
    }
`]
})
export class ListarConsorciosComponent implements OnInit {
  consorcios = [];

  constructor(
    private dialog: MatDialog,
    private consorcioService: ConsorcioService,
    private expensaService: ExpensaService,
    private toast: ToastrService
  ) { }

  ngOnInit() {
    this.consorcioService.obtenerTodosLosConsorcios()
      .subscribe(consorcios => this.consorcios = consorcios);
  }

  openVerConsorcio(consorcio): void {
    this.dialog.open(VerConsorcioComponent,
      {
        width: '1000px',
        data: { consorcio },
      });
  }

  openLiquidar(consorcio): void {
    this.dialog.open(LiquidarMesComponent,
      {
        width: '400px',
        data: { consorcios: consorcio },
      });
  }

  liquidarTodos() {
    this.openLiquidar(this.consorcios);
  }

  controlarConsorcio(consorcio) {
    this.expensaService.controlarExpensasPorConsorcio([consorcio.id_consorcio])
      .then(() => this.toast.success('Consorcio actualizado correctamente'))
  }

  controlarVencimientoConsorcio(consorcio) {
    this.expensaService.controlarExpensasVencidas([consorcio.id_consorcio])
      .then(()=> this.toast.success('Los vencimientos se han actualizado correctamente'));
  }
}
