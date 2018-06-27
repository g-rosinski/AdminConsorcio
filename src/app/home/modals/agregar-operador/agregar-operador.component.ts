import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ReclamoService } from '../../../services/reclamo.service';

@Component({
  selector: 'app-agregar-operador',
  templateUrl: './agregar-operador.component.html',
  styles: [`
    .mat-card {
      background: #0D47A1 !important;
      color: white;
      width: 100%;
    }
  `]
})
export class AgregarOperadorComponent implements OnInit {
  email: string = null;
  get location() {
    return window.location.origin;
  }

  constructor(
    private dialogRef: MatDialogRef<AgregarOperadorComponent>
  ) { }

  ngOnInit() {

  }

  onNoClick(): void {
    this.dialogRef.close();
  }
}
