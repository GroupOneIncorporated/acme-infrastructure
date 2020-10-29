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
#export ANSIBLE_SSH_ARGS="-C -o ControlMaster=auto -o ControlPersist=60s -F $(pwd)/../configs/ssh_config"
# This is a temporary fix for host key checking
#export ANSIBLE_HOST_KEY_CHECKING=false
#cd ../ansible
#ansible-playbook -i hosts site.yaml

#unset ANSIBLE_SSH_ARGS

# Wait for ssh
until ssh k8s-master-1 -F $(pwd)/../configs/ssh_config; do
    echo "Waiting for ssh.."
    sleep 5s
done

# rke
cd ../rke
rke up #--ssh-agent-auth
export KUBECONFIG=$(pwd)/kube_config_cluster.yml
#export KUBECONFIG=$KUBECONFIG:$(pwd)/kube_config_cluster.yml

echo "Infrastructure deployed successfully."

# K8S Resources

echo "Starting to deploy K8S resources.."
cd ../kubernetes
./k8s-deploy.sh $1