# This project is not maintained anymore. We switched to [RDMO](https://github.com/rdmorganiser/).

# TUB-DMP

TUB-DMP is a tool for handling data management planning efficiently, based on the awesome web application framework [Laravel].

## Installation

TUB-DMP 2.1 is a web application, implemented in [Laravel] 5.5

### Prerequisites
TUB-DMP has several requirements:
* Linux, Webserver (Apache2), PHP7.1
* Database of your choice, preferably PostgreSQL

### Installation
The script takes care of most configuration steps.
Tricky parts like authentication (Shibboleth only at the moment) 
and the import from data sources are described below.

1. Create database with user
2. Copy .env.example to .env
3. Modify it to your needs (mainly database setup)
4. cd installer && chmod u+x install.sh && ./install.sh

Note: Only PostgreSQL and MySQL are currently supported in the installer script._

### Activate Data Source Imports
Tricky part: In order to import project metadata from external source you might have to configure ODBC:

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

### Authentication: Shibboleth ###
Shibboleth is enabled by default. You could also fall back to the built-in [Laravel Authentication] with passwords,
remember tokens, registration.

**An upcoming version of the installer script will handle this automatically!**

##### Modify config/shibboleth.php #####
For testing out the Shibboleth authentication in an environment without working IdP, you can use Shibalike.
Just switch the setting "emulate_idp":
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
```

It's crucial to map the incoming Shibboleth attributes (or the simulated Shibalike attributes, see above) to the attributes of your User model:
```php
Just switch the setting "emulate_idp":
'user' => [
    // fillable user model attribute => server variable
    'email'       => 'mail',
    'tub_om'      => 'tubPersonOM',
    'first_name'  => 'givenName',
    'last_name'   => 'sn',
    'institution_identifier' => 'tubPersonKostenstelle',
],
```

##### Modify app/Library/ShibbolethController.php #####

```php
if ($user->is_admin) {
    $user->last_login = null;
} else {
    $user->last_login = Carbon::now();
}

$user->save();
$user_name = $map['first_name'] . ' ' . $map['last_name'];
$institution_identifier = $map['institution_identifier'];
session(['name' => $user_name]);
session(['institution_identifier' => $institution_identifier]);

$user->last_login = Carbon::now();
$user->save();
$user_name = $map['first_name'] . ' ' . $map['last_name'];
$institution_identifier = $map['institution_identifier'];
session(['name' => $user_name]);
session(['institution_identifier' => $institution_identifier]);
```

##### Check app/User.php #####
Check fillable array near the top.
Check also attribute methods for values that shall not end up in the TUB-DMP database (for privacy reasons).

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

### Finish
This should be it. TUB-DMP should work now.

### License

TUB-DMP is open-sourced software licensed under the MIT license.
TUB-DMP is open to contribution. [Contact us] or [Fork].

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

   [TUB-DMP]: <https://dmp.tu-berlin.de>
   [Gitlab]: <https://gitlab.tubit.tu-berlin.de/onIT/tub-dmp.git>
   [Laravel]: <http://www.laravel.com>
   [Composer]: <http://getcomposer.org>
   [Ace Editor]: <http://ace.ajax.org>
   [node.js]: <http://nodejs.org>
   [Twitter Bootstrap]: <http://twitter.github.com/bootstrap/>
   [jQuery]: <http://jquery.com>
   [Yarn]: <https://yarnpkg.com>
   [npm]: <https://www.npmjs.com/>
   
   [Laravel Authentication]: https://laravel.com/docs/5.5/authentication
   [Node, NVM, NPM]: http://yoember.com/nodejs/the-best-way-to-install-node-js/
   
   [Contact us]: mailto:fabian.fuerste@tu-berlin.de
   [Fork]: <https://gitlab.tubit.tu-berlin.de/onIT/tub-dmp.git>
