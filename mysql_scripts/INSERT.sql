INSERT INTO CountryInfo VALUES('CAN', 'CAD');
INSERT INTO CountryInfo VALUES('USA', 'USD');
INSERT INTO CountryInfo VALUES('JPN', 'JPY');
INSERT INTO CountryInfo VALUES('AUS', 'AUD');
INSERT INTO CountryInfo VALUES('RUS', 'RUB');

INSERT INTO CardInfo VALUES('2222222222222222', 'USA', 'Visa', '166');
INSERT INTO CardInfo VALUES('1234567890123456', 'CAN', 'MasterCard', '423');
INSERT INTO CardInfo VALUES('9876543210987654', 'USA', 'American Express', '922');
INSERT INTO CardInfo VALUES('3333333333333333', 'JPN', 'Visa', '166');
INSERT INTO CardInfo VALUES('1111111111111111', 'RUS', 'MasterCard', '111');

INSERT INTO Members VALUES('johnny123', 'John', 'john@domain.com', '2020-09-09 14:23:03', '2222222222222222');
INSERT INTO Members VALUES('stevieboy', 'steve', 'steven@domain2.com', '2019-12-21 23:53:22', NULL);
/* Highlights that users can possibly have the same credit card number: for example, siblings of a same household */
INSERT INTO Members VALUES('minecraftfan123', 'Minecraft Fan', 'john@domain3.com', '2020-05-09 16:25:46', '3333333333333333');
INSERT INTO Members VALUES('minecraftfan456', 'Minecraft Fan', 'jason@domain.com', '2020-05-09 16:29:32', '3333333333333333');
INSERT INTO Members VALUES('hail2dakingbby', 'Ash', 'ash@s-mart.com', '2019-03-02 02:20:35', '1234567890123456');
INSERT INTO Members VALUES('notahacker', 'Anonymous', 'trustme@imagoodguy.ru', '1970-01-01 00:00:00', '1111111111111111');

INSERT INTO Viewer VALUES('johnny123', 0);
INSERT INTO Viewer VALUES('stevieboy', 100);
INSERT INTO Viewer VALUES('minecraftfan123', 20);
INSERT INTO Viewer VALUES('hail2dakingbby', 52);
INSERT INTO Viewer VALUES('notahacker', 1000000);

INSERT INTO Channel VALUES(1, 'Minecraft Fun');
INSERT INTO Channel VALUES(2, 'LEGIT CHANNEL');
INSERT INTO Channel VALUES(3, "Johnny\'s Channel");
INSERT INTO Channel VALUES(4, 'stevie boy plays');
INSERT INTO Channel VALUES(5, 'Minecraft Fun');

INSERT INTO Streamer VALUES('minecraftfan456', 23, 1);
INSERT INTO Streamer VALUES('minecraftfan123', 6, 5);
INSERT INTO Streamer VALUES('johnny123', 0, 3);
INSERT INTO Streamer VALUES('stevieboy', 40, 4);
INSERT INTO Streamer VALUES('notahacker', 1000000, 2);

INSERT INTO GameCompany VALUES(1, 'Sony');
INSERT INTO GameCompany VALUES(2, 'Nintendo');
INSERT INTO GameCompany VALUES(3, 'Microsoft');
INSERT INTO GameCompany VALUES(4, 'Google');
/* Used to highlight that there can be platforms of the same name */
INSERT INTO GameCompany VALUES(5, 'Soony');
INSERT INTO GameCompany VALUES(6, 'Gaming News');
INSERT INTO GameCompany VALUES(7, 'Mojang');
INSERT INTO GameCompany VALUES(8, 'Capcom');
INSERT INTO GameCompany VALUES(9, 'Fox Gaming');
INSERT INTO GameCompany VALUES(10, 'Bethesda');

INSERT INTO GamePublisher VALUES(1);
INSERT INTO GamePublisher VALUES(2);
INSERT INTO GamePublisher VALUES(3);
INSERT INTO GamePublisher VALUES(7);
INSERT INTO GamePublisher VALUES(8);
INSERT INTO GamePublisher VALUES(9);
INSERT INTO GamePublisher VALUES(10);

INSERT INTO PlatformManufacturer VALUES(1);
INSERT INTO PlatformManufacturer VALUES(2);
INSERT INTO PlatformManufacturer VALUES(3);
INSERT INTO PlatformManufacturer VALUES(4);
INSERT INTO PlatformManufacturer VALUES(5);

