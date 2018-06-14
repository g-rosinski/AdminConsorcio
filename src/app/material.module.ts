import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MaterializeModule } from "angular2-materialize";
import { ToastrModule } from 'ngx-toastr';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {
  MatBadgeModule, MatExpansionModule, MatTableModule, MatButtonModule, MatCheckboxModule,
  MatCardModule, MatInputModule, MatIconModule, MatSelectModule, MatRadioModule
} from '@angular/material';


@NgModule({
  imports: [
    CommonModule,
    BrowserAnimationsModule,
    ToastrModule.forRoot(),
    MaterializeModule,
    MatExpansionModule,
    MatTableModule,
    MatSelectModule,
    MatBadgeModule,
    MatButtonModule,
    MatCheckboxModule,
    MatCardModule,
    MatInputModule,
    MatIconModule,
    MatRadioModule,
  ],
  declarations: []
})
export class MaterialModule { }
