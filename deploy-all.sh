#!/bin/bash
# Script for deploying all-in-one

# Variables in openRC file from OpenStack
source ../openrc.sh

# Keypair?
if [ ! -f "$HOME/.ssh/GroupOneInc.pub" ]; then
  echo "No public key found at $HOME/.ssh/GroupOneInc.pub"
  exit 0
fi

# Terraform
cd terraform
terraform init
terraform apply


# Ansible
cd ../ansible
# Whatever we need to do here in the next step.

echo "Infrastructure deployed successfully."