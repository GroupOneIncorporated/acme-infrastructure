echo "Get Grafana"
wget -O - https://packages.grafana.com/gpg.key | sudo apt-key add -
sudo add-apt-repository "deb https://packages.grafana.com/oss/deb stable main"

echo "Update and install grafana"
sudo apt-get update -y
sudo apt-get install grafana

echo "Starting server"
sudo /bin/systemctl start grafana-server