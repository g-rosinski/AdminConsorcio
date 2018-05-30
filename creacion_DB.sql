drop database if exists iani;
create database if not exists iani;

use iani;

create table persona
(id_persona int unsigned auto_increment,
nombre varchar (100) not null,
apellido varchar(100) not null,
dni varchar (50) not null,
email varchar (200),
cuil int not null,
razon_social varchar (200) not null,
inquilino_de int unsigned,
primary key (id_persona),
constraint persona_fk_p foreign key (inquilino_de) references persona (id_persona));

create table usuario
(id_usuario int unsigned auto_increment,
user varchar (50) not null,
pass varchar(50) not null,
estado varchar (50) not null,
id_persona int unsigned not null,
primary key (id_usuario),
constraint persona_fk_u foreign key (id_persona) references persona (id_persona));

create table rol
(id_rol int unsigned auto_increment,
descripcion varchar (200) not null,
primary key (id_rol));

create table rolUsuario
(id_rol int unsigned,
id_usuario int unsigned,
primary key (id_usuario, id_rol),
constraint rol_fk_ru foreign key (id_rol) references rol (id_rol),
constraint usuario_fk_ru foreign key (id_usuario) references usuario (id_usuario));


create table comuna
(id_comuna int unsigned auto_increment,
descripcion varchar (200),
primary key (id_comuna));

create table barrio
(id_barrio int unsigned auto_increment,
id_comuna int unsigned not null,
codigo_postal varchar (15) not null,
descripcion varchar (200) not null,
primary key (id_barrio),
constraint comuna_fk_b foreign key (id_comuna) references comuna (id_comuna));

create table consorcio
(id_consorcio int unsigned auto_increment,
nombre varchar (200) not null,
cuit int not null,
calle varchar (100) not null,
altura int not null,
telefono int,
email varchar (200),
coordenada int,
id_barrio int unsigned not null,
primary key (id_consorcio),
constraint barrio_fk_c foreign key (id_barrio) references barrio (id_barrio));

create table unidad
(id_unidad int unsigned auto_increment,
prc_participacion int not null,
piso int not null,
departamento varchar (2) not null,
nro_unidad int not null,
id_consorcio int unsigned not null,
id_usuario int unsigned not null,
primary key (id_unidad),
constraint consorcio_fk_u foreign key (id_consorcio) references consorcio (id_consorcio),
constraint usuario_fk_u foreign key (id_usuario) references usuario (id_usuario));

create table propietario
(id_propietario int unsigned auto_increment,
id_usuario int unsigned not null,
id_consorcio int unsigned not null,
primary key (id_propietario),
constraint consorcio_fk_pc foreign key (id_consorcio) references consorcio (id_consorcio),
constraint usuario_fk_pc foreign key (id_usuario) references usuario (id_usuario));

create table cuentaCorriente
(id_ctacte int unsigned auto_increment,
saldo int not null,
saldo_favor int not null,
id_unidad int unsigned not null,
primary key (id_ctacte),
constraint unidad_fk_cc foreign key (id_unidad) references unidad (id_unidad));

create table formaPago
(id_forma_pago int unsigned auto_increment,
descripcion varchar (200) not null,
cotizacion int not null,
tipo varchar (100) not null,
primary key (id_forma_pago));

create table pagoExpensa
(id_pago_expensa int unsigned auto_increment,
importe int not null,
fecha date not null,
hora datetime not null,
id_ctacte int unsigned not null,
id_usuario int unsigned not null,
id_forma_pago int unsigned not null,
primary key (id_pago_expensa),
constraint ctacte_fk_pe foreign key (id_ctacte) references cuentaCorriente (id_ctacte),
constraint usuario_fk_pe foreign key (id_usuario) references usuario (id_usuario),
constraint formaPago_fk_pe foreign key (id_forma_pago) references formaPago (id_forma_pago));

