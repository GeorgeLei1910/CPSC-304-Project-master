CREATE TABLE User (
 userName char[30] PRIMARY KEY,
 displayName char[30] UNIQUE,
 email char[50] UNIQUE,
 joinDate date NOT NULL,
 cardNumber char[16] DEFAULT NULL
 FOREIGN KEY (cardNumber) REFERENCES CardInfo
);
CREATE TABLE CardInfo(
 cardNumber char[16] PRIMARY KEY,
 country char[3] NOT NULL,
 cardType char[16] NOT NULL,
 CVV char[3] NOT NULL,
 FOREIGN KEY (country) REFERENCES CountryInfo
);
CREATE TABLE CountryInfo (
 country char[3] PRIMARY KEY,
 currency char[3] NOT NULL
);
CREATE TABLE Viewer (
 userName char[30] PRIMARY KEY,
 loadedBalance int DEFAULT 0,
 FOREIGN KEY (userName) REFERENCES User ON DELETE CASCADE
);
CREATE TABLE Streamer (
 userName char[30] PRIMARY KEY,
 totalEarnings int DEFAULT 0,
 channelID int NOT NULL UNIQUE;
 FOREIGN KEY (userName) REFERENCES User ON DELETE CASCADE,
 FOREIGN KEY (channelID) REFERENCES Channel
);
CREATE TABLE Channel (
 channelID int PRIMARY KEY,
 channelName char[50] NOT NULL
);
CREATE TABLE Stream (
 channelID int,
 streamID int NOT NULL,
 streamTitle char[80],
 streamDate date,
 totalDonations int DEFAULT 0,
 totalUniqueViews int DEFAULT 0,
 maxConcurrentViewers int DEFAULT 0,
 sponsorID char[50] DEFAULT NULL,
 PRIMARY KEY (channelID, streamID)
 FOREIGN KEY (channelID) REFERENCES Channel ON DELETE CASCADE
 FOREIGN KEY (sponsorID) REFERENCES Channel ON DELETE SET NULL
);
CREATE TABLE Sponsor(
 sponsorID int PRIMARY KEY,
 sponsorName char[50] NOT NULL,
 sponsorURL char[50] DEFAULT NULL,
 sponsorType char[50] DEFAULT NULL
)
CREATE TABLE Genre (
 genreType char[30] PRIMARY KEY
);
CREATE TABLE Game (
 gameID int PRIMARY KEY,
 gameTitle char[80],
 releaseDate date,
 seriesID int,
 isFirstEntry bool DEFAULT FALSE,
 companyID int NOT NULL,
 FOREIGN KEY (seriesID) REFERENCES Series ON DELETE SET NULL,
 FOREIGN KEY (companyID) REFERENCES GamePublisher
);
CREATE TABLE Series (
 seriesID int PRIMARY KEY,
 seriesName char[80],
 gameID int NOT NULL,
 companyID int NOT NULL,
 FOREIGN KEY (gameID) REFERENCE Game,
 FOREIGN KEY (companyID) REFERENCES GamePublisher
);
CREATE TABLE Platform (
 platformID int PRIMARY KEY,
 platformName char[50],
 releaseDate date,
 platformType char[30],
 companyID int NOT NULL,
 FOREIGN KEY (companyID) REFERENCES PlatformManufacturer
);
CREATE TABLE GameCompany (
 companyID int PRIMARY KEY,
 companyName char[80]
);
CREATE TABLE GamePublisher (
 companyID int PRIMARY KEY,
 FOREIGN KEY (companyID) REFERENCES GameCompany ON DELETE CASCADE
);
CREATE TABLE PlatformManufacturer (
 companyID int PRIMARY KEY,
 FOREIGN KEY (companyID) REFERENCES GameCompany ON DELETE CASCADE
);
CREATE TABLE Rates (
 userName char[30],
 gameID int,
 rating int,
 comments char[500]
 PRIMARY KEY (userName, gameID)
 FOREIGN KEY (userName) REFERENCES User ON DELETE CASCADE,
 FOREIGN KEY (game) REFERENCES Game ON DELETE CASCADE
);
CREATE TABLE TypeOf(
 gameID int NOT NULL,
 genreType char[30] NOT NULL,
 PRIMARY KEY (gameID, genreType)
 FOREIGN KEY (gameID) REFERENCES Game ON DELETE CASCADE
 FOREIGN KEY (genreType) REFERENCES Genre ON DELETE CASCADE
);
CREATE TABLE AvailableOn (
platformID int NOT NULL,
gameID int NOT NULL,
PRIMARY KEY (platformID, gameID)
FOREIGN KEY (platformID) REFERENCES Platform ON DELETE CASCADE
FOREIGN KEY (gameID) REFERENCES Game ON DELETE CASCADE
);
CREATE TABLE GameplayOf(
gameID int NOT NULL,
streamID int NOT NULL,
channelID int NOT NULL,
PRIMARY KEY (gameID, streamID, channelID)
FOREIGN KEY (gameID) REFERENCES Game
FOREIGN KEY (channelID) REFERENCES Channel ON DELETE CASCADE
FOREIGN KEY (streamID) REFERENCES Stream ON DELETE CASCADE
);
CREATE TABLE SubscribesTo(
 channelID int,
 userName char[30],
 PRIMARY KEY(userName, channelID)
 FOREIGN KEY (channelID) REFERENCES Channel ON DELETE CASCADE
 FOREIGN KEY (userName) REFERENCES Viewer ON DELETE CASCADE
);
CREATE TABLE Views(
 streamID int NOT NULL,
 channelID int NOT NULL,
 userName char[30] NOT NULL,
 PRIMARY KEY (userName, streamID, channelID)
 FOREIGN KEY (streamID) REFERENCES Stream ON DELETE CASCADE
 FOREIGN KEY (userName) REFERENCES Viewer ON DELETE CASCADE
 FOREIGN KEY (channelID) REFERENCES Channel ON DELETE CASCADE
);

