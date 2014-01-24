#!/usr/bin/env bash

# Moving to codebase root now
cd /vagrant

# Firing up the Composer to install thirdparty libraries
php composer.phar install

# Note that all binaries will be installed into `bin/` under ROOT_DIR
# including phpunit, behat, phing and yiic

# Putting the Behat local config into proper place
cp -f /vagrant/{carcass/vagrant/,}behat-local.yml

# Preparing the server log directories (MUST be done before starting Apache)
# Folders should be writable by server process
#for dir in {frontend,backend,user,tech}
#do
#    for subdir in {runtime,runtime/app_logs,www/assets}
#    do
#        if [ ! -d "$dir/$subdir" ] ; then
#            mkdir "$dir/$subdir"
#        fi
#    done
#done

# Setting up hosts for apache (port-based virtual hosts)
cp -f /vagrant/carcass/vagrant/*.apache2.conf /etc/apache2/sites-enabled/
/etc/init.d/apache2 restart

# Making the config for our application
# cp -f {carcass/vagrant,common/config/overrides}/local.php

# Init the database with rudimentary init data
# bin/yiic migrate --migrationPath=vendor.softme.yii-user.migrations --interactive=0
# bin/yiic migrate --interactive=0

echo "Bootstrap script has been ended";

