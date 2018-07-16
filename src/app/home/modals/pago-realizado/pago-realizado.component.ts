import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ReclamoService } from '../../../services/reclamo.service';

@Component({
  selector: 'app-pago-realizado',
  templateUrl: './pago-realizado.component.html',
  styles: [`
    .mat-card {
      background: #0D47A1 !important;
      color: white;
      width: 100%;
    }
  `]
})
export class PagoRealizadoComponent implements OnInit {

  constructor(
    private dialogRef: MatDialogRef<PagoRealizadoComponent>,
    @Inject(MAT_DIALOG_DATA) public modo,
  ) { }

  ngOnInit() {

  }

  onNoClick(): void {
    this.dialogRef.close();
  }
}
