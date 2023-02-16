create database torneo;

use torneo;

create table Torneo(
id int primary key,
nombre varchar(40) not null,
sede varchar(40) not null,
fecha date not null,
hora_inicio char(32) not null
) engine = "innodb";

create table Juez(
id int primary key,
nombre varchar(40) not null,
apPaterno varchar(40),
apMaterno varchar(40),
tipo char(20) not null,
escuela varchar(50) not null
)engine="Innodb";

create table Participante(
id int primary key,
nombre varchar(40) not null,
apPaterno varchar(40),
apMaterno varchar(40),
categoria char(1) not null,
lugar char(3),
idTorneo int not null,
Foreign key (idTorneo) references Torneo(id)
)engine = "Innodb";

create table Torneo_Juez(
idTorneo int not null,
idJuez int not null,
Foreign key (idTorneo) references Torneo(id),
Foreign key (idJuez) references Juez(id)
)engine="Innodb";

create table Pelea(
id int primary key,
idPart1 int not null,
idPart2 int not null,
idTorneo int not null,
Foreign key (idPart1) references Participante(id),
Foreign key (idPart2) references Participante(id),
Foreign key (idTorneo) references Torneo(id)
)engine="Innodb";
