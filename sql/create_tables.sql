CREATE TYPE gresult AS ENUM ('victory', 'draw', 'loss');

CREATE TABLE Player(
  player_id SERIAL PRIMARY KEY,
  pname varchar(50) UNIQUE NOT NULL,
  password varchar(50) NOT NULL,
  email varchar(50) UNIQUE NOT NULL
);

CREATE TABLE Organizer(
  organizer_id SERIAL PRIMARY KEY,
  oname varchar(50) UNIQUE NOT NULL,
  password varchar(50) NOT NULL,
  email varchar(50) UNIQUE NOT NULL
);

CREATE TABLE Tournament(
  tournament_id SERIAL PRIMARY KEY,
  organizer INTEGER REFERENCES Organizer(organizer_id),
  tname varchar(50) UNIQUE NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  game_format varchar(50) NOT NULL,
  tournament_format varchar(50) NOT NULL,
  participants INTEGER NOT NULL,
  capacity INTEGER NOT NULL,
  modified DATE NOT NULL
);

CREATE TABLE Participation(
  player INTEGER REFERENCES Player(player_id),
  tournament INTEGER REFERENCES Tournament(tournament_id),
  entry_date DATE NOT NULL,
  PRIMARY KEY(player,tournament)
);

CREATE TABLE Game(
  game_id SERIAL PRIMARY KEY,
  player INTEGER REFERENCES Player(player_id),
  tournament INTEGER REFERENCES Tournament(tournament_id),
  played DATE NOT NULL,
  opponent varchar(50),
  game_result gresult NOT NULL,
  moves varchar(5000),
  notes varchar(5000),
  modified DATE NOT NULL
);
