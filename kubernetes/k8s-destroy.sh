#!/bin/bash

# --- Destroy all k8s resources --- #
echo "# --- Destroying k8s resources.. --- #"

# Helm chart
echo "Uninstalling Wordpress helm chart.."
cd acme-platform
helm uninstall acmewp -n acme
kubectl delete pvc --all -n acme
echo "Uninstalled Wordpress!"
cd ..

# Dashboard
echo "Uninstalling K8S Dashboard.."
kubectl delete -f https://raw.githubusercontent.com/kubernetes/dashboard/v2.0.0-beta8/aio/deploy/recommended.yaml
kubectl delete -f dashboard
echo "Uninstalled K8S Dashboard!"

# Namespaces
echo "Delete namespaces.."
kubectl delete -f namespaces
echo "Deleted namespaces!"

# Kube-State-Metrics
cd cluster-wide/ingress-controller
echo "Uninstalling Kube-State-Metrics ingress.."
kubectl delete -f kube-state-metrics-ingress.yaml
echo "Uninstalled ingress!"
cd ..
echo "Uninstalling Kube-State-Metrics.."
kubectl delete -f kube-state-metrics
echo "Uninstalled Kube-State-Metrics!"

# Cert-Manager
echo "Uninstalling ClusterIssuer(s).."
cd cert-manager
kubectl delete -f letsencrypt-staging
echo "ClusterIssuer(s) uninstalled!"
echo "Uninstalling Cert-Manager.."
kubectl delete -f https://github.com/jetstack/cert-manager/releases/download/v1.0.3/cert-manager.yaml
echo "Cert-Manager uninstalled!"
cd ..

# Nginx Ingress Controller
echo "Uninstalling Nginx Ingress Controller.."
helm uninstall ingress-controller
echo "Nginx Ingress Controller uninstalled!"

# NFS Provisioner
echo "Uninstalling NFS provisioner.."
helm uninstall nfs-provisioner
kubectl delete pvc --all
echo "NFS provisioner uninstalled!"

# Storage classes
echo "Deleting storage classes.."
kubectl delete -f storage-classes
echo "Deleted storage classes!"

# CSI Cinder
echo "Uninstalling CSI Cinder plugin.."
kubectl delete -f csi-cinder-plugin
echo "CSI Cinder uninstalled!"

# OCCM
echo "Uninstalling OCCM.."
kubectl delete -f openstack-cloud-controller-manager
echo "OCCM uninstalled!"

echo "# --- K8S resources destroyed! --- #"