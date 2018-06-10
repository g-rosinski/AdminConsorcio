import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  name = '';
  consorcio = '';
  countUsers = 0;

  ngOnInit() {
    this.http.get('http://localhost/server/usuario.php').subscribe((x: Array<any>) => this.countUsers = x.length);    
    this.http.get('http://localhost/server/propietario.php')
      .subscribe((x) => {
        this.name = x['name'];
        this.consorcio = x['consorcio'];
      });
  }

  constructor(
    public http: HttpClient
  ) { }
}
