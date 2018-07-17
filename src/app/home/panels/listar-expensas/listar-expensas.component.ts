import { Component, OnInit, Input } from '@angular/core';
import { ExpensaService } from '../../../services/expensas.service';
import { Observable } from '../../../../../node_modules/rxjs';
import { GastoService } from '../../../services/gasto.service';
import { VerExpensaComponent } from '../../modals/ver-expensa/ver-expensa.component';
import { MatDialog } from '../../../../../node_modules/@angular/material';

@Component({
  selector: 'app-listar-expensas',
  templateUrl: './listar-expensas.component.html',
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
export class ListarExpensasComponent implements OnInit {

  expensas: Observable<any>;
  @Input() usuario;

  constructor(
    private dialog: MatDialog,
    private expensaService: ExpensaService,
    private gastoService: GastoService
  ) { }

  ngOnInit() {
    this.expensas = this.expensaService.listarExpensasPorUnidad(this.usuario.id_unidad);
  }

  pagarConMercadoPago(expensa) {
    this.gastoService.generarMPBoton(expensa)
      .then((data: any) => window.location.href = data.url);
  }

  openVerExpensa(expensa): void {
    this.dialog.open(VerExpensaComponent, {
      width: '1000px',
      maxHeight: '650px',
      data: expensa,
    })
  }

}
