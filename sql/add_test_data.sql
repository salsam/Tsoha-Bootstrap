--Player-taulun testidata
INSERT INTO Player (pname, password, email) VALUES ('a', '', 'a');
INSERT INTO Player (pname, password, email) VALUES ('b', 'b', 'b');

--Organizer-taulu testidata
INSERT INTO Organizer (oname, password, email) VALUES ('c','c','c');

--Tournament-taulun testidata
INSERT INTO Tournament (tname, start_date, end_date, game_format, tournament_format,
participants, capacity, modification_date) VALUES ('t', '2016-12-12','2016-12-24', 
'gf', 'tf', 1, 2, NOW());

--Game-taulun testidata
INSERT INTO Game (played, opponent, game_result, modification_date) 
VALUES ('2016-12-24','d','victory','2016-12-24');

--Participation-taulun testidata
INSERT INTO Participation (entry_date) VALUES ('2016-12-24');