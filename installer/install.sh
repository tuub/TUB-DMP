#! /usr/bin/env bash

## TUB-DMP Installer
## Usage: xxx
##
#?
echo
echo -e "TUB-DMP-INSTALLER"
echo -e "(C) 2018 UB TU Berlin."
echo
echo -e "The following script might need require curl to install missing libs."
echo -e "The following script might need require sudo rights to install missing libs."
echo
source env.cfg
shopt -s extglob

cd $APP_ROOT

# .env Check
if [ ! -f .env ]; then
    echo -n "The file \".env\" is not present. Creating one with default values ... "
    #cp .env.example .env
    echo -n "OK"
    echo
    echo -e "Now: Please edit the newly created file with your data, especially the database credentials."
    echo -e "----------------------------------"
    echo -e ">>> BYE <<<"
    echo -e "----------------------------------"
    exit 1
fi

# Assign config variables
while IFS=" = " read key value
do
    # Trim leading whistespace from values

    # Continue only with set keys and non-comments.
    # Attention: variable assignment fails with spaces around =
    if [[ ! -z "$key" && ${key} != *"#"* ]]; then
        if [ $key = "DB_CONNECTION" ]; then
            DB_DRIVER="$value"
        elif [ $key = "DB_HOST" ]; then
            DB_HOST="$value"
        elif [ $key = "DB_DATABASE" ]; then
            DB_NAME="$value"
        elif [ $key = "DB_USERNAME" ]; then
            DB_USER="$value"
        elif [ $key = "DB_PASSWORD" ]; then
            DB_PASSWORD="$value"
        fi
    fi
done < ".env"

echo


# Display config
echo -e "--------------------------------------------------------------------"
echo -e "CONFIGURATION TO BE USED"
echo -e "--------------------------------------------------------------------"

echo -e "* Driver: $DB_DRIVER"
echo -e "* Host: $DB_HOST"
echo -e "* Database: $DB_NAME"
echo -e "* User: $DB_USER"
echo -e "* Database Reset: $DB_RESET"
echo -e "* PHP Version: $PHP_VERSION"

echo
read -e -p "Continue? [y,n]: " CONTINUE
echo

