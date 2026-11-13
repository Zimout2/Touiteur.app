create table Users (
	idUser int auto_increment,
  prenom varchar(40) not null,
	email varchar(50) not null,
	nbTouite int not null default 0,
	primary key (idUser)
);

create table Touite (
	idTouite int auto_increment,
	message varchar(235) not null,
	idUser int not null,
	dateTouite datetime not null,
	likeTouite int not null default 0,
	primary key (idTouite),
	foreign key (idUser) references Users(idUser)
);

create table Tag (
	idTag int auto_increment,
	libelle varchar(40) not null,
	description varchar(235) null,
	primary key (idTag)
);









create table Follow (
	idFollow int,
	idFollower int,
	primary key (idFollow, idFollower),
	foreign key (idFollow) references Users(idUser),
	foreign key (idFollower) references Users(idUser)
);

create table Tag2Touite (
	idTag int,
	idTouite int,
	primary key (idTag, idTouite),
	foreign key (idTag) references Tag(idTag),
	foreign key (idTouite) references Touite(idTouite)
);

create table TouiteLike (
	idTouite int,
	idUser int,
	primary key (idTouite, idUser),
	foreign key (idTouite) references Touite(idTouite),
	foreign key (idUser) references Users(idUser)
);

create table FollowTag (
	idTag int,
	idUser int,
	primary key (idTag, idUser),
	foreign key (idTag) references Tag(idTag),
	foreign key (idUser) references Users(idUser)
);