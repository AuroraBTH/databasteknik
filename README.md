[![Build Status](https://travis-ci.org/aurora-munge/databasteknik.svg?branch=master)](https://travis-ci.org/aurora-munge/databasteknik)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aurora-munge/databasteknik/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aurora-munge/databasteknik/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/18225f2d9efa471bb2469e4b57218b48)](https://www.codacy.com/app/MagnusGreiff/databasteknik?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=aurora-munge/databasteknik&amp;utm_campaign=Badge_Grade)

# Databasteknik

This repo will contain the base for the project in the course Databasteknik.

## Installation

To install, run the following command to download the dependencies needed.

* ```make install-dep```

To create the tables needed in your database, run the following SQL-file:

* ```sql/tables.sql```

And to fill it with data:

* ```sql/data.sql```

## Testing

Run the following commands to download the necessary tools and validate the repo.

* ```make install```
* ```make test```

## Credits

Maintained by Niklas Andersson ([AuroraBTH](https://github.com/AuroraBTH)) and Magnus Greiff ([MagnusGreiff](https://github.com/MagnusGreiff)).
