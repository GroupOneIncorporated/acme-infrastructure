#!/bin/bash
# Script for destroying all-in-one

# Variables in openRC file from OpenStack
source ../openrc.sh

# Add kube conf env
cd rke
export KUBECONFIG=$(pwd)/kube_config_cluster.yml
cd ..

# Uninstall chart
echo "Uninstalling k8s resources.."
cd kubernetes
./k8s-destroy.sh

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