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

# Glue
cd ../glue
npm install
npm start acme-infrastructure.json

# Ansible
cd ../ansible
ansible-playbook -i hosts site.yaml

# rke
cd ../rke
rke up

echo "Infrastructure deployed successfully."