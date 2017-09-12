# TUB-DMP

TUB-DMP is a tool for handling data management planning efficiently, based on the web application framework Laravel 5.2

## Installation

TUB-DMP is a web application, implemented in [Laravel] 5.

### Prerequisites
TUB-DMP has several requirements:
* Linux, Apache2, Database, PHP>5.5, PDO-Driver, php-mbstring, php-xml, php-mcrypt
* [Node, NVM, NPM](http://yoember.com/nodejs/the-best-way-to-install-node-js/)
* [Composer]
* VirtualHost Configuration (see below for example)
* sudo a2enmod rewrite && sudo service apache2 restart

`Example Apache2 config`:
 ```sh
<VirtualHost *:80>
    ServerName dmp.localhost
    DocumentRoot "/srv/tub-dmp/public/"
    ServerAdmin webmaster@localhost
 
    <Directory "/srv/tub-dmp/public">
            AllowOverride all
            Require all granted
    </Directory>
</VirtualHost>
```

`3rd party components`:
* [Twitter Bootstrap] - UI boilerplate for modern web apps
* [Composer] - PHP Dependency Manager
* [npm] - node.js based Packet Manager
* [Gulp] - Streaming Build System
* [jQuery] - JS Framework
* [Bower] - Assets Dependency Manager

### Installation of main app
1. Clone the git repository to your web root: git clone git@gitlab.tubit.tu-berlin.de:onIT/tub-dmp.git
2. Create a database ("tub-dmp" for example) and setup user permissions
3. Copy the environment file: cp .env.example .env
4. Modify .env with your database credentials
5. Review the files in the config directory, e.g. session.php
6. Copy the environment js file: cp resources/assets/js/env.example.js resources/assets/js/env.js
7. Modify the paths in /resources/assets/js/env.js to your environment
8. Set permissions: chmod -R 777 storage

### Installation of vendor components
1. Run composer: composer install --no-scripts && composer update
2. Run NPM: npm install
3. Set a new app encryption key by running: php artisan config:clear && php artisan key:generate

Installation of additional components or changes to the Assets require calling of
* bower search *query* / bower install *package*
* gulp [--production]

### Run the data migrations
1. Setup the migrations support in the database: php artisan migrate:install
2. Create the database tables: php artisan migrate
3. Insert data to the tables: php artisan db:seed

### Activate PDF support
```
sudo apt-get update
sudo apt-get install libxrender1 fontconfig xvfb
wget http://download.gna.org/wkhtmltopdf/0.12/0.12.3/wkhtmltox-0.12.3_linux-generic-amd64.tar.xz -P /tmp/
cd /opt/
sudo tar xf /tmp/wkhtmltox-0.12.3_linux-generic-amd64.tar.xz
sudo ln -s /opt/wkhtmltox/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf
```

Then add the correct pathes in config/snappy.php.

### Activate Data Source Imports
In order to import project metadata from external source you might have to configure ODBC and add a cronjob:

##### Example connection with SQL Server #####
[https://msdn.microsoft.com/de-de/library/hh568454(v=sql.110).aspx](https://msdn.microsoft.com/de-de/library/hh568454(v=sql.110).aspx)

##### Simulate external datasource with Postgresql #####

Create the new database:
```sh
sudo -u postgres createdb <DATABASE_NAME>
sudo -u postgres createuser <DATABASE_USER>
sudo -u postgres psql

postgres@COSMO:~$ psql

psql (9.5.8)
Type "help" for help.

postgres=# ALTER USER "<DATABASE_USER>" WITH PASSWORD '<DATABASE_SECRET>';
postgres=# ALTER DATABASE <DATABASE_NAME> OWNER TO <DATABASE_USER>;
```

Install ODBC drivers:
```sh
sudo apt install unixodbc php-odbc php-pgsql odbc-postgresql
```

/etc/odbcinst.ini:
```sh
[PostgreSQL ANSI]
Description=PostgreSQL ODBC driver (ANSI version)
Driver=psqlodbca.so
Setup=libodbcpsqlS.so
Debug=0
CommLog=1
UsageCount=1

[PostgreSQL Unicode]
Description=PostgreSQL ODBC driver (Unicode version)
Driver=psqlodbcw.so
Setup=libodbcpsqlS.so
Debug=0
CommLog=1
UsageCount=1
```

/etc/odbc.ini:
```sh
[PSQL_ODBC]
Description = PostgreSQL connection to AMPG961
Driver = PostgreSQL Unicode
Database = <DATABASE_NAME>
Servername = <DATABASE_HOST>
UserName = <DATABASE_USER>
Password = <DATABASE_SECRET>
Port = 5432
Protocol = <POSTGRESQL_VERSION>
ReadOnly = No
RowVersioning = No
ShowSystemTables = No
ConnSettings =
```

.env:
```sh
ODBC_DRIVER=pgsql
#ODBC_DSN=odbc:\\\\PSQL_ODBC
ODBC_DSN=odbc:PSQL_ODBC
ODBC_HOST=<DATABASE_HOST>
ODBC_USERNAME=<DATABASE_USER>
ODBC_PASSWORD=<DATABASE_SECRET>
ODBC_DATABASE=<DATABASE_NAME>
```

config/database.php:
```php
/* Example for a connection "odbc-sqlsrv" */
    'odbc-sqlsrv' => array(
        'driver'    => env('ODBC_DRIVER', 'odbc'),
        'dsn'       => env('ODBC_DSN', ''),
        'host'      => env('ODBC_HOST', ''),
        'username'  => env('ODBC_USERNAME', ''),
        'password'  => env('ODBC_PASSWORD', ''),
        'database'  => env('ODBC_DATABASE', ''),
        'grammar'   => [
            'query'  => Illuminate\Database\Query\Grammars\SqlServerGrammar::class,
            'schema' => Illuminate\Database\Schema\Grammars\SqlServerGrammar::class,
        ],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ),

/* Example for a connection "odbc-pgsql" */
    'odbc-pgsql' => array(
        'driver'    => env('ODBC_DRIVER', 'odbc'),
        'dsn'       => env('ODBC_DSN', ''),
        'host'      => env('ODBC_HOST', ''),
        'username'  => env('ODBC_USERNAME', ''),
        'password'  => env('ODBC_PASSWORD', ''),
        'database'  => env('ODBC_DATABASE', ''),
        'grammar'   => [
            'query'  => Illuminate\Database\Query\Grammars\PostgresGrammar::class,
            'schema' => Illuminate\Database\Schema\Grammars\PostgresGrammar::class,
        ],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ),
```

Temporarily set .env values to the target database and then run the seeder (there might be other and better ways like setting the option "--database='<CONNECTION_NAME>'"):
```sh
DB_CONNECTION=pgsql
DB_HOST=<DATABASE_HOST>
DB_DATABASE=<DATABASE_NAME>
DB_USERNAME=<DATABASE_USER>
DB_PASSWORD=<DATABASE_SECRET>
```

Migrate to the new database:
```sh
php artisan migrate --path=/database/migrations/odbc/
```
Seed to the new database:
```sh
composer dump-autoload && php artisan db:seed --class=IVMCDMPProjektTableSeeder
```

##### Setting up scheduler #####
```sh
* * * * * php /srv/tub-dmp/artisan schedule:run >> /dev/null 2>&1
```

### Activate Shibboleth ###

##### Modify config/shibboleth.php #####

```php
'emulate_idp'       => true,
    'emulate_idp_users' => array(
        'foo' => array(
            'uid'         => 'foo',
            'givenName'   => 'Liam',
            'sn'          => 'Gallagher',
            'o'           => 'Oasis',
            'tubPersonKostenstelle'	=> '123456',
            'tubPersonOM' => '987654321',
            'mail'        => 'liam@oasisinet.com',
        ),
        
[...]
        
'user' => [
    // fillable user model attribute => server variable
    'email'       => 'mail',
    'identifier'  => 'tubPersonOM',
    'first_name'  => 'givenName',
    'last_name'   => 'sn',
    'institution_identifier' => 'tubPersonKostenstelle',
],
```

##### Modify app/Library/ShibbolethController.php #####

```php
$user->last_login = Carbon::now();
$user->save();
$user_name = $map['first_name'] . ' ' . $map['last_name'];
$institution_identifier = $map['institution_identifier'];
session(['name' => $user_name]);
session(['institution_identifier' => $institution_identifier]);
```

##### Check app/User.php for values that shall not end up in the TUB-DMP database (in our case the name and the institution_identifier) #####
```php
public function getNameAttribute()
{
    return session()->get('name');
}

public function getInstitutionIdentifierAttribute()
{
    return session()->get('institution_identifier');
}
```

##### Overwrite vendor class with app/Library/ShibbolethController.php #####

```sh
cp app/Library/ShibbolethController.php vendor/razorbacks/laravel-shibboleth/src/StudentAffairsUwm/Shibboleth/Controllers/
```

### License

TUB-DMP is open-sourced software licensed under the MIT license.
TUB-DMP is open to Contribution. [Contact us] or fork.



[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)


   [Contact us]: mailto:fabian.fuerste@tu-berlin.de
   [TUB-DMP]: <https://dmp.tu-berlin.de>
   [Gitlab]: <https://gitlab.tubit.tu-berlin.de/onIT/tub-dmp.git>
   [Laravel]: <http://www.laravel.com>
   [Composer]: <http://getcomposer.org>
   [Ace Editor]: <http://ace.ajax.org>
   [node.js]: <http://nodejs.org>
   [Twitter Bootstrap]: <http://twitter.github.com/bootstrap/>
   [jQuery]: <http://jquery.com>
   [Gulp]: <http://gulpjs.com>
   [Bower]: <https://bower.io/>
   [npm]: <https://www.npmjs.com/>