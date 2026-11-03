drop table Tag;
drop table User;
drop table Touite;

create table Tag (
  id number(100),
  libellle varchar(10),
  description varchar(10),
  liste_suivie JSON,
  liste_touites JSON
);

create table User (
  prenom varchar(10),
  nom varchar(10),
  email varchar(10),
  nb_touile number(2),
  liste_suivie JSON,
  liste_touites JSON,
  liste_touite_liker JSON,
  liste_tag JSON,
  liste_follow JSON,
  id number(2)
);

create table Touite (
  id number(2),
  message varchar(255),
  user User(),
  date varchar(20),
  likes number(20),
  tags JSON
);