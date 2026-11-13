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








insert into Users (idUser, prenom, email, nbTouite) values
(1, 'Alice', 'alice@touiteur.fr', 3),
(2, 'Bob', 'bob@touiteur.fr', 2),
(3, 'Charlie', 'charlie@touiteur.fr', 2),
(4, 'Diana', 'diana@touiteur.fr', 1),
(5, 'Ethan', 'ethan@touiteur.fr', 0);


insert into Tag (idTag, libelle) values
(1, 'PHP'),
(2, 'IUT'),
(3, 'Web'),
(4, 'SQL'),
(5, 'Cafe');


insert into Touite (idTouite, message, idUser, dateTouite, likeTouite) values
(1, 'Premier touite sur la plateforme ! Trop contente de tester #PHP et #Web.', 1, '2026-11-10 09:15:00', 3),
(2, 'La SAÉ avance bien, on finalise la base de données #SQL et #IUT !', 1, '2026-11-11 14:30:00', 2),
(3, 'N oubliez pas de bien préparer vos requêtes PDO pour éviter les injections #PHP', 1, '2026-11-12 18:45:00', 1),
(4, 'Quelqu un a un bon tuto sur le pattern MVC ? #Web #IUT', 2, '2026-11-11 10:05:00', 2),
(5, 'Troisième #Cafe de la journée, le code commence enfin à compiler.', 2, '2026-11-13 08:20:00', 4),
(6, 'Les jointures #SQL avec LEFT JOIN ça sauve la vie pour les compteurs !', 3, '2026-11-12 11:10:00', 1),
(7, 'Hâte de voir le rendu final de ce projet #IUT #Web', 3, '2026-11-13 15:00:00', 0),
(8, 'Bonjour tout le monde, je débarque sur Touiteur ! #Cafe', 4, '2026-11-13 16:10:00', 1);


insert into Tag2Touite (idTag, idTouite) values
(1, 1), (3, 1),
(4, 2), (2, 2),
(1, 3),
(3, 4), (2, 4),
(5, 5),
(4, 6),
(2, 7), (3, 7),
(5, 8);


insert into Follow (idFollow, idFollower) values
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(3, 1),
(4, 5);


insert into TouiteLike (idTouite, idUser) values
(1, 2), (1, 3), (1, 4),
(2, 2), (2, 4),
(3, 3),
(4, 1), (4, 3),
(5, 1), (5, 3), (5, 4), (5, 5),
(6, 1),
(8, 1);


insert into FollowTag (idTag, idUser) values
(1, 1), (3, 1),
(2, 2), (5, 2),
(1, 3), (4, 3),
(5, 4),
(2, 5);