--
-- Create databasteknik and use it.
--

DROP DATABASE IF EXISTS databasteknik;
CREATE DATABASE IF NOT EXISTS databasteknik;

USE databasteknik;

SET NAMES utf8;

--
-- Create the table Category
--

CREATE TABLE IF NOT EXISTS Category (
	`categoryID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `categoryName` VARCHAR(80) NOT NULL,
	`parentID` INTEGER DEFAULT NULL,
	`gender`   INTEGER NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

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
	FOREIGN KEY (`productCategoryID`) REFERENCES Category(`categoryID`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Role
--

CREATE TABLE IF NOT EXISTS Role (
	`roleID` INTEGER PRIMARY KEY NOT NULL,
	`roleName` VARCHAR(80) NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

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
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Coupons
--

CREATE TABLE IF NOT EXISTS Coupon (
	`couponID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `couponName` VARCHAR(20) UNIQUE,
    `couponAmount` INTEGER,
    `startDate` DATETIME,
    `finishDate` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


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
	FOREIGN KEY (`userID`) REFERENCES User(`userID`),
	FOREIGN KEY (`couponID`) REFERENCES Coupon(`couponID`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

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
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
