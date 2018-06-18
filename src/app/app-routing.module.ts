import { NgModule } from '@angular/core';
import { SinginComponent } from './singin/singin.component';
import { SingupComponent } from './singup/singup.component';
import { HomeComponent } from './home/home.component';

import { RouterModule, Routes } from '@angular/router';
import { SessionGuard } from './services/session-guard.service';
import { LoginGuard } from './services/login-guard.service';

const appRoutes: Routes = [
  {
    path: 'login',
    component: SinginComponent,
    canActivate: [LoginGuard]
  },
  {
    path: 'register',
    component: SingupComponent,
    canActivate: [LoginGuard]
  },
  {
    path: 'home',
    component: HomeComponent,
    canActivate: [SessionGuard]
  },
  { path: '', redirectTo: '/login', pathMatch: 'full' },
  // { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  imports: [
    RouterModule.forRoot(appRoutes)
  ],
  exports: [
    RouterModule
  ],
  providers: [SessionGuard, LoginGuard]
})
export class AppRoutingModule { }
