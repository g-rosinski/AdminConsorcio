import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
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
import { AgregarOperadorComponent } from './home/modals/agregar-operador/agregar-operador.component';
import { UnidadService } from './services/unidad.service';
import { MensajesComponent } from './home/panels/mensajes/mensajes.component';
import { ListarReclamosComponent } from './home/panels/listar-reclamos/listar-reclamos.component';
import { ListarExpensasComponent } from './home/panels/listar-expensas/listar-expensas.component';
import { FabButtonComponent } from './home/fab-button/fab-button.component';
import { AgregarReclamoComponent } from './home/modals/agregar-reclamo/agregar-reclamo.component';
import { VerConsorcioComponent } from './home/modals/ver-consorcio/ver-consorcio.component';
import { AgregarGastoComponent } from './home/modals/agregar-gasto/agregar-gasto.component';

import { UsuarioService } from './services/usuario.service';
import { ConsorcioService } from './services/consorcio.service';
import { RegistroLoginService } from './services/registro-login.service';
import { ReclamoService } from './services/reclamo.service';
import { ProveedorService } from './services/proveedores.service';
import { MotivoGastoService } from './services/motivoGasto.service';
import { GastoService } from './services/gasto.service';
import { MyHttpInterceptor } from './services/http-interceptor.service';

const httpInter = {
  provide: HTTP_INTERCEPTORS, 
  useClass: MyHttpInterceptor, 
  multi: true 
};

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
    FabButtonComponent,
    AgregarReclamoComponent,
    VerConsorcioComponent,
    AgregarGastoComponent
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
  entryComponents: [AgregarOperadorComponent, AgregarReclamoComponent, VerConsorcioComponent, AgregarGastoComponent],
  providers: [httpInter, UsuarioService, ConsorcioService, RegistroLoginService, UnidadService, ReclamoService, ProveedorService, MotivoGastoService, GastoService],
  bootstrap: [AppComponent]
})
export class AppModule { }
