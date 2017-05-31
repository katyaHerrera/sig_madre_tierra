 php bin/console doctrine:mapping:import --force AcmeBlogBundle xml
create table tarifas(
    id_tarifa int not null auto_increment,
    nivel int not null,
    consumo_min decimal(7,2) not null,
    consumo_max decimal(7, 2) not null,
    cobro decimal(5, 2) not null,
    primary key(id_tarifa)
);

create table pozos(
    id_pozo int not null auto_increment,
    ubicacion varchar(500) not null,
    primary key(id_pozo)
);

create table sectores(
    id_sector int not null auto_increment,
    nombre_sector varchar(75) not null,
    primary key(id_sector)
);

create table tipo_reclamos(
    id_tipo_reclamo int not null auto_increment,
    tiempo_atencion time not null,
    descripcion varchar(250) not null,
    primary key(id_tipo_reclamo)
);

create table perfiles(
    id_perfil int not null auto_increment,
    nombre_perfil varchar(75) not null,
    primary key(id_perfil)
);

create table suministros(
    sector int not null,
    pozo int not null,
    primary key(sector, pozo),
    foreign key(sector) references sectores(id_sector),
    foreign key(pozo) references pozos(id_pozo)
);

create table res_micromediciones(
    id_res_micromedicion int not null auto_increment,
    mes int not null,
    anio int not null,
    tipo_acometida int not null,
    total_consumo decimal(18, 2) not null,
    monto_facturado decimal(18, 2) not null,
    sector int not null,
    tarifa int not null,
    primary key(id_res_micromedicion),
    foreign key(sector) references sectores(id_sector),
    foreign key(tarifa) references tarifas(id_tarifa)
);

create table res_facturacion(
    id_res_micromedicion int not null,
    monto_recaudado decimal(18, 2) not null,
    primary key(id_res_micromedicion),
    foreign key(id_res_micromedicion) references res_micromediciones(id_res_micromedicion)
);

create table acometidas(
    id_res_acometidas int not null auto_increment,
    acom_exist int not null,
    cub_micro decimal(3, 2) not null,
    serv_continuo decimal(3, 2) not null,
    por_activa decimal(3, 2) not null,
    mes int not null,
    anio int not null,
    sector int not null,
    primary key(id_res_acometidas),
    foreign key(sector) references sectores(id_sector)
);

create table res_macromedicion(
    id_res_macromedicion int not null auto_increment,
    total_extraido decimal(18, 2) not null,
    consumo_energia decimal(18, 2) not null,
    costo_energia decimal(10, 2) not null,
    mes int not null,
    anio int not null,
    pozo int not null,
    primary key(id_res_macromedicion),
    foreign key(pozo) references pozos(id_pozo)
);

create table consumos_mayores(
    id_reg int not null auto_increment,
    nombre_cliente varchar(350) not null,
    direccion varchar(500) not null,
    consumo decimal(10, 2) not null,
    mes int not null,
    anio int not null,
    tipo_acometida int not null,
    sector int not null,
    primary key(id_reg),
    foreign key(sector) references sectores(id_sector)
);

create table res_problemas(
    id_reg_problemas int not null auto_increment,
    cant_rebalses int not null,
    cant_con_ilegal int not null,
    cant_rotura int not null,
    mes int not null,
    anio int not null,
    sector int not null,
    primary key(id_reg_problemas),
    foreign key(sector) references sectores(id_sector)
);

create table otros_costos(
    id_reg_otros_costos int not null auto_increment,
    total decimal(18, 2) not null,
    mes int not null,
    anio int not null,
    primary key(id_reg_otros_costos)
);

create table res_reclamos(
    id_res_reclamos int not null auto_increment,
    prom_atencion int not null,
    cantidad int not null,
    mes int not null,
    anio int not null,
    tipo_reclamo int not null,
    primary key(id_res_reclamos),
    foreign key(tipo_reclamo) references tipo_reclamos(id_tipo_reclamo)
);

create table color_indicador(
    id_indicador int not null,
    valor_verde decimal(10, 2),
    valor_amarillo decimal (10, 2),
    valor_anaranjado decimal(10, 2),
    ascen_bueno boolean default TRUE,
    nom_indicador varchar(75) not null,
    primary key(id_indicador)
);

create table usuarios(
    correo varchar(150) not null,
    nombre_completo varchar(350) not null,
    password varchar(60) not null,
    estado int not null default 0,
    perfil int not null,
    primary key(correo),
    foreign key(perfil) references perfiles(id_perfil)
);

create table rec_password(
    id_rec_password int not null auto_increment,
    fecha_registro date not null,
    estado int not null default 0,
    ram_link varchar(75) not null,
    usuario varchar(150) not null,
    primary key(id_rec_password),
    foreign key(usuario) references usuarios(correo)
);