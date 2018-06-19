import { Component, OnInit } from '@angular/core';
import { ConsorcioService } from '../../services/consorcio.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-listar-consorcios',
  templateUrl: './listar-consorcios.component.html',
  styleUrls: ['./listar-consorcios.component.css']
})
export class ListarConsorciosComponent implements OnInit {

  constructor(private consorcioService: ConsorcioService) { }

  ngOnInit() {
  }
}