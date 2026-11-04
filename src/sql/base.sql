drop table Tag;
drop table User2User;
drop table Touite2Tag;
drop table Touite2User;
drop table User;
drop table Touite;

create table Tag (
  id_tag number(100),
  libellle varchar(10),
  description varchar(10),
  id_user number(100),
  id_tuites number(100),
  primary key (id_tag, libellle)
);

create table User2User (
    id_user number(100),
    id_suivie number(100),
    foreign key (id_suivie, id_user)
);

create table Touite2Tag (
    id_user number(100),
    id_tab number(100),
    foreign key (id_user, id_tab)
);

create table Touite2User (
    id_user number(100),
    id_tuite number(100),
    foreign key (id_user, id_tuite)
);

create table User (
  id_user number(50),
  prenom varchar(10),
  nom varchar(10),
  email varchar(10),
  nb_touile number(2),
  id_suivie number(100),
  id_touite number(50),
  id_follow number(100),
  primary key(id_user),
    foreign key (id_suivie, id_follow, id_touite)
);

create table Touite (
  id_touite number(50),
  message varchar(255),
  date varchar(20),
  likes number(20),
  tags JSON,
  id_user number(50),
  primary key (id_touite),
    foreign key (id_user)
);