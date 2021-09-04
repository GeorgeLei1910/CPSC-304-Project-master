CREATE TABLE CountryInfo(
	country char(3) PRIMARY KEY,
	currency char(3) NOT NULL
);

CREATE TABLE CardInfo(
	cardNumber char(16) PRIMARY KEY,
	country char(3) NOT NULL,
	cardType varchar(16) NOT NULL,
	CVV char(3) NOT NULL,
	FOREIGN KEY (country) REFERENCES CountryInfo(country)
);

CREATE TABLE Members(
	userName varchar(30) PRIMARY KEY,
	displayName varchar(30),
	email varchar(50) UNIQUE,
	joinDate date NOT NULL,
	cardNumber char(16) DEFAULT NULL,
	FOREIGN KEY(cardNumber) REFERENCES CardInfo(cardNumber)
);

CREATE TABLE Viewer(
	userName varchar(30) PRIMARY KEY,
	loadedBalance int DEFAULT 0,
	FOREIGN KEY (userName) REFERENCES Members(userName) ON DELETE CASCADE
);

CREATE TABLE Channel(
	channelID int PRIMARY KEY,
	channelName varchar(50) NOT NULL
);

CREATE TABLE Streamer(
	userName varchar(30) PRIMARY KEY,
	totalEarnings int DEFAULT 0,
	channelID int NOT NULL UNIQUE,
	FOREIGN KEY (userName) REFERENCES Members(userName) ON DELETE CASCADE,
	FOREIGN KEY (channelID) REFERENCES Channel(channelID)
);

CREATE TABLE Sponsor(
	sponsorID int PRIMARY KEY,
	sponsorName varchar(50) NOT NULL,
	sponsorType varchar(50) DEFAULT NULL,
	sponsorURL varchar(50) DEFAULT NULL
);

CREATE TABLE Stream(
	streamID int,
	channelID int,
	streamTitle varchar(80),
	streamDate date,
	totalDonations int DEFAULT 0,
	totalUniqueViewers int DEFAULT 0,
	maxConcurrentViewers int DEFAULT 0,
	sponsorID int DEFAULT NULL,
	PRIMARY KEY (channelID, streamID),
	FOREIGN KEY (channelID) REFERENCES Channel(channelID) ON DELETE CASCADE,
	FOREIGN KEY (sponsorID) REFERENCES Sponsor(sponsorID) ON DELETE SET NULL
);

CREATE TABLE Genre(
	genreType char(30) PRIMARY KEY
);

CREATE TABLE GameCompany(
	companyID int PRIMARY KEY,
	companyName varchar(80)
);

CREATE TABLE GamePublisher(
	companyID int PRIMARY KEY,
	FOREIGN KEY (companyID) REFERENCES GameCompany(companyID) ON DELETE CASCADE
);

CREATE TABLE PlatformManufacturer(
	companyID int PRIMARY KEY,
	FOREIGN KEY (companyID) REFERENCES GameCompany(companyID) ON DELETE CASCADE
);

CREATE TABLE Series(
	seriesID int PRIMARY KEY,
	seriesName varchar(80),
	gameID int NOT NULL,
	companyID int NOT NULL,
	/* FOREIGN KEY (gameID) REFERENCES Game(gameID), */
	FOREIGN KEY (companyID) REFERENCES GamePublisher(companyID)
);

CREATE TABLE Game(
	gameID int PRIMARY KEY,
	gameTitle varchar(80),
	releaseDate date,
	seriesID int DEFAULT NULL,
	isFirstEntry bool DEFAULT FALSE,
	companyID int NOT NULL,
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID) ON DELETE SET NULL,
	FOREIGN KEY (companyID) REFERENCES GamePublisher(companyID)
);


/* Circular REFERENCES for Game and Series resolved with: */
/* https://stackoverflow.com/a/52377557 */
ALTER TABLE Series ADD FOREIGN KEY (gameID) REFERENCES Game(gameID);

CREATE TABLE Platform(
	platformID int PRIMARY KEY,
	platformName varchar(50),
	releaseDate date,
	platformType varchar(30),
	companyID int NOT NULL,
	FOREIGN KEY (companyID) REFERENCES PlatformManufacturer(companyID)
);


CREATE TABLE Rates(
	userName varchar(30),
	gameID int,
	rating int,
	comments varchar(500),
	PRIMARY KEY (userName, gameID),
	FOREIGN KEY (userName) REFERENCES Members(userName) ON DELETE CASCADE,
	FOREIGN KEY (gameID) REFERENCES Game(gameID) ON DELETE CASCADE
);

CREATE TABLE TypeOf(
	gameID int NOT NULL,
	genreType varchar(30) NOT NULL,
	PRIMARY KEY (gameID, genreType),
	FOREIGN KEY (gameID) REFERENCES Game(gameID) ON DELETE CASCADE,
	FOREIGN KEY (genreType) REFERENCES Genre(genreType) on DELETE CASCADE
);

CREATE TABLE AvailableOn(
	platformID int,
	gameID int,
	PRIMARY KEY(platformID, gameID),
	FOREIGN KEY(platformID) REFERENCES Platform(platformID) ON DELETE CASCADE,
	FOREIGN KEY(gameID) REFERENCES Game(gameID) ON DELETE CASCADE
);

CREATE TABLE GameplayOf(
	streamID int,
	channelID int,
	gameID int,
	PRIMARY KEY (gameID, streamID, channelID),
	FOREIGN KEY (gameID) REFERENCES Game(gameID),
	FOREIGN KEY (channelID, streamID) REFERENCES Stream(channelID, streamID) ON DELETE CASCADE
);

CREATE TABLE SubscribesTo(
	channelID int,
	userName varchar(30),
	PRIMARY KEY(userName, channelID),
	FOREIGN KEY (channelID) REFERENCES Channel(channelID) ON DELETE CASCADE,
	FOREIGN KEY (userName) REFERENCES Viewer(userName) ON DELETE CASCADE
);

CREATE TABLE StreamViews(
	streamID int,
	channelID int,
	userName varchar(30),
	PRIMARY KEY(userName, streamID, channelID),
	FOREIGN KEY (userName) REFERENCES Viewer(userName) ON DELETE CASCADE,
	FOREIGN KEY (channelID, streamID) REFERENCES Stream(channelID, streamID) ON DELETE CASCADE
);


