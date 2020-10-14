#!/bin/bash
# Script for destroying all-in-one

# Variables in openRC file from OpenStack
source ../openrc.sh

# Uninstall chart
cd kubernetes
helm uninstall <chartname> -n <namespace> #add these later when we decide names

# Destroy cluster
cd ../rke
rke remove

# Destroy infrastructure
cd ../terraform
terraform destroy

cd ../
# Destroy files that keeps inventory..

echo "Infrastructure destroyed successfully."
exit 0