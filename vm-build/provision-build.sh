#!/usr/bin/env bash
locale-gen en_US

apt-get update
apt-get -y install \
software-properties-common \
python-software-properties \
debian-keyring \
debian-archive-keyring \
apt-transport-https \
lsb-release \
ca-certificates

wget -O /tmp/dotdeb.gpg http://www.dotdeb.org/dotdeb.gpg \
&& apt-key add /tmp/dotdeb.gpg \
&& rm /tmp/dotdeb.gpg

wget -O /tmp/php.gpg https://packages.sury.org/php/apt.gpg \
&& apt-key add /tmp/php.gpg \
&& rm /tmp/php.gpg \
&& echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

apt-key update
apt-get update
apt-get upgrade

# PRODUCTION specific software section
apt-get -y --force-yes install \
git \
tmux \
mc \
htop \
vim \
php7.1-fpm \
php7.1-cli \
curl \
nginx \
php7.1-curl \
php7.1-intl \
php7.1-mysql \
php7.1-redis \
php7.1-xml \
php7.1-mbstring \
redis-server

echo "=> Configuration for Nginx"
cp /vagrant/config/www/hrs.local /etc/nginx/sites-available/
ln -s /etc/nginx/sites-available/hrs.local /etc/nginx/sites-enabled/hrs.local

echo "=> Configuration for PHP"
sed -i "s/display_errors =.*/display_errors = On/g" /etc/php/7.1/cli/php.ini
sed -i "s/display_errors =.*/display_errors = On/g" /etc/php/7.1/fpm/php.ini
sed -i "s/;date.timezone =.*/date.timezone = UTC/g" /etc/php/7.1/cli/php.ini
sed -i "s/;date.timezone =.*/date.timezone = UTC/g" /etc/php/7.1/fpm/php.ini

sed -i "s/upload_max_filesize =.*/upload_max_filesize = 128M/g" /etc/php/7.1/fpm/php.ini
sed -i "s/post_max_size =.*/post_max_size = 256M/g" /etc/php/7.1/fpm/php.ini
sed -i "s/^file_uploads =.*/file_uploads = On/g" /etc/php/7.1/fpm/php.ini
sed -i "s/max_file_uploads =.*/max_file_uploads = 1/g" /etc/php/7.1/fpm/php.ini
sed -i "s/;upload_tmp_dir =.*/upload_tmp_dir = \/vagrant\/guest-shared-storage\/tmp\//g" /etc/php/7.1/fpm/php.ini
sed -i "s/memory_limit =.*/memory_limit = 256M/g" /etc/php/7.1/fpm/php.ini
sed -i "s/memory_limit =.*/memory_limit = 512M/g" /etc/php/7.1/cli/php.ini

echo "=> Install composer"
curl -sS https://getcomposer.org/installer | php
mv /home/vagrant/composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# DEV section
apt-get update
apt-get upgrade

apt-get -y install \
libpcre3-dev \
libcurl3-openssl-dev \
libpcre3-dev \
ntp \
strace \
telnet \
gdb

echo "=> Configuring /hrs directory"
ln -s /var/www/ /hrs

echo 'export PATH=/hrs/bin/:$PATH' >> /home/vagrant/.profile

/vagrant/post-provision.sh
echo 'Machine ready'
