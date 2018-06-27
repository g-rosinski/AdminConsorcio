import { Component, OnInit } from '@angular/core';
import { ConsorcioService } from '../../../services/consorcio.service';
import { Observable } from 'rxjs';
import { VerConsorcioComponent } from '../../modals/ver-consorcio/ver-consorcio.component';
import { MatDialog } from '@angular/material';
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
`]
})
export class ListarConsorciosComponent implements OnInit {
  consorcios: Observable<any>;

  constructor(
    private dialog: MatDialog,
    private consorcioService: ConsorcioService,
  ) { }

  ngOnInit() {
    this.consorcios = this.consorcioService.obtenerTodosLosConsorcios();
  }

  openDialog(consorcio): void {
    this.dialog.open(VerConsorcioComponent,
      {
        width: '1000px',
        data: { consorcio },
      });
  }

}
