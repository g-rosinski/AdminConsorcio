import { Component, OnInit } from '@angular/core';
import { ConsorcioService } from '../../../services/consorcio.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-listar-consorcios',
  templateUrl: './listar-consorcios.component.html',
  styles: [`
    :host /deep/ .mat-badge-content{
      margin-bottom: 8px;
    }
    
    .mat-expansion-panel-header-description {
      justify-content: flex-end;
    }
`]
})
export class ListarConsorciosComponent implements OnInit {

  constructor(private consorcioService: ConsorcioService) { }

  ngOnInit() {
  }
}