--Player-taulun testidata
INSERT INTO Player (pname, password, email, organizer) VALUES ('a', 'a', 'a', false);
INSERT INTO Player (pname, password, email, organizer) VALUES ('b', 'b', 'b', false);
INSERT INTO Player (pname, password, email, organizer) VALUES ('c','c','c', true);

--Tournament-taulun testidata
INSERT INTO Tournament (tname, organizer, start_date, end_date, game_format, tournament_format,
participants, capacity, modified) VALUES ('t', 1,'2017-12-12','2017-12-24', 
'gf', 'tf', 1, 2, NOW());

--Game-taulun testidata
INSERT INTO Game (player, tournament, played, opponent, game_result, modified) 
VALUES (1, 1, '2016-12-24','d','victory','2016-12-24');

--Participation-taulun testidata
INSERT INTO Participation (player, tournament, entry_date) VALUES (2,1,'2016-12-24');
