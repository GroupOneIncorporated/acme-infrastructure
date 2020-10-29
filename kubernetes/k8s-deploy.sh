#!/bin/bash

# --- Deploy all k8s resources --- #
echo "# --- Deploying k8s resources.. --- #"

# Cloud.conf credentials
echo "# --- Deploying cloud conf secret.. --- #"
cd cloud-config
./createsecret.sh cloud.conf
echo "# --- Created cloud conf secret! --- #"

# Install cluster wide resources
cd ../cluster-wide

# OCCM
echo "# --- Installing OCCM.. --- #"
kubectl apply -f openstack-cloud-controller-manager
echo "# --- OCCM installed! --- #"

# CSI Cinder
echo "# --- Installing CSI Cinder plugin.. --- #"
kubectl apply -f csi-cinder-plugin
echo "# --- CSI Cinder installed! --- #"

# Storage classes
echo "# --- Creating storage classes.. --- #"
kubectl apply -f storage-classes
echo "# --- Created storage classes! --- #"

# NFS Provisioner
echo "# --- Installing NFS provisioner.. --- #"
echo "# --- Adding helm repo.. --- #"
helm repo add stable https://charts.helm.sh/stable
echo "# --- Helm repo added! --- #"
cd nfs-provisioner
helm install nfs-provisioner -f nfs-values.yaml stable/nfs-server-provisioner
echo "# --- NFS provisioner installed! --- #"
cd ..

# Nginx Ingress Controller
echo "# --- Installing Nginx Ingress Controller.. --- #"
echo "# --- Adding helm repo.. --- #"
helm repo add bitnami https://charts.bitnami.com/bitnami
echo "# --- Helm repod added! --- #"
cd ingress-controller
helm install ingress-controller -f ingress-controller-values-$1.yaml bitnami/nginx-ingress-controller
echo "# --- Nginx Ingress Controller Installed! --- #"
cd ..

# Cert-Manager
echo "# --- Installing Cert-Manager.. --- #"
kubectl apply --validate=false -f https://github.com/jetstack/cert-manager/releases/download/v1.0.3/cert-manager.yaml
echo "# --- Cert-Manager installed! --- #"
kubectl rollout status deployment cert-manager -n cert-manager
kubectl rollout status deployment cert-manager-cainjector -n cert-manager
kubectl rollout status deployment cert-manager-webhook -n cert-manager
echo "# --- Installing ClusterIssuer(s).. --- #"
cd cert-manager
kubectl apply -f letsencrypt-staging
echo "# --- ClusterIssuer(s) installed! --- #"
cd ..

# Kube-State-Metrics
echo "# --- Installing Kube-State-Metrics.. --- #"
kubectl apply -f kube-state-metrics
echo "# --- Installed Kube-State-Metrics! --- #"
cd ingress-controller
echo "# --- Installing Kube-State-Metrics ingress.. --- #"
kubectl apply -f kube-state-ingress-$1.yaml -n kube-system
echo "# --- Installed ingress! --- #"
cd ..

# Namespaces
cd ..
echo "# --- Creating namespaces.. --- #"
kubectl apply -f namespaces
echo "# --- Created namespaces! --- #"

# Dashboard
echo "# --- Installing K8S Dashboard.. --- #"
kubectl apply -f https://raw.githubusercontent.com/kubernetes/dashboard/v2.0.0-beta8/aio/deploy/recommended.yaml
kubectl apply -f dashboard
echo "# --- Installed K8S Dashboard! --- #"

# Helm chart
echo "# --- Installing Wordpress helm chart.. --- #"
cd acme-platform
helm install -f env/values-$1.yaml acmewp ./wordpress-platform -n acme
echo "# --- Installed Wordpress! --- #"

echo "# --- K8S resources deployed! --- #"