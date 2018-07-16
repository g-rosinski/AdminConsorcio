import { Component, OnInit, Inject, ViewChild, ElementRef, NgZone } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ToastrService } from 'ngx-toastr';
import { Observable } from 'rxjs';
import { FormControl } from '@angular/forms';
import { MapsAPILoader } from '@agm/core';
import { BarrioService } from '../../../services/barrio.service';
import { ConsorcioService } from '../../../services/consorcio.service';
// import { google } from '@google/maps';

declare var google: any;

@Component({
    selector: 'app-agregar-consorcio',
    templateUrl: './agregar-consorcio.component.html',
    styles: [`
    agm-map {
        height: 350px;
        margin-right: 20px;
        /* width: 45%; */
    }

    .full-width{
        width: 100%;
      }
`]
})
export class AgregarConsorcioComponent implements OnInit {
    formModel = {
        nombre: '',
        cuit: '',
        calle: '',
        altura: '',
        telefono: '',
        superficie: '',
        coordenadaLatitud: '',
        coordenadaLongitud: '',
        id_barrio: '',
    };

    get isValid(): boolean {
        const foo: boolean = this.formModel.nombre !== '' &&
            this.formModel.cuit !== '' &&
            this.formModel.calle !== '' &&
            this.formModel.altura !== '' &&
            this.formModel.telefono !== '' &&
            this.formModel.superficie !== '' &&
            this.formModel.coordenadaLatitud !== '' &&
            this.formModel.coordenadaLongitud !== '' &&
            this.formModel.id_barrio !== '';
        return foo;
    }

    latitude: number;
    longitude: number;
    searchControl: FormControl;
    zoom: number;
    barrios: Observable<any>;

    @ViewChild("search")
    public searchElementRef: ElementRef;

    constructor(
        private dialogRef: MatDialogRef<AgregarConsorcioComponent>,
        private toast: ToastrService,
        private consorcioService: ConsorcioService,
        private mapsAPILoader: MapsAPILoader,
        private ngZone: NgZone,
        private barrioService: BarrioService,
    ) { }

    ngOnInit() {
        this.barrios = this.barrioService.obtenerTodosLosBarrios();
        this.zoom = 12;
        this.latitude = 39.8282;
        this.longitude = -98.5795;
        this.searchControl = new FormControl();
        this.setCurrentPosition();

        this.mapsAPILoader.load().then(() => {
            let autocomplete = new google.maps.places.Autocomplete(this.searchElementRef.nativeElement, {
                types: ["address"]
            });
            autocomplete.addListener("place_changed", () => {
                this.ngZone.run(() => {
                    let place = autocomplete.getPlace();

                    console.log(place);

                    if (place.geometry === undefined || place.geometry === null) {
                        return;
                    }

                    this.latitude = place.geometry.location.lat();
                    this.longitude = place.geometry.location.lng();
                    this.zoom = 15;

                    this.formModel.coordenadaLatitud = this.latitude.toFixed(8);
                    this.formModel.coordenadaLongitud = this.longitude.toFixed(8);
                    this.formModel.calle = place.address_components[1].long_name;
                    this.formModel.altura = place.address_components[0].types.find(x => x === 'street_number')
                        ? place.address_components[0].long_name
                        : '';
                });
            });
        });
    }

    private setCurrentPosition() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition((position) => {
                this.latitude = position.coords.latitude;
                this.longitude = position.coords.longitude;
                this.zoom = 12;
            });
        }
    }

    onNoClick(): void {
        this.dialogRef.close();
    }

    onSubmit() {
        this.consorcioService.crearConsorcio(this.formModel)
            .then(() => {
                this.toast.success('Consorcio agregado correctamente')
                this.onNoClick();
            });
    }
}
