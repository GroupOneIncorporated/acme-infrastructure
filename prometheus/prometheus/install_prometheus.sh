#!/bin/bash
# Installing Prometheus on Debian

echo "Creating user"
sudo groupadd --system prometheus
sudo useradd -s /sbin/nologin --system -g prometheus prometheus

echo "Creating directory for file system"
sudo mkdir /etc/prometheus
sudo mkdir /var/lib/prometheus

echo "Applying persmissions for files"
sudo chown prometheus:prometheus /etc/prometheus
sudo chown prometheus:prometheus /var/lib/prometheus

echo "Setting up prometheus"
sudo wget https://github.com/prometheus/prometheus/releases/download/v2.8.0/prometheus-2.8.0.linux-amd64.tar.gz
sudo tar -xf prometheus-2.8.0.linux-amd64.tar.gz
sudo cp prometheus-2.8.0.linux-amd64/prometheus /usr/local/bin/
sudo cp prometheus-2.8.0.linux-amd64/promtool /usr/local/bin/
sudo chown prometheus:prometheus /usr/local/bin/prometheus
sudo chown prometheus:prometheus /usr/local/bin/promtool
sudo cp -r prometheus-2.8.0.linux-amd64/consoles /etc/prometheus/
sudo cp -r prometheus-2.8.0.linux-amd64/console_libraries /etc/prometheus/
sudo chown -R prometheus:prometheus /etc/prometheus/consoles
sudo chown -R prometheus:prometheus /etc/prometheus/console_libraries
sudo rm -rf prometheus-2.8.0.linux-amd64*

echo "Moving prometheus.yml to /etc/prometheus/"
sudo cp prometheus.yml /etc/prometheus/prometheus.yml

echo "Moving rules"
sudo cp rules/ /etc/prometheus/rules/

echo "Applying permissions to prometheus.yml"
sudo chown prometheus:prometheus /etc/prometheus/prometheus.yml

echo "Moving prometheus.service to /etc/systemd/system/"
sudo cp prometheus.service /etc/systemd/system/prometheus.service

echo "reloading and starting systemctl"
sudo systemctl daemon-reload
sudo systemctl enable prometheus
sudo systemctl start prometheus

echo "Done!"
