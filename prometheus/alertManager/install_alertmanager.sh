sudo useradd --no-create-home --shell /bin/false alertmanager
wget https://github.com/prometheus/alertmanager/releases/download/v0.17.0/alertmanager-0.17.0.linux-amd64.tar.gz
sudo tar -xvf alertmanager-0.17.0.linux-amd64.tar.gz

sudo cp alertmanager-0.17.0.linux-amd64/alertmanager /usr/local/bin/
sudo cp alertmanager-0.17.0.linux-amd64/amtool /usr/local/bin/

sudo chown alertmanager:alertmanager /usr/local/bin/alertmanager
sudo chown alertmanager:alertmanager /usr/local/bin/amtool

sudo rm -rf alertmanager-0.17.0*

sudo mkdir /etc/alertmanager

sudo cp alertmanager.yml /etc/alertmanager/alertmanager.yml

sudo chown alertmanager:alertmanager -R /etc/alertmanager

sudo cp alertmanager.service /etc/systemd/system/alertmanager.service

sudo systemctl daemon-reload
sudo systemctl start alertmanager