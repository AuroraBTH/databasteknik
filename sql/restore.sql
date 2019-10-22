DROP DATABASE IF EXISTS itsec;
CREATE DATABASE itsec;

USE itsec;

SET NAMES utf8;

--
-- Create the table Category
--

CREATE TABLE IF NOT EXISTS Category (
	`categoryID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `categoryName` VARCHAR(80) NOT NULL,
	`parentID` INTEGER DEFAULT NULL,
	`gender`   INTEGER NOT NULL
);

--
-- Create the table Product
--

CREATE TABLE IF NOT EXISTS Product (
	`productID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `productManufacturer` VARCHAR(80) NOT NULL,
    `productName` VARCHAR(80) NOT NULL,
    `productOriginCountry` VARCHAR(40) NOT NULL,
    `productWeight` INTEGER NOT NULL,
    `productSize` VARCHAR(3) NOT NULL,
    `productSellPrize` INTEGER NOT NULL,
    `productBuyPrize` INTEGER NOT NULL,
    `productColor` VARCHAR(20) NOT NULL,
    `productAmount` INTEGER,
    `productCategoryID` INTEGER,
	`productGender`   INTEGER NOT NULL,
    `productDeleted`  VARCHAR(5) NOT NULL,
	FOREIGN KEY (`productCategoryID`) REFERENCES Category(`categoryID`)
);

--
-- Create the table Role
--

CREATE TABLE IF NOT EXISTS Role (
	`roleID` INTEGER PRIMARY KEY NOT NULL,
	`roleName` VARCHAR(80) NOT NULL
);

--
-- Create the table User
--

CREATE TABLE IF NOT EXISTS User (
	`userID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `userFirstName` VARCHAR(40) NOT NULL,
    `userSurName` VARCHAR(80) NOT NULL,
    `userPhone` VARCHAR(40),
    `userMail` VARCHAR(80) NOT NULL,
    `userGender` INTEGER,
    `userAddress` VARCHAR (120) NOT NULL,
    `userPostcode` INTEGER NOT NULL,
    `userCity` VARCHAR(80) NOT NULL,
	`userRole` INTEGER NOT NULL DEFAULT 0,
	`userPassword` VARCHAR(255) NOT NULL,
	FOREIGN KEY (`userRole`) REFERENCES Role(`roleID`)
);

--
-- Create the table Coupons
--

CREATE TABLE IF NOT EXISTS Coupon (
	`couponID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `couponName` VARCHAR(64) UNIQUE,
    `couponAmount` INTEGER,
    `startDate` DATETIME,
    `finishDate` DATETIME
);


--
-- Create the table Orders
-- https://github.com/canax/database/issues/1#issuecomment-338931447
--

CREATE TABLE IF NOT EXISTS Orders (
	`orderID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `userID` INTEGER NOT NULL,
    `purchaseTime` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`sentTime` DATETIME NULL,
	`couponID` INTEGER,
	`orderStatus` VARCHAR(40),
	`price` INTEGER,
	FOREIGN KEY (`userID`) REFERENCES User(`userID`),
	FOREIGN KEY (`couponID`) REFERENCES Coupon(`couponID`)
);

--
-- Create the table OrderItem
--

CREATE TABLE IF NOT EXISTS OrderItem (
	`orderID` INTEGER NOT NULL,
	`productID` INTEGER NOT NULL,
	`productAmount` INTEGER NOT NULL,
	PRIMARY KEY (`orderID`, `productID`),
	FOREIGN KEY (`orderID`) REFERENCES Orders(`orderID`),
	FOREIGN KEY (`productID`) REFERENCES Product(`productID`)
);

INSERT INTO Category (
    `categoryName`,
    `gender`
) VALUES ("Byxor", 0), ("Tröjor", 0), ("Jackor", 0), ("Underkläder", 0), ("Klänningar", 0), ("Väskor", 0), ("Byxor", 1), ("Tröjor", 1), ("Underkläder", 1), ("Jackor", 1), ("Väskor", 1);

INSERT INTO Product(
    `productManufacturer`,
    `productName`,
    `productOriginCountry`,
    `productWeight`,
    `productSize`,
    `productSellPrize`,
    `productBuyPrize`,
    `productColor`,
    `productAmount`,
    `productCategoryID`,
    `productGender`,
    `productDeleted`
) VALUES ("HM", "En fin tröja", "Sweden", 200, "M", 200, 100, "Lila", 100, 1, 0, "false");

INSERT INTO Role (
    `roleID`,
    `roleName`
) VALUES (0, "user"), (1, "admin"), (2, "management");

INSERT INTO User (
    `userFirstName`,
    `userSurName`,
    `userPhone`,
    `userMail`,
    `userAddress`,
    `userPostcode`,
    `userCity`,
    `userRole`,
    `userPassword`
) VALUES ("Carl", "Svensson", 123, "carl.svensson@outlook.com", "Drottningsgatan 13", 37140, "Karlskrona", 0, 'hej123'), ("Admin", "Adminson", 123, "admin@admin.com", "Admingatan 22", 12345, "Karlskrona", 1, '$2y$10$Jxu9IJZukqkXyUUB0RhXuOxEBtDo7O6LtuWjIYNzJeDtqpI9hh9Q.'),
("Company", "Management", 123, "cm@cm.com", "Companygatan 11", 12222, "Karlskrona", 2, "$2y$10$Jxu9IJZukqkXyUUB0RhXuOxEBtDo7O6LtuWjIYNzJeDtqpI9hh9Q.");

INSERT INTO `Coupon` (
    `couponName`,
    `couponAmount`,
    `startDate`,
    `finishDate`
) VALUES ('HELG',	120, '1999-01-01 00:00:00',	'2999-01-01 00:00:00');

INSERT INTO Orders (
    `userID`,
    `couponID`
) VALUES (1, 1);

INSERT INTO OrderItem (
    `orderID`,
    `productID`,
    `productAmount`
) VALUES (1, 1, 2);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Shorts", 0, 1);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Jeans", 0, 1);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Träningsbyxor", 0, 1);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Trosor", 0, 4);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("BH", 0, 4);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Nattlinnen", 0, 4);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("T-shirt", 0, 2);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Sweatshirt", 0, 2);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Cardigans", 0, 2);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Linnen", 0, 2);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Långklänningar", 0, 5);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Korta klänningar", 0, 5);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Vinterjackor", 0, 3);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Skinnjackor", 0, 3);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Övriga jackor", 0, 3);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Skinnväskor", 0, 6);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Ryggsäckar", 0, 6);

-- --

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Shorts", 1, 7);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Jeans", 1, 7);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Träningsbyxor", 1, 7);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("T-shirt", 1, 8);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Sweatshirt", 1, 8);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Cardigans", 1, 8);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Linnen", 1, 8);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Y-front", 1, 9);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Boxershort", 1, 9);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Vinterjackor", 1, 10);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Skinnjackor", 1, 10);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Övriga jackor", 1, 10);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Kostymer", 1, 10);

INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Skinnväskor", 1, 11);
INSERT INTO Category (`categoryName`, `gender`, `parentID`) VALUES ("Ryggsäckar", 1, 11);
