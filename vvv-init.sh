# Init script for project
# Using moustache script for replacing placeholder-texts for project
# heroquest = Database name
# hq.wordpress = Dev URL
# Hero Quest = Title of project
# jonathan = Admin account name
# jontedejong@gmail.com = Admin account email
# Password and user to database is wp
# Password to WP Admin is password

echo "Commencing project setup"

# Make a database, if we don't already have one
echo "Creating database (if it's not already there)"
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS heroquest"
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON heroquest.* TO wp@localhost IDENTIFIED BY 'wp';"

# Download WordPress
if [ ! -d htdocs ]
then
	echo "Installing WordPress using WP CLI"
	mkdir htdocs
	cd htdocs
	wp core download --allow-root
	wp core config --dbname="heroquest" --dbuser=wp --dbpass=wp --dbhost="localhost" --allow-root
	wp core install --url=hq.wordpress.dev --title="Hero Quest" --admin_user=jonathan --admin_password=password --admin_email=jontedejong@gmail.com --allow-root
	#Themes
	#Uncomment either regular sceleton or sass version to automatically install it
	#wp theme install ../../../includes/sceleton.zip --activate --allow-root
	wp theme install ../../../includes/sceleton-sass.zip --activate --allow-root
	wp theme delete twentytwelve twentythirteen twentyfourteen --allow-root
	#Plugins, comment out or delete any you do not want
	wp plugin install helpful-information --activate --allow-root
	wp plugin install advanced-custom-fields --activate --allow-root
	wp plugin install ../../../includes/wp-migrate-db-pro-1.3.4.zip --activate --allow-root
	wp plugin install better-wp-security --allow-root
	wp plugin install backupwordpress --allow-root
	#Delete default content
	wp post delete 1 2 --force --allow-root
	wp plugin delete hello --allow-root
	#Setup default content
	wp post create --post_type=page --post_status=publish --post_title='Hem' --allow-root
	#Setup options
	wp option update permalink_structure '/%category%/%postname%/' --allow-root
	wp option update date_format 'Y-m-d' --allow-root
	wp option update show_on_front 'page' --allow-root
	wp option update page_on_front '3' --allow-root
	cd ..
fi

# The Vagrant site setup script will restart Nginx for us

echo "Hero Quest site now installed";
