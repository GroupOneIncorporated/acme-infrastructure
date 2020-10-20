echo "Create user"
sudo useradd --no-create-home --shell /bin/false node_exporter

echo "Installing..."
wget https://github.com/prometheus/node_exporter/releases/download/v0.17.0/node_exporter-0.17.0.linux-amd64.tar.gz
tar -xf node_exporter-0.17.0.linux-amd64.tar.gz
sudo cp node_exporter-0.17.0.linux-amd64/node_exporter /usr/local/bin
sudo chown node_exporter:node_exporter /usr/local/bin/node_exporter
sudo rm -rf node_exporter-0.17.0.linux-amd64*

echo "Applying configuration"
sudo cp node_exporter.service /etc/systemd/system/node_exporter.service

echo "Reload and start systemctl"
sudo systemctl daemon-reload
sudo systemctl enable node_exporter
sudo systemctl start node_exporter
