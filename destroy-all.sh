#!/bin/bash
# Script for destroying all-in-one

# Variables in openRC file from OpenStack
source ../openrc.sh

cd terraform
terraform destroy

cd ../
# Destroy files that keeps inventory..

echo "Infrastructure destroyed successfully."
exit 0