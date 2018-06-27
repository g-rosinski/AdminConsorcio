import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ReclamoService } from '../../../services/reclamo.service';
@Component({
  selector: 'app-ver-consorcio',
  templateUrl: './ver-consorcio.component.html',
  styleUrls: ['./ver-consorcio.component.css']
})
export class VerConsorcioComponent implements OnInit {
  zoom = 15;

  constructor(
    public dialogRef: MatDialogRef<VerConsorcioComponent>,
    @Inject(MAT_DIALOG_DATA) public consorcio,
    private reclamoService: ReclamoService,
  ) { }

  ngOnInit() {
  }

}
