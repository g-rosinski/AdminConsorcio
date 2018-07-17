import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ExpensaService } from '../../../services/expensas.service';
import * as jspdf from 'jspdf';
import html2canvas from 'html2canvas';

@Component({
    selector: 'app-ver-expensa',
    templateUrl: './ver-expensa.component.html',
    styleUrls: ['./ver-expensa.component.css']
})
export class VerExpensaComponent implements OnInit {
    e;
    gastos = [];
    loaded = false;
    objectKeys = Object.keys;

    constructor(
        public dialogRef: MatDialogRef<VerExpensaComponent>,
        @Inject(MAT_DIALOG_DATA) public data,
        private expensaService: ExpensaService,
    ) { }

    ngOnInit() {
        // console.log(this.data);
        this.expensaService.traerDetalleDeUnaExpensa(this.data.idExpensa)
            .subscribe((x: any) => {
                // this.e = x
                this.e = x;
                Object.keys(x.gastos).map(key => {
                    const foo = { [key]: x.gastos[key] }
                    this.gastos.push(foo);
                });
                console.log(this.gastos);
                console.log(this.e);
                this.loaded = true;
            });
    }

    export() {
        html2canvas(document.getElementById('pdfContent'))
            .then(canvas => {
                const imgWidth = 190;
                const imgHeight = canvas.height * imgWidth / canvas.width;
                const contentDataURL = canvas.toDataURL('image/png')

                let pdf = new jspdf('p', 'mm', 'a4');
                pdf.addImage(contentDataURL, 'PNG', 10, 100, imgWidth, imgHeight)
                pdf.save('expensa.pdf');
            });
    }

    sumar(val: any[]) {
        let total = 0;
        val.forEach(x => total += x.totalGasto)
        return '$' + total;
    }

    sumargrantotal(val: any[]) {
        let total = 0;

        Object.keys(val).map(key => {
            val[key].forEach(x => total += x.totalGasto);
        });

        return '$' + total;
    }

}
