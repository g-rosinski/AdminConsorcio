import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { MaterializeModule } from "angular2-materialize";
import { ToastrModule } from 'ngx-toastr';


import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatBadgeModule, MatExpansionModule, MatTableModule, MatButtonModule, MatCheckboxModule, MatCardModule, MatInputModule, MatIconModule, MatSelectModule, MatRadioModule } from '@angular/material';
import { SingupComponent } from './singup/singup.component';
import { SinginComponent } from './singin/singin.component';
import { AppRoutingModule } from './app-routing.module';
import { HomeComponent } from './home/home.component';
import { ReviewUsersComponent } from './home/review-users/review-users.component';

import { UsuarioService } from './services/usuario.service';

@NgModule({
  declarations: [
    AppComponent,
    SingupComponent,
    SinginComponent,
    HomeComponent,
    ReviewUsersComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    ToastrModule.forRoot(),
    HttpClientModule,
    BrowserAnimationsModule,
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
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
