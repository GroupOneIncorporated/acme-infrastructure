#!/bin/bash
# Script for creating new server image with monitoring


k8snetwork=`openstack network list -f json | jq -r '.[] | select(.Name == "k8s-network") | .ID'`

# Check if network exists
if [ -z $k8snetwork ]; then
    echo "Could not find k8s-network! Exiting."
    exit 0
fi

# Run packer build
packer build -var internal_network_id=$k8snetwork debian9-monitoring.json 
