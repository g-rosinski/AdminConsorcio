import { Component, OnInit, Input } from '@angular/core';
import { ReclamoService } from '../../../services/reclamo.service';
import { MatDialog, MatSelectChange } from '@angular/material';
import { Observable } from 'rxjs/internal/Observable';
import { AgregarReclamoComponent } from '../../modals/agregar-reclamo/agregar-reclamo.component'
import { ConsorcioService } from '../../../services/consorcio.service';
import { AgregarGastoComponent } from '../../modals/agregar-gasto/agregar-gasto.component';

@Component({
  selector: 'app-listar-reclamos',
  templateUrl: './listar-reclamos.component.html',
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
export class ListarReclamosComponent implements OnInit {
  reclamos: Observable<any>;
  consorcios: Observable<any>;
  consorcioActual = 0;
  @Input() usuario;

  constructor(
    private dialog: MatDialog,
    private reclamoService: ReclamoService,
    private consorcioService: ConsorcioService
  ) { }

  ngOnInit() {
    if (this.usuario.id_rol <= 2) {
      this.consorcios = this.consorcioService.obtenerConsorciosConReclamos();
      if (this.consorcioActual)
        this.reclamos = this.reclamoService.traerTodosLosReclamosPorConsorcio(this.consorcioActual.toString());
    } else {
      this.reclamos = this.reclamoService.traerTodosLosReclamosPorUsuario(this.usuario.user)
    }
  }

  openDialog(): void {
    this.dialog.open(AgregarReclamoComponent, {
      width: '500px',
      data: { usuario: this.usuario },
    }).afterClosed().subscribe(this.onPopupClosed);
  }

  onConsorcioChange(e: MatSelectChange) {
    this.consorcioActual = e.value;
    this.reclamos = this.reclamoService.traerTodosLosReclamosPorConsorcio(e.value);
  }

  onPopupClosed = () => {
    this.ngOnInit();
  }

  generarGasto(reclamo): void {
    this.dialog.open(AgregarGastoComponent,
      {
        width: '500px',
        data: { usuario: this.usuario, reclamo },
      }).afterClosed().subscribe(this.onPopupClosed);
  }
}
