--
-- Create databasteknik and use it.
--
CREATE DATABASE IF NOT EXISTS databasteknik;

USE databasteknik;

SET NAMES utf8;

--
-- Create the table Category
--

DROP TABLE IF EXISTS Category;
CREATE TABLE Category (
	`categoryID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `categoryName` VARCHAR(80) UNIQUE NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Subcategory
--

DROP TABLE IF EXISTS Subcategory;
CREATE TABLE Subcategory (
	`subcategoryID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `subcategoryName` VARCHAR(80) UNIQUE NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Product
--

DROP TABLE IF EXISTS Product;
CREATE TABLE Product (
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
    `productCategory` INTEGER,
    `productSubcategory` INTEGER
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Customer
--

DROP TABLE IF EXISTS Customer;
CREATE TABLE Customer (
	`customerID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `customerFirstName` VARCHAR(40) NOT NULL,
    `customerSurName` VARCHAR(80) NOT NULL,
    `customerPhone` VARCHAR(40),
    `customerMail` VARCHAR(80) NOT NULL,
    `customerGender` INTEGER,
    `customerAddress` VARCHAR (120) NOT NULL,
    `customerMailingAddress` INTEGER NOT NULL,
    `customerCity` VARCHAR(80) NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Buyer
--

CREATE TABLE Buyer (
	`buyerID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `buyerFirstName` VARCHAR(40) NOT NULL,
    `buyerSurName` VARCHAR(80) NOT NULL,
    `buyerPhone` VARCHAR(40),
    `buyerMail` VARCHAR(80) NOT NULL,
    `buyerGender` INTEGER,
    `buyerAddress` VARCHAR (120) NOT NULL,
    `buyerMailingAddress` INTEGER NOT NULL,
    `buyerCity` VARCHAR(80) NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Management
--

CREATE TABLE Management (
	`managementID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `managementFirstName` VARCHAR(40) NOT NULL,
    `managementSurName` VARCHAR(80) NOT NULL,
    `managementPhone` VARCHAR(40),
    `managementMail` VARCHAR(80) NOT NULL,
    `managementGender` INTEGER,
    `managementAddress` VARCHAR (120) NOT NULL,
    `managementMailingAddress` INTEGER NOT NULL,
    `managementCity` VARCHAR(80) NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Purchase
-- WORK IN PROGRESS
--

DROP TABLE IF EXISTS Purchase;
CREATE TABLE Purchase (
	`purchaseID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `customerID` INTEGER NOT NULL,
    `purchaseTime` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Create the table Coupons
--

DROP TABLE IF EXISTS Coupon;
CREATE TABLE Coupon (
	`couponID` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `couponName` VARCHAR(20) UNIQUE,
    `couponAmount` INTEGER,
    `startDate` DATETIME,
    `finishDate` DATETIME
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;