INSERT INTO Game VALUES(1, 'Resident Evil', '1996-03-22', NULL, true, 8);
INSERT INTO Game(gameID, gameTitle, releaseDate, companyID) VALUES(2, 'Minecraft', '2011-11-18', 7);
INSERT INTO Game VALUES(3, 'Family Guy: The Video Game', '2009-01-06', NULL, true, 9);
INSERT INTO Game VALUES(4, 'Devil May Cry', '2001-08-23', NULL, true, 8);
INSERT INTO Game VALUES(5, 'Family Guy 2', '2009-06-02', NULL, false, 9);
INSERT INTO Game VALUES(6, 'Super Mario Bros', '1985-09-13', NULL, true, 2);
INSERT INTO Game VALUES(7, 'Halo: Combat Evolved', '2001-11-15', NULL, true, 3);
INSERT INTO Game VALUES(8, 'Skyrim', '2011-11-11', NULL, false, 10);
INSERT INTO Game VALUES(9, 'The Elder Scrolls: Arena', '1994-03-25', NULL, true, 10);

INSERT INTO Series VALUES(1, 'Resident Evil', 1, 8);
INSERT INTO Series VALUES(2, 'Mario', 6, 2);
INSERT INTO Series VALUES(3, 'Family Guy', 3, 9);
INSERT INTO Series VALUES(4, 'Devil May Cry', 4, 8);
INSERT INTO Series VALUES(5, 'Halo', 7, 3);
INSERT INTO Series VALUES(6, 'The Elder Scrolls', 9, 10);

UPDATE Game SET seriesId = 1 WHERE gameID = 1;
UPDATE Game SET seriesId = 3 WHERE gameID = 3;
UPDATE Game SET seriesId = 4 WHERE gameID = 4;
UPDATE Game SET seriesId = 3 WHERE gameID = 5;
UPDATE Game SET seriesId = 2 WHERE gameID = 6;
UPDATE Game SET seriesId = 5 WHERE gameID = 7;
UPDATE Game SET seriesId = 6 WHERE gameID = 8;
UPDATE Game SET seriesId = 6 WHERE gameID = 9;

INSERT INTO Rates VALUES('hail2dakingbby', 1, 8, 'Groovy');
INSERT INTO Rates VALUES('minecraftFan123', 2, 10, 'I love this game!');
INSERT INTO Rates VALUES('stevieboy', 3, 2, 'wow this game is trash');
INSERT INTO Rates VALUES('stevieboy', 5, 7, 'pretty good sequel to a bad game');
/* Ensures that the aggregate query on the average score works on null scores */
INSERT INTO Rates VALUES('stevieboy', 6, NULL, 'not rating this until they fix that bug');
INSERT INTO Rates VALUES('minecraftfan456', 2, 8, 'Love this game');
/* Ensures that the aggregate query works on games with no rating (id 7 is missing a rating) */
INSERT INTO Rates VALUES('notahacker', 1, 10, NULL);
INSERT INTO Rates VALUES('notahacker', 2, 10, NULL);
INSERT INTO Rates VALUES('notahacker', 3, 10, NULL);
INSERT INTO Rates VALUES('notahacker', 4, 10, NULL);
INSERT INTO Rates VALUES('notahacker', 6, 10, NULL);

INSERT INTO Genre VALUES('Horror');
INSERT INTO Genre VALUES('Survival');
INSERT INTO Genre VALUES('Action');
INSERT INTO Genre VALUES('Arcade');
INSERT INTO Genre VALUES('Platformer');
INSERT INTO Genre VALUES('Shooter');
INSERT INTO Genre VALUES('Puzzle');
INSERT INTO Genre VALUES('Strategy');

INSERT INTO TypeOf VALUES(1, 'Horror');
INSERT INTO TypeOf VALUES(1, 'Survival');
INSERT INTO TypeOf VALUES(2, 'Survival');
INSERT INTO TypeOf VALUES(3, 'Action');
INSERT INTO TypeOf VALUES(4, 'Action');
INSERT INTO TypeOf VALUES(5, 'Action');
INSERT INTO TypeOf VALUES(6, 'Platformer');
INSERT INTO TypeOf VALUES(7, 'Shooter');
INSERT INTO TypeOf VALUES(8, 'Action');
INSERT INTO TypeOf VALUES(9, 'Action');

INSERT INTO SubscribesTo VALUES(4, 'hail2dakingbby');
INSERT INTO SubscribesTo VALUES(1, 'minecraftfan123');
INSERT INTO SubscribesTo VALUES(2, 'hail2dakingbby');
INSERT INTO SubscribesTo VALUES(2, 'johnny123');
INSERT INTO SubscribesTo VALUES(5, 'stevieboy');

