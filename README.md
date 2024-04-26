## Project Setup

```sh
install php 8
create a localhost
```

### Create Database & Compile and Hot-Reload for Development

```sh
Import SQL file from app/setup
Enter MYSQL server credentials in app/backend/auth/config.php
```
### Note:

```sh
You may need excute this query in dabase "SET GLOBAL sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';" to execute GROUP BY queries.
```
