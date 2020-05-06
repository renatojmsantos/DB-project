CREATE TABLE user (
	cc			 int,
	username		 varchar(20) UNIQUE NOT NULL,
	isadmin		 boolean NOT NULL,
	password		 varchar(20) NOT NULL,
	fname		 varchar(20) NOT NULL,
	lname		 varchar(20) NOT NULL,
	telefone		 int,
	email		 varchar(30) NOT NULL,
	ntorneiosabandonados smallint NOT NULL DEFAULT 0,
	confirmado		 boolean,
	PRIMARY KEY(cc)
);

CREATE TABLE tournament (
	name	 varchar(50),
	descricao	 varchar(512),
	datainicio date,
	datafim	 date,
	PRIMARY KEY(name)
);

CREATE TABLE games (
	id		 int AUTO_INCREMENT,
	schedule	 date,
	field_name	 varchar(512) NOT NULL,
	tournament_name varchar(50) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE field (
	name varchar(512),
	tax	 numeric(3,2),
	PRIMARY KEY(name)
);

CREATE TABLE team_tatica (
	name		 varchar(50) NOT NULL,
	id		 int AUTO_INCREMENT,
	pedidoaceite	 boolean,
	tatica_atacante numeric(1,0) DEFAULT 2,
	tatica_medio	 numeric(1,0) DEFAULT 4,
	tatica_defesa	 numeric(1,0) DEFAULT 4,
	user_cc	 int NOT NULL,
	tournament_name varchar(50) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE role_in_team (
	role	 varchar(512) NOT NULL,
	priority	 smallint NOT NULL,
	saldo	 numeric(8,2),
	pedidoaceite boolean,
	team_id	 int,
	user_cc	 int,
	PRIMARY KEY(team_id,user_cc)
);

CREATE TABLE interacao (
	golos	 smallint NOT NULL DEFAULT 0,
	faltou	 boolean NOT NULL,
	games_id int,
	user_cc	 int,
	PRIMARY KEY(games_id,user_cc)
);

CREATE TABLE score (
	goals	 numeric(2,0),
	team_id	 int,
	games_id int,
	PRIMARY KEY(team_id,games_id)
);

CREATE TABLE message (
	type	 varchar(20) NOT NULL,
	content	 varchar(512) NOT NULL,
	isnew	 boolean NOT NULL,
	send_time timestamp,
	user_cc	 int,
	PRIMARY KEY(send_time,user_cc)
);

CREATE TABLE pedidosub (
	estado	 varchar(20),
	team_id	 int,
	games_id int,
	user_cc	 int,
	PRIMARY KEY(team_id,games_id,user_cc)
);

CREATE TABLE schedule (
	dayofweek	 numeric(1,0),
	hour		 numeric(2,0),
	minutes	 numeric(2,0),
	tournament_name varchar(50),
	PRIMARY KEY(tournament_name)
);

CREATE TABLE posicaopreferida (
	posicao varchar(20) NOT NULL,
	user_cc int,
	PRIMARY KEY(user_cc)
);

CREATE TABLE datasproibidas (
	diajogonao	 date NOT NULL,
	tournament_name varchar(50),
	PRIMARY KEY(tournament_name)
);

CREATE TABLE tournament_field (
	tournament_name varchar(50),
	field_name	 varchar(512),
	PRIMARY KEY(tournament_name,field_name)
);

CREATE TABLE user_games (
	user_cc	 int,
	games_id int,
	PRIMARY KEY(user_cc,games_id)
);

CREATE TABLE user_tournament (
	user_cc	 int,
	tournament_name varchar(50),
	PRIMARY KEY(user_cc,tournament_name)
);

ALTER TABLE games ADD CONSTRAINT games_fk1 FOREIGN KEY (field_name) REFERENCES field(name);
ALTER TABLE games ADD CONSTRAINT games_fk2 FOREIGN KEY (tournament_name) REFERENCES tournament(name);
ALTER TABLE team_tatica ADD CONSTRAINT team_tatica_fk1 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE team_tatica ADD CONSTRAINT team_tatica_fk2 FOREIGN KEY (tournament_name) REFERENCES tournament(name);
ALTER TABLE role_in_team ADD CONSTRAINT role_in_team_fk1 FOREIGN KEY (team_id) REFERENCES team(id);
ALTER TABLE role_in_team ADD CONSTRAINT role_in_team_fk2 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE interacao ADD CONSTRAINT interacao_fk1 FOREIGN KEY (games_id) REFERENCES games(id);
ALTER TABLE interacao ADD CONSTRAINT interacao_fk2 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE score ADD CONSTRAINT score_fk1 FOREIGN KEY (team_id) REFERENCES team(id);
ALTER TABLE score ADD CONSTRAINT score_fk2 FOREIGN KEY (games_id) REFERENCES games(id);
ALTER TABLE message ADD CONSTRAINT message_fk1 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE pedidosub ADD CONSTRAINT pedidosub_fk1 FOREIGN KEY (team_id) REFERENCES team(id);
ALTER TABLE pedidosub ADD CONSTRAINT pedidosub_fk2 FOREIGN KEY (games_id) REFERENCES games(id);
ALTER TABLE pedidosub ADD CONSTRAINT pedidosub_fk3 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE schedule ADD CONSTRAINT schedule_fk1 FOREIGN KEY (tournament_name) REFERENCES tournament(name);
ALTER TABLE posicaopreferida ADD CONSTRAINT posicaopreferida_fk1 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE datasproibidas ADD CONSTRAINT datasproibidas_fk1 FOREIGN KEY (tournament_name) REFERENCES tournament(name);
ALTER TABLE tournament_field ADD CONSTRAINT tournament_field_fk1 FOREIGN KEY (tournament_name) REFERENCES tournament(name);
ALTER TABLE tournament_field ADD CONSTRAINT tournament_field_fk2 FOREIGN KEY (field_name) REFERENCES field(name);
ALTER TABLE user_games ADD CONSTRAINT user_games_fk1 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE user_games ADD CONSTRAINT user_games_fk2 FOREIGN KEY (games_id) REFERENCES games(id);
ALTER TABLE user_tournament ADD CONSTRAINT user_tournament_fk1 FOREIGN KEY (user_cc) REFERENCES user(cc);
ALTER TABLE user_tournament ADD CONSTRAINT user_tournament_fk2 FOREIGN KEY (tournament_name) REFERENCES tournament(name);

