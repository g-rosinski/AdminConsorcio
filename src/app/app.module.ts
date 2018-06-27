import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { MaterialModule } from './material.module';
import { ToastrModule } from 'ngx-toastr';
import { AgmCoreModule } from '@agm/core';

import { AppComponent } from './app.component';
import { SingupComponent } from './singup/singup.component';
import { SinginComponent } from './singin/singin.component';
import { AppRoutingModule } from './app-routing.module';
import { HomeComponent } from './home/home.component';
import { ReviewUsersComponent } from './home/panels/review-users/review-users.component';
import { ListarConsorciosComponent } from './home/panels/listar-consorcios/listar-consorcios.component';
import { AgregarOperadorComponent } from './home/modals/agregar-operador.component'

import { UsuarioService } from './services/usuario.service';
import { ConsorcioService } from './services/consorcio.service';
import { RegistroLoginService } from './services/registro-login.service';
import { UnidadService } from './services/unidad.service';
import { MensajesComponent } from './home/panels/mensajes/mensajes.component';
import { ListarReclamosComponent } from './home/panels/listar-reclamos/listar-reclamos.component';
import { ListarExpensasComponent } from './home/panels/listar-expensas/listar-expensas.component';
import { FabButtonComponent } from './home/fab-button/fab-button.component';

@NgModule({
  declarations: [
    AppComponent,
    SingupComponent,
    SinginComponent,
    HomeComponent,
    ReviewUsersComponent,
    ListarConsorciosComponent,
    AgregarOperadorComponent,
    MensajesComponent,
    ListarReclamosComponent,
    ListarExpensasComponent,
    FabButtonComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    AppRoutingModule,
    HttpClientModule,
    MaterialModule,
    ToastrModule.forRoot(),
    AgmCoreModule.forRoot({
      apiKey: 'AIzaSyCh_kOIVIZ_jDmX4MEgMCTiQRVdsbR-Wdc'
    }),
  ],
  entryComponents: [AgregarOperadorComponent],
  providers: [UsuarioService, ConsorcioService, RegistroLoginService, UnidadService],
  bootstrap: [AppComponent]
})
export class AppModule { }
