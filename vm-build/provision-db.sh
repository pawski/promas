#!/usr/bin/env bash
locale-gen en_US
dpkg-reconfigure -f noninteractive locales

echo "=> Makeing guest folder writable"
chmod -R 777 /vagrant/guest-shared-storage

echo "=> Apt update"
wget -O /tmp/dotdeb.key http://www.dotdeb.org/dotdeb.gpg && apt-key add /tmp/dotdeb.key

apt-key add /vagrant/config/db/mysql-pub-key.asc
echo "deb http://repo.mysql.com/apt/debian/ wheezy mysql-5.6" >> /etc/apt/sources.list.d/mysql.list

apt-get update
apt-get -y install software-properties-common python-software-properties

export DEBIAN_FRONTEND="noninteractive"

apt-get update
apt-get -y install \
tmux \
htop \
vim \
mysql-server

echo "=>Creating databases ..."
mysql -u root -e 'CREATE DATABASE promas'

mysql -u root -e "grant all privileges on *.* to 'root'@'%' identified by 'vagrant' with grant option;"
mysql -u root -e "FLUSH PRIVILEGES;"
mysql -u root -e "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('vagrant');"

cp /vagrant/config/db/my.cnf /usr/my.cnf

service mysql restart

/vagrant/post-provision.sh
echo 'Machine ready'
