USE databasteknik;

SET NAMES utf8;

INSERT INTO Category (
    `categoryName`
) VALUES ("Tröja");

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
    `productCategoryID`
) VALUES ("HM", "En fin tröja", "Sweden", 200, "M", 200, 100, "Lila", 100, 1);

INSERT INTO Role (
    `roleID`,
    `roleName`
) VALUES (0, "admin");

INSERT INTO User (
    `userFirstName`,
    `userSurName`,
    `userMail`,
    `userAddress`,
    `userMailingAddress`,
    `userCity`,
    `userRole`,
    `userPassword`
) VALUES ("Carl", "Svensson", "carl.svensson@outlook.com", "Drottningsgatan 13", 37140, "Karlskrona", 0, 'hej123');

INSERT INTO Coupon (
    `couponName`,
    `couponAmount`
) VALUES ("TISDAG", 20);

INSERT INTO Orders (
    `userID`,
    `couponID`
) VALUES (1, 1);

INSERT INTO OrderItem (
    `orderID`,
    `productID`,
    `productAmount`
) VALUES (1, 1, 2);
