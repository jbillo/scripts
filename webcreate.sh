#!/usr/bin/env bash

set -e

# Get domain
if [ -z $1 ]; then
	echo "Usage: $0 <example.com>"
	exit 1
fi

# Get root
if [[ $EUID -ne 0 ]]; then
	echo "Must be root to use this script"
	exit 2
fi

domain=$1

fn_create_mysql() {
	dbname=`echo $domain | sed 's/\./_/g'`
 	newpw=`pwgen -s 16 1`
	echo "Creating database and user as $dbname with password: $newpw"
	echo "Please log in as MySQL root to complete operation"
	mysql -u root -p mysql -e "CREATE DATABASE IF NOT EXISTS $dbname; GRANT ALL PRIVILEGES ON $dbname.* TO '$dbname'@'localhost' IDENTIFIED BY '$newpw' WITH GRANT OPTION; FLUSH PRIVILEGES;"
}

# Create directories
mkdir -p /var/log/nginx/$domain
mkdir -p /var/www/$domain

# Create nginx configuration
cp /etc/nginx/sites-available/template /etc/nginx/sites-available/$domain
echo "Now editing the nginx configuration for $domain"
vi /etc/nginx/sites-available/$domain

# Enable site
ln -snf /etc/nginx/sites-available/$domain /etc/nginx/sites-enabled/$domain

# Do we need a database?
while true; do
	read -e -p "Do you want to create a MySQL database? [Y/n] " -i "Y" create_mysql
	case $create_mysql in
		[Yy]* ) fn_create_mysql; break;;
		[Nn]* ) break;;
	esac
done

# Create self-signed certificate in correct directory
pushd /etc/ssl/www
/usr/local/bin/selfsign.sh $domain
popd

# Reload nginx
service nginx reload

