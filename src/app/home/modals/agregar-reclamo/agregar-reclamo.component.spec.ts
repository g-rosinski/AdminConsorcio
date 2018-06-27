import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AgregarReclamoComponent } from './agregar-reclamo.component';

describe('AgregarReclamoComponent', () => {
  let component: AgregarReclamoComponent;
  let fixture: ComponentFixture<AgregarReclamoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AgregarReclamoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AgregarReclamoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
