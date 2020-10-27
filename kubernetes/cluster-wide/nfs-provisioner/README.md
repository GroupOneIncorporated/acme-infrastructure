helm repo add stable https://charts.helm.sh/stable
helm install nfs-provisioner -f nfs-values.yaml stable/nfs-server-provisioner