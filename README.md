# PHP, MariaDB Login & Register System

---

### Getting Started
You should already have a LAMP stack installed and configured on your server. 
Then you will want to `cd` to your DocumentRoot and clone the repository.
```bash
cd /var/www/html
git clone 
```

The `inc` directory should go where your PHP includes directory is. Enter the following command to find
that directory.
```bash
php -i | grep "include_path"

# Returns
# include_path => .:/usr/share/php => .:/usr/share/php
```

### Configure Database
```mysql
CREATE DATABASE accounts;
USE accounts;
GRANT ALL PRIVILEGES ON accounts.* TO "admin"@"localhost" IDENTIFIED BY "StRoNgPaSsWoRdHeRe";
FLUSH PRIVILEGES;
```

Then run the commands in the `users.sql` file to create the users table.

### Configuration

**File:**
`inc/db_connect.php`
1. Line 5 - Database username if not admin
2. Line 6 - Database username password

`inc/functions.php`
1. Line 28 - Replace Site Name with your Domain Name

`inc/navbar.php`
1. Line 3 - Replace Example.com with your Domain Name

`login.php`
1. Line 46 - Replace Example.com with your Domain Name

`index.php`
1. Line 4 - Replace Example.com with your Domain Name

`register.php`
1. Line 49 - Replace Example.com with your Domain Name
2. Line 54 - Change the From Email Address
3. Line 55 - Change the Reply-To Email Address
4. Line 73 - Replace Example.com with your Domain Name