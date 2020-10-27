#!/bin/bash
# Installing Alertmanager on Debian

sudo apt-get update

echo "******************************* Creating user *******************************"
sudo groupadd --system alertmanager
sudo useradd -s /sbin/nologin --system -g alertmanager alertmanager

echo "******************************* Get Alertmanager *******************************"
wget https://github.com/prometheus/alertmanager/releases/download/v0.17.0/alertmanager-0.17.0.linux-amd64.tar.gz
sudo tar -xvf alertmanager-0.17.0.linux-amd64.tar.gz

echo "******************************* Copy alertmanager files to /usr/local/bin/ *******************************"
sudo cp alertmanager-0.17.0.linux-amd64/alertmanager /usr/local/bin/
sudo cp alertmanager-0.17.0.linux-amd64/amtool /usr/local/bin/

echo "******************************* Applying permissions *******************************"
sudo chown alertmanager:alertmanager /usr/local/bin/alertmanager
sudo chown alertmanager:alertmanager /usr/local/bin/amtool

echo "******************************* Remove files *******************************"
sudo rm -rf alertmanager-0.17.0*

echo "******************************* Directory for alertmanager *******************************"
sudo mkdir /etc/alertmanager

echo "******************************* Copy alertmanager configuration *******************************"
sudo cp alertmanager.yml /etc/alertmanager/alertmanager.yml

echo "******************************* Applying permissions to alertmanager *******************************"
sudo chown alertmanager:alertmanager -R /etc/alertmanager

echo "******************************* Copy service file to working directory *******************************"
sudo cp alertmanager.service /etc/systemd/system/alertmanager.service

echo "******************************* Starting server *******************************"
sudo systemctl daemon-reload
sudo systemctl enable alertmanager
#sudo systemctl start alertmanager