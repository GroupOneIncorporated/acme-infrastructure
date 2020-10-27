helm repo add stable https://charts.helm.sh/stable
helm install -f nfs-values.yaml stable/nfs-server-provisioner --name nfs-provisioner