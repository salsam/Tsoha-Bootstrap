--Player-taulun testidata
INSERT INTO Player (pname, password, email) VALUES ('a', 'a', 'a');
INSERT INTO Player (pname, password, email) VALUES ('c','c','c');
INSERT INTO Player (player_id, pname, password, email) VALUES (0, 0, 12345645845, 0);

--Tournament-taulun testidata
INSERT INTO Tournament (tname, organizer, start_date, end_date, game_format, tournament_format,
capacity, modified) VALUES ('t', 1,'2017-12-12','2017-12-24', 
'gf', 'tf', 2, NOW());
INSERT INTO Tournament (tournament_id, tname, organizer, start_date, end_date, game_format, tournament_format,
capacity, modified) VALUES (0, 'no tournament', 0, '1-1-1', '1-1-1', '', '', 0, '1-1-1');

--Game-taulun testidata
INSERT INTO Game (player, tournament, game_date, opponent, game_result, modified) 
VALUES (1, 1, '2016-12-24','d','victory','2016-12-24');

--Participation-taulun testidata
INSERT INTO Participation (player, tournament, entry_date) VALUES (2,1,'2016-12-24');
