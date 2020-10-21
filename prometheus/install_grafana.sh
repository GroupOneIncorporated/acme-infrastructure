echo "Adding package to repo"
sudo add-apt-repository "deb https://packages.grafana.com/oss/deb stable main"

echo "Installing..."
sudo apt install grafana -y

echo "Starting grafana!"
sudo service grafana-server start