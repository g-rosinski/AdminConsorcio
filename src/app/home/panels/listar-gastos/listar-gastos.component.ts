import { Component, OnInit, Input } from '@angular/core';
import { ReclamoService } from '../../../services/reclamo.service';
import { MatDialog, MatSelectChange } from '@angular/material';
import { Observable } from 'rxjs/internal/Observable';
import { AgregarReclamoComponent } from '../../modals/agregar-reclamo/agregar-reclamo.component'
import { ConsorcioService } from '../../../services/consorcio.service';
import { AgregarGastoComponent } from '../../modals/agregar-gasto/agregar-gasto.component';
import { GastoService } from '../../../services/gasto.service';

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
  isOpen = false;
  @Input() usuario;

  constructor(
    private dialog: MatDialog,
    private consorcioService: ConsorcioService,
    private gastoService: GastoService,
  ) { }

  ngOnInit() {
    // if (this.usuario.id_rol <= 2) {
      this.consorcios = this.consorcioService.obtenerConsorciosConGastos();
    // } else {
    //   this.reclamos = this.reclamoService.traerTodosLosReclamosPorUsuario(this.usuario.user)
    // }
  }

  openDialog(): void {
    this.dialog.open(AgregarReclamoComponent, {
      width: '500px',
      data: { usuario: this.usuario },
    });
  }

  onOpenClosePanel() {
    this.isOpen = !this.isOpen;
  }

  onConsorcioChange(e: MatSelectChange) {
    // alert(e.value);
    this.gastos = this.gastoService.obtenerGastoPorConsorcio(e.value);
  }

//   generarGasto(reclamo): void {
//     this.dialog.open(AgregarGastoComponent,
//       {
//         width: '500px',
//         data: {usuario: this.usuario, reclamo},
//       });
//   }
}
