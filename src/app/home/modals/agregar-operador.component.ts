import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
    selector: 'app-agregar-operador',
    templateUrl: 'agregar-operador.component.html',
})
export class AgregarOperadorComponent {

    urlLocation = window.location.origin;

    constructor(
        private dialogRef: MatDialogRef<AgregarOperadorComponent>,
        @Inject(MAT_DIALOG_DATA) public data: any
    ) { }

    onNoClick(): void {
        this.dialogRef.close();
    }

}