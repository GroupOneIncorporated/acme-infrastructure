#!/bin/bash
# Script for destroying all-in-one

# Variables in openRC file from OpenStack
source ../openrc.sh

# Add kube conf env
cd rke
export KUBECONFIG=$(pwd)/kube_config_cluster.yml
cd ..

# Uninstall chart
echo "Uninstalling application.."
cd kubernetes
helm uninstall acmewp -n acme
echo "Application uninstalled!"

# Uninstall ingress-controller / LB
echo "Uninstalling ingress controller / loadbalancer.."
helm uninstall ingress-controller
echo "Ingress controller / loadbalancer uninstalled!"

# Destroy cluster
echo "Destroying K8S cluster.."
cd ../rke
rke remove
echo "Cluster destroyed!"

# Destroy infrastructure
echo "Destroying infrastructure.."
cd ../terraform
terraform destroy
echo "Infrastructure destroyed!"

cd ../
# Destroy files that keeps inventory..

echo "Infrastructure destroyed successfully."
exit 0