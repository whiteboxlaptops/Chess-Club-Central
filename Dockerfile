FROM ubuntu:trusty

# Install packages
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && \
  apt-get -y install supervisor git apache2 libapache2-mod-php5 mysql-server php5-mysql pwgen php-apc php5-mcrypt && \
  echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Add image configuration and scripts
ADD app/start-apache2.sh /start-apache2.sh
ADD app/start-mysqld.sh /start-mysqld.sh
ADD app/run.sh /run.sh
RUN chmod 755 /*.sh
ADD app/my.cnf /etc/mysql/conf.d/my.cnf
ADD app/supervisord-apache2.conf /etc/supervisor/conf.d/supervisord-apache2.conf
ADD app/supervisord-mysqld.conf /etc/supervisor/conf.d/supervisord-mysqld.conf

# Remove pre-installed database
RUN rm -rf /var/lib/mysql/*

# Add MySQL utils
ADD app/create_mysql_admin_user.sh /create_mysql_admin_user.sh
RUN chmod 755 /*.sh

# config to enable .htaccess
ADD app/apache_default /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Configure /app folder with sample app
RUN mkdir -p /app && rm -fr /var/www/html && ln -s /app /var/www/html
ADD app/chess.php /app/chess.php
ADD app/chessdb.php /app/chessdb.php
ADD app/index.html /app/index.html
ADD app/mysql-setup.sh /
RUN chmod 755 /*.sh

#Environment variables to configure php
ENV PHP_UPLOAD_MAX_FILESIZE 10M
ENV PHP_POST_MAX_SIZE 10M

# Add volumes for MySQL 
VOLUME  ["/etc/mysql", "/var/lib/mysql"]

# Set up chess stuff here
ENV MYSQL_PASS chess123

EXPOSE 80 3306

CMD ["/run.sh"]
