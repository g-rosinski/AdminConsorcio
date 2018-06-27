import { Component, OnInit, Input } from '@angular/core';
import { ReclamoService } from '../../../services/reclamo.service';
import { MatDialog } from '@angular/material';
import { Observable } from 'rxjs/internal/Observable';
import { AgregarReclamoComponent } from '../../modals/agregar-reclamo/agregar-reclamo.component'

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
  isOpen = false;
  @Input() usuario;

  constructor(
    private dialog: MatDialog,
    private reclamoService: ReclamoService,
  ) { }

  ngOnInit() {
    // this.reclamos = this.reclamoService.traerTodosLosReclamosPorUsuario('ariel')
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
}