if [[ "$CONTINUE" == [Yy] ]]; then

    echo -e "--------------------------------------------------------------------"
    echo -e "SYSTEM CHECK"
    echo -e "--------------------------------------------------------------------"

    # PHP Check
    echo -n "Checking PHP $PHP_VERSION libraries ... "
    for PHP_LIB in $PHP_LIBS; do
        if [ $(dpkg-query -l | grep "php$PHP_VERSION-$PHP_LIB" | wc -l) = 0 ]; then
                sudo apt install -qy $i
                RELOAD_SERVER=true
        fi
        if [ $(dpkg-query -l | grep "php$PHP_VERSION-$DB_DRIVER" | wc -l) = 0 ]; then
                sudo apt install -qy $i
                RELOAD_SERVER=true
        fi
    done
    echo -n "OK"

    # ImageMagick Check
    echo
    echo -n "Checking ImageMagick ... "
        if [ $(dpkg-query -l | grep "imagemagick" | wc -l) = 0 ]; then
                sudo apt install -qy $i
                RELOAD_SERVER=true
        fi
        if [ $(dpkg-query -l | grep "php-imagick" | wc -l) = 0 ]; then
                sudo apt install -qy $i
                RELOAD_SERVER=true
        fi
    echo -n "OK"

    # Enable Apache2 Rewrite Module
    if [ ! -r "/etc/apache2/mods-enabled/rewrite.load" ]; then
        echo
        echo -n "Enabling Apache2 Rewrite Module ... "
        sudo a2enmod rewrite
        RELOAD_SERVER=true
        echo -n "OK"
    fi

    if [ "$RELOAD_SERVER" = true ]; then
            echo
            echo -n "Reloading Apache2 ... "
            sudo service apache2 reload
            echo -n "OK"
    fi

    echo
    echo

    echo -e "--------------------------------------------------------------------"
    echo -e "ENVIRONMENT CHECK"
    echo -e "--------------------------------------------------------------------"

    # Composer Check
    if hash composer 2>/dev/null; then
        echo -e "* Composer installation found."
    else
        echo -e "> Composer is not present. Downloading and installing ... "
        curl -s http://getcomposer.org/installer | /usr/bin/php
        echo -n "OK"
    fi

    # NPM Check
    if hash npm 2>/dev/null; then
        echo -e "* NPM installation found."
    else
        echo -e "> NPM is not present. Downloading and installing ... "
        sudo apt-get install build-essential libssl-dev
        curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.33.8/install.sh -o install_nvm.sh
        sudo chmod u+x install_nvm.sh
        ./install_nvm.sh # Detached state is fine here
        source ~/.profile | source ~/.zshrc | source ~/.bashrc
        nvm install 8.9.4
        nvm use default 8.9.4
        echo -n "OK"
    fi

    # Yarn Check
    if hash yarn 2>/dev/null; then
        echo -e "* Yarn installation found."
    else
        echo -e "> Yarn is not present. Downloading and installing ... "
        curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
        echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
        sudo apt-get update && sudo apt-get install --no-install-recommends yarn
        echo -n "OK"
    fi

    echo

    echo -e "--------------------------------------------------------------------"
    echo -e "INSTALL DEPENDENCIES"
    echo -e "--------------------------------------------------------------------"

    # Run Composer
    echo -n "* Installing dependencies via Composer ... "
    #composer -q install
    echo -n "OK"

    # Run NPM
    echo
    echo -n "* Installing assets via NPM ... "
    #npm --quiet --silent --no-progress install > "/dev/null" 2>&1
    echo -n "OK"

    # Run Yarn
    echo
    echo -n "* Compiling assets via Yarn ... "
    #yarn -s install > "/dev/null" 2>&1
    #yarn -s run prod > "/dev/null" 2>&1
    echo -n "OK"

    echo
    echo

    echo -e "--------------------------------------------------------------------"
    echo -e "INITIALIZE APPLICATION"
    echo -e "--------------------------------------------------------------------"

    # Create App Key
    php artisan key:generate

    echo

    echo -e "--------------------------------------------------------------------"
    echo -e "SETUP DATABASE"
    echo -e "--------------------------------------------------------------------"

    if [ "$DB_RESET" = true ]; then

        # PGOPTIONS='--client-min-messages=warning' psql -d mydb -q -f dump.sql
        # Switch mysql and Postgres

        if [ ${DB_DRIVER} = "pgsql" ]; then
            DB_EXISTS="sudo -u postgres psql -lqt | cut -d \| -f 1 | grep -qw ${DB_NAME}"
            DB_USER_EXISTS="sudo -u postgres psql -t -c '\du' | cut -d \| -f 1 | grep -qw ${DB_USER}"
            DB_DROP_CMD="sudo -u postgres psql -q -c 'DROP DATABASE \"${DB_NAME}\"'"
            DB_CREATE_CMD="sudo -u postgres psql -q -c 'CREATE DATABASE \"${DB_NAME}\"'"
            DB_UUID_CMD="sudo -u postgres psql -q -d ${DB_NAME} -c 'CREATE EXTENSION IF NOT EXISTS \"uuid-ossp\"'"
            DB_DELETE_USER_CMD="sudo -u postgres psql -q -c 'DROP ROLE IF EXISTS ${DB_USER}'"
            DB_CREATE_USER_CMD="sudo -u postgres psql -q -c \"CREATE USER ${DB_USER} WITH PASSWORD '${DB_PASSWORD}'\""
            DB_GRANT_USER_CMD="sudo -u postgres psql -q -c 'GRANT ALL PRIVILEGES ON DATABASE \"${DB_NAME}\" TO ${DB_USER}'"
        elif [ ${DB_DRIVER} = "mysql" ]; then
            DB_EXISTS="mysql -u ${DB_USER} -p${DB_PASSWORD} -e \"SHOW DATABASES\" | grep $DB_NAME"
            DB_USER_EXISTS="mysql -u ${DB_USER} -p${DB_PASSWORD} -e \"DROP USER IF EXISTS '$DB_USER'@'$DB_HOST'\""
            DB_DROP_CMD="mysql -u ${DB_USER} -p${DB_PASSWORD} -e \"DROP DATABASE \"$DB_NAME\"\""
            DB_CREATE_CMD="mysql -u ${DB_USER} -p${DB_PASSWORD} -e \"CREATE DATABASE \"$DB_NAME\"\""
            DB_UUID_CMD=""
            DB_DELETE_USER_CMD="mysql -u ${DB_USER} -p${DB_PASSWORD} -e \"DROP USER '$DB_USER'@'$DB_HOST'\""
            DB_CREATE_USER_CMD="mysql -u ${DB_USER} -p${DB_PASSWORD} -e \"CREATE USER '$DB_USER'@'$DB_HOST' IDENTIFIED BY '$DB_PASSWORD'\""
            DB_GRANT_USER_CMD="mysql -u ${DB_USER} -p${DB_PASSWORD} -e \"GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'$DB_HOST'\""
        else
            echo -e "Your database is not yet supported by this script. Exit."; exit 1
        fi

        if eval ${DB_EXISTS}; then
            echo -n "* Dropping database \"$DB_NAME\" ... "
            eval ${DB_DROP_CMD}
            echo -n "OK"
            echo
        fi

        echo -n "* Creating database \"$DB_NAME\" ... "
        eval ${DB_CREATE_CMD}
        echo -n "OK"

        echo
        echo -n "* Enabling UUID support on \"$DB_NAME\" ... "
        eval ${DB_UUID_CMD}
        echo -n "OK"

        echo
        echo -n "* Adding user \"$DB_USER\" ... "
        if eval ${DB_USER_EXISTS}; then
            eval ${DB_DELETE_USER_CMD}
        fi
        eval ${DB_CREATE_USER_CMD}
        echo -n "OK"

        echo
        echo -n "* Granting user \"$DB_USER\" the privileges to database  \"$DB_NAME\" ... "
        eval ${DB_GRANT_USER_CMD}
        echo -n "OK"
    fi

    # Run migrations
    echo
    echo -n "* Running migrations on database \"$DB_NAME\" ... "
    php artisan -q migrate
    echo -n "OK"

    # Seed the database
    echo
    echo -n "* Seeding the database \"$DB_NAME\" ... "
    php artisan -q db:seed
    echo -n "OK"

    echo
    echo

    echo -e "--------------------------------------------------------------------"
    echo -e "SETUP FILESYSTEM"
    echo -e "--------------------------------------------------------------------"

    echo -n "* Setting permissions to \"bootstrap/cache\" and \"storage\" and \"public\" ... "
    #mysql -u $target_db_user -p$target_db_pw -e "DROP DATABASE $DB_NAME"
    sudo chmod -R 755 $APP_ROOT/bootstrap/cache
    sudo chmod -R 755 $APP_ROOT/storage
    sudo chmod -R 755 $APP_ROOT/public
    echo -n "OK"

    echo
    echo -n "* Copying Auth Controller ... "
    #mysql -u $target_db_user -p$target_db_pw -e "DROP DATABASE $DB_NAME"
    cp $APP_ROOT/app/Library/ShibbolethController.php $APP_ROOT/vendor/razorbacks/laravel-shibboleth/src/StudentAffairsUwm/Shibboleth/Controllers/ShibbolethController.php
    echo -n "OK"

    echo
    echo

    echo -e "--------------------------------------------------------------------"
    echo -e "RUN APPLICATION"
    echo -e "--------------------------------------------------------------------"

    echo -e "TUB-DMP is now ready to use."
    echo -e "A default user has been created: Username: dmp / Password: dmp"
    echo
    echo -e "For a quick glance please go to $APP_ROOT and fire off php artisan server."
    echo
    echo -e "For a real server setup please use Apache or Nginx with the basic configuration:"
    echo
    echo -e "
    <VirtualHost *:80>
        ServerName dmp.localhost
        DocumentRoot \"${APP_ROOT}/public/\"
        ServerAdmin webmaster@localhost

        <Directory \"${APP_ROOT}/public\">
                AllowOverride all
                Require all granted
        </Directory>
    </VirtualHost>
    "
    echo
    echo -e "Login: dmp / dmp"
    echo
else
    echo -e "--------------------------------------------------------------------"
    echo -e ">>> BYE <<<"
    echo -e "--------------------------------------------------------------------"
    exit 1
fi
