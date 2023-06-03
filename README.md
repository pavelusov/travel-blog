# Template Wordpress

## Setup environments
Setup your private environments in your system terminal

`export MYSQL_ROOT_PASSWORD=some_password`

`export MYSQL_DB_USER=some_mysql_db_user`

`export MYSQL_DB_PASSWORD=somemysqldbpassword`

## First start setup
1. Run services `docker-compose up -d`
2. Go to the admin panel `http://127.0.0.1/wp-login.php`
3. Setup Wordpess
4. Create db_dump folder `mkdir db_dump`
5. Create a db dump `docker exec db sh -c 'exec mysqldump wordpress -uroot -p"$MYSQL_ROOT_PASSWORD"' > ./db_dump/wordpress.sql`

## Start setup
1. `docker-compose up -d db` - run the db service
2. `docker exec -i db sh -c 'exec mysql -uroot -p"$MYSQL_ROOT_PASSWORD" wordpress' < ./db_dump/wordpress.sql` - restore your database
3. `docker-compose up -d` - run other services

## Before  stopping docker containers
1. `docker exec db sh -c 'exec mysqldump wordpress -uroot -p"$MYSQL_ROOT_PASSWORD"' > ./db_dump/wordpress.sql`
2. `git add .; git commit -m "The DB was changed. Some changes"; git push origin main`

## Creating database dump
`docker exec db sh -c 'exec mysqldump wordpress -uroot -p"$MYSQL_ROOT_PASSWORD"' > ./db_dump/wordpress.sql`

## Restoring data from dump files
`docker exec -i db sh -c 'exec mysql -uroot -p"$MYSQL_ROOT_PASSWORD" wordpress' < ./db_dump/wordpress.sql`

### Admin panel
`http://127.0.0.1/wp-login.php`

Administrator:
- login - admin
- pass - synergy_admin

User:
- login - synergy_user
- pass - synergy_root_2023

### Web user interface
Main - `http://127.0.0.1`

Auth - `http://127.0.0.1/wp-login.php`

### A data removing
Temporary data is stored in the docker volumes

1. Show the docker volumes:

`docker volume ls`

2. Recognize our volumes:

volume will be named by mask

`[folder-name]_[volumename]`

for example, if our project is located in the "blog-wp" folder, then volume names will be as follows:

`blog-wp_dbdata`

`blog-wp_wordpress`

3. Removing volumes

`docker-compose down` - stop and remove containers

`docker volume rm blog-wp_dbdata`

`docker volume rm blog-wp_wordpress`
