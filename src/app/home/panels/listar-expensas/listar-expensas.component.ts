import { Component, OnInit } from '@angular/core';

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
`]
})
export class ListarExpensasComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
