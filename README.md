# mysql-perf
Simple script to evaluate some the time taken to perform some simple PHP mysqli operations on a database.


## On VPS (Ubuntu 20.04LTS)

apt update
apt upgrade
apt install git mysql-server php7.4 php7.4-mysql php7.4-common php7.4-cli

mysql -h localhost -u root
CREATE DATABASE testdb;
CREATE USER 'dbowner'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'dbowner'@'localhost';
FLUSH PRIVILEGES;

mysql -h localhost -u dbowner -p testdb

git clone 