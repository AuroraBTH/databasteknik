# itsec - Test Application

This repository contains the application used in kmom03 in the course "Information Security with Web Applications" (DV1616).

## Requirements

To run the application, the user needs to have Docker installed.

## Installation

To start the application, navigate to the application folder and run:

```
docker-compose up -d
```

### MariaDB

Once running, you can access the database with: `mysql:host=itsec-anax-db;` or by browsing to `http://localhost:8081/` to access an instance of [Adminer](https://www.adminer.org/).

The default login is `root/example` but can be changed at [line 14](https://github.com/dbwebb-se/itsec-app/blob/7fe04fd991dfb56cc85ae157741659d8c10a255f/docker-compose.yml#L14) in `docker-compose.yml`.

#### SQL

The application will not load without the basic categories and these can be added by running `sql/restore.sql` either via `docker exec` or by using Adminer.

## Usage

The website can be accessed by browsing to http://localhost:8082/ in your preferred browser.

### Note

The database container is using a consistent volume.

## Credits

Original work done by Niklas Andersson ([AuroraBTH](https://github.com/AuroraBTH)) and Magnus Greiff ([MagnusGreiff](https://github.com/MagnusGreiff)), now maintained by the [dbwebb-team](https://github.com/dbwebb-se/).