create table gastoMensual
(id_gasto_mensual int unsigned auto_increment,
periodo varchar (50) not null,
fecha date not null,
total int not null,
importe_mantenimiento int,
importe_luz int,
importe_agua int,
id_consorcio int unsigned not null,
primary key (id_gasto_mensual),
constraint consorcio_fk_gm foreign key (id_consorcio) references consorcio(id_consorcio));

create table expensa
(id_expensa int unsigned auto_increment,
cuota_expensa int not null,
cuota_extraordinaria int not null,
cuota_mora int,
cuota_mes int not null,
cuota_vencimiento int not null,
cuota_estado int not null,
id_ctacte int unsigned not null,
id_gasto_mensual int unsigned not null,
primary key (id_expensa),
constraint ctacte_fk_e foreign key (id_ctacte) references cuentaCorriente (id_ctacte),
constraint gastoMensual_fk_e foreign key (id_gasto_mensual) references gastoMensual (id_gasto_mensual));

create table rubroProveedor
(id_rubro_proveedor int unsigned auto_increment,
descripcion varchar (200) not null,
primary key (id_rubro_proveedor));

create table proveedor
(id_proveedor int unsigned auto_increment,
razon_social varchar (200) not null,
telefono int not null,
email varchar (200) not null,
calle varchar (200) not null,
altura int not null,
id_barrio int unsigned not null,
id_rubro_proveedor int unsigned not null,
primary key (id_proveedor),
constraint barrio_fk_p foreign key (id_barrio) references barrio (id_barrio),
constraint rubro_proveedor_fk_p foreign key (id_rubro_proveedor) references rubroProveedor (id_rubro_proveedor));

create table rubroGasto
(id_rubro_gasto int unsigned auto_increment,
descripcion varchar (200) not null,
primary key (id_rubro_gasto));

create table motivoGasto
(id_motivo_gasto int unsigned auto_increment,
descripcion varchar (200) not null,
id_rubro_gasto int unsigned not null,
primary key (id_motivo_gasto),
constraint rubro_gasto_fk_mg foreign key (id_rubro_gasto) references rubroGasto (id_rubro_gasto));

create table motivoReclamo
(id_motivo_reclamo int unsigned auto_increment,
descripcion varchar (200) not null,
primary key (id_motivo_reclamo));

create table reclamo
(id_reclamo int unsigned auto_increment,
nro_reclamo int not null,
titulo varchar (500) not null,
mensaje varchar (10000) not null,
fecha date not null,
hora datetime not null,
id_propietario int unsigned not null,
id_motivo_reclamo int unsigned not null,
primary key (id_reclamo),
constraint propietario_fk_r foreign key (id_propietario) references propietario (id_propietario),
constraint motivo_fk_r foreign key (id_motivo_reclamo) references motivoReclamo (id_motivo_reclamo));

create table gasto
(id_gasto int unsigned auto_increment,
nro_comprobante int not null,
fecha date not null,
descripcion varchar (200) not null,
importe int not null,
id_motivo_gasto int unsigned not null,
id_proveedor int unsigned not null,
id_gasto_mensual int unsigned not null,
id_reclamo int unsigned not null,
id_operador int unsigned not null,
primary key (id_gasto),
constraint gasto_motivo_fk_g foreign key (id_motivo_gasto) references motivoGasto (id_motivo_gasto),
constraint proveedor_fk_g foreign key (id_proveedor) references proveedor (id_proveedor),
constraint gasto_mensual_fk_g foreign key (id_gasto_mensual) references gastoMensual (id_gasto_mensual),
constraint reclamo_fk_g foreign key (id_reclamo) references reclamo (id_reclamo),
constraint operador_fk_g foreign key (id_operador) references usuario (id_usuario));

create table pagoGasto
(id_pago_gasto int unsigned auto_increment,
nro_orden_pago int not null,
id_gasto int unsigned not null,
primary key (id_pago_gasto),
constraint pago_fk_pg foreign key (id_gasto) references gasto (id_gasto));