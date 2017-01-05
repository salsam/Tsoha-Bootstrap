CREATE TYPE gresult AS ENUM ('victory', 'draw', 'loss');

CREATE TABLE Player(
  player_id SERIAL PRIMARY KEY,
  pname varchar(20) UNIQUE NOT NULL,
  password varchar(20) NOT NULL,
  email varchar(30) UNIQUE NOT NULL,
  organizer boolean NOT NULL
);

CREATE TABLE Tournament(
  tournament_id SERIAL PRIMARY KEY,
  organizer INTEGER REFERENCES Player(player_id) NOT NULL,
  tname varchar(20) UNIQUE NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  game_format varchar(20) NOT NULL,
  tournament_format varchar(20) NOT NULL,
  participants INTEGER NOT NULL,
  capacity INTEGER NOT NULL,
  details varchar(5000),
  modified DATE NOT NULL
);

CREATE TABLE Participation(
  player INTEGER REFERENCES Player(player_id) NOT NULL,
  tournament INTEGER REFERENCES Tournament(tournament_id) NOT NULL,
  entry_date DATE NOT NULL,
  PRIMARY KEY(player,tournament)
);

CREATE TABLE Game(
  game_id SERIAL PRIMARY KEY,
  player INTEGER REFERENCES Player(player_id) NOT NULL,
  tournament INTEGER REFERENCES Tournament(tournament_id),
  game_date DATE NOT NULL,
  opponent varchar(20),
  game_result gresult NOT NULL,
  notes varchar(5000),
  modified DATE NOT NULL
);
