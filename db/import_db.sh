echo drop database micropic | mysql -u root
echo create database micropic | mysql -u root
echo source $1 | mysql -u root micropic