INSERT INTO Platform VALUES(1, 'Playstation', '1994-12-03', 'console', 1);
INSERT INTO Platform VALUES(2, 'Nintendo Entertainment System', '1983-07-15', 'console', 2);
INSERT INTO Platform VALUES(3, 'Xbox', '2001-11-15', 'console', 3);
INSERT INTO Platform VALUES(4, 'Windows 10', '2015-07-15', 'PC', 3);
INSERT INTO Platform VALUES(5, 'Android', '2008-09-23', 'mobile', 4);
INSERT INTO Platform VALUES(6, 'Playstation 2', '2000-03-04', 'console', 1);
INSERT INTO Platform VALUES(7, 'Playstation', '2020-10-23', 'mobile', 5);

INSERT INTO Sponsor VALUES(1, 'secureVPN', 'software', 'www.securevpn.xyz');
INSERT INTO Sponsor VALUES(2, 'Penny Shave Club', 'accessories', 'www.pennyshave.co.xyz');
INSERT INTO Sponsor VALUES(3, "Raid of the Shadow\'s Legned", 'software', 'www.raid.abc');
INSERT INTO Sponsor VALUES(4, 'Fresh Meats', 'service', 'www.freshmeat.def');
INSERT INTO Sponsor VALUES(5, 'SponsorHide', 'software', 'www.nomoresponsorsfor.me');

INSERT INTO Stream VALUES(1, 3, 'Playing Super Mario Bros', '2020-10-02', 0, 0, 0, NULL);
INSERT INTO Stream VALUES(1, 4, 'halo speedrun 1', '2020-02-02', 23, 750, 322, 1);
INSERT INTO Stream VALUES(2, 4, 'halo speedrun 2', '2020-02-03', 35, 224, 54, 1);
INSERT INTO Stream VALUES(3, 4, 'halo speedrun 3', '2020-02-04', 123, 124, 62, 1);
INSERT INTO Stream VALUES(1, 1, 'Minecraft Part 1', '2020-11-09', 60, 403, 100, 2);
INSERT INTO Stream VALUES(2, 1, 'Minecraft Part 2', '2020-11-10', 40, 200, 67, 2);
INSERT INTO Stream VALUES(1, 2, 'FAMILY GUY PART 1', '1970-01-01', 1000000, 1000000, 1000000, NULL);
INSERT INTO Stream VALUES(2, 2, 'FAMILY GUY PART 1', '1970-01-01', 1000000, 1000000, 1000000, NULL);
INSERT INTO Stream VALUES(3, 2, 'FAMILY GUY PART 1', '1970-01-01', 1000000, 1000000, 1000000, NULL);
INSERT INTO Stream VALUES(4, 2, 'FAMILY GUY PART 1', '1970-01-01', 1000000, 1000000, 1000000, NULL);

INSERT INTO StreamViews VALUES(1, 2, 'hail2dakingbby');
INSERT INTO StreamViews VALUES(3, 4, 'minecraftfan123');
INSERT INTO StreamViews VALUES(2, 1, 'minecraftfan123');
INSERT INTO StreamViews VALUES(2, 1, 'stevieboy');
INSERT INTO StreamViews VALUES(1, 2, 'minecraftfan123');

INSERT INTO GameplayOf VALUES(1, 3, 6);
INSERT INTO GameplayOf VALUES(3, 4, 7);
INSERT INTO GameplayOf VALUES(1, 1, 2);
INSERT INTO GameplayOf VALUES(2, 1, 2);
INSERT INTO GameplayOf VALUES(1, 2, 5);

INSERT INTO AvailableOn VALUES(1,1);
INSERT INTO AvailableOn VALUES(4,2);
INSERT INTO AvailableOn VALUES(5,2);
INSERT INTO AvailableOn VALUES(5,3);
INSERT INTO AvailableOn VALUES(6,4);
INSERT INTO AvailableOn VALUES(5,5);
INSERT INTO AvailableOn VALUES(2,6);
INSERT INTO AvailableOn VALUES(3,7);
INSERT INTO AvailableOn VALUES(4,7);
/*Game 8 (Skyrim) is available on all platforms; used for division*/
INSERT INTO AvailableOn VALUES(1,8);
INSERT INTO AvailableOn VALUES(2,8);
INSERT INTO AvailableOn VALUES(3,8);
INSERT INTO AvailableOn VALUES(4,8);
INSERT INTO AvailableOn VALUES(5,8);
INSERT INTO AvailableOn VALUES(6,8);
INSERT INTO AvailableOn VALUES(7,8);

