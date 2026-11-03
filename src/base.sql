drop table Tag;
drop table User;
drop table Touite;

create table Tag (
  id_tag number(100),
  libellle varchar(10),
  description varchar(10),
  liste_suivie JSON,
  liste_touites JSON,
  primary key (id_tag, libellle)
);

create table User (
  id_user number(50),
  prenom varchar(10),
  nom varchar(10),
  email varchar(10),
  nb_touile number(2),
  liste_suivie JSON,
  liste_touites JSON,
  liste_touite_liker JSON,
  liste_tag JSON,
  liste_follow JSON,
  id number(2),
  primary key(id_user)
);

create table Touite (
  id_touite number(50),
  message varchar(255),
  date varchar(20),
  likes number(20),
  tags JSON,
  id_user number(50),
  primary key (id_touite)
);