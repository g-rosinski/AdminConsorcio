import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  template: '<router-outlet></router-outlet>',
  styles: [`
      /deep/ .toast {
        width: auto !important;
      }
  `]
})
export class AppComponent {

}
