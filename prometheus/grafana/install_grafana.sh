#!/bin/bash
# Installing Grafana on Debian¨

sudo apt-get update

echo "******************************* Install dependency *******************************"
sudo apt-get install software-properties-common -y
sudo apt-get install -y apt-transport-https

echo "******************************* Get Grafana *******************************"
wget -O - https://packages.grafana.com/gpg.key | sudo apt-key add -
sudo add-apt-repository "deb https://packages.grafana.com/oss/deb stable main"

echo "******************************* Update and install grafana *******************************"
sudo apt-get update -y
sudo apt-get install grafana -y

echo "******************************* Starting server *******************************"
sudo /bin/systemctl start grafana-server
sudo /bin/systemctl enable grafana-server

echo "******************************* Waiting for server to start (25s) *******************************"
sleep 25s

echo "******************************* Import data source *******************************"
sudo apt-get install curl -y
curl 'http://admin:admin@localhost:3000/api/datasources' -X POST -H 'Content-Type: application/json;charset=UTF-8' --data-binary '{"name":"Prometheus","type":"prometheus","url":"http://localhost:9090","access":"proxy","isDefault":true}'
sudo cp sample.yml /etc/grafana/provisioning/dashboards/sample.yml

echo "******************************* Import dashboards *******************************"
sudo cp -r dashboards/ /var/lib/grafana/dashboards

#echo "******************************* Restarting server *******************************"
#sudo /bin/systemctl restart grafana-server