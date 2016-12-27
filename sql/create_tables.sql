CREATE TYPE gresult AS ENUM ('victory', 'draw', 'loss');

CREATE TABLE Player(
  playerID SERIAL PRIMARY KEY,
  pname varchar(50) UNIQUE NOT NULL,
  password varchar(50) NOT NULL,
  email varchar(50) UNIQUE NOT NULL
);

CREATE TABLE Organizer(
  organizerID SERIAL PRIMARY KEY,
  oname varchar(50) UNIQUE NOT NULL,
  password varchar(50) NOT NULL,
  email varchar(50) UNIQUE NOT NULL
);

CREATE TABLE Tournament(
  tournamentID SERIAL PRIMARY KEY,
  organizer INTEGER REFERENCES Organizer(organizerID),
  tname varchar(50) UNIQUE NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  game_format varchar(50) NOT NULL,
  tournament_format varchar(50) NOT NULL,
  participants INTEGER NOT NULL,
  capacity INTEGER NOT NULL,
  modification_date DATE NOT NULL
);

CREATE TABLE Participation(
  player INTEGER REFERENCES Player(playerID),
  tournament INTEGER REFERENCES Tournament(tournamentID),
  entry_date DATE NOT NULL,
  PRIMARY KEY(player,tournament)
);

CREATE TABLE Game(
  id SERIAL PRIMARY KEY,
  player INTEGER REFERENCES Player(playerID),
  tournament INTEGER REFERENCES Tournament(tournamentID),
  played DATE NOT NULL,
  opponent varchar(50),
  game_result gresult NOT NULL,
  moves varchar(5000),
  notes varchar(5000),
  modification_date DATE NOT NULL
);
