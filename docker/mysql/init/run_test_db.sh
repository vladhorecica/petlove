#!/usr/bin/env bash

echo "Creating database ${MYSQL_TEST_DATABASE}"
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE ${MYSQL_TEST_DATABASE}"
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "GRANT ALL ON ${MYSQL_TEST_DATABASE}.* TO ${MYSQL_USER}"
