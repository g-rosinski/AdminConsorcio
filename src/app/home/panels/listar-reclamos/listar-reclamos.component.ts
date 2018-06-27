import { Component, OnInit } from '@angular/core';

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
`]
})
export class ListarReclamosComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
