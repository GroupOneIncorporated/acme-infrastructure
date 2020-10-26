# acme-infrastructure
Folders:
- ansible - The ansible playbooks that configure/manage the servers
- configs - Configuration files of use
- glue - Terraglue, script for glueing Terraform - Ansible - rke together
- kubernetes - Everything for the k8s cluster
- rke - config files for the installation of k8s
- terraform - Terraform files for the provisioning of resources  

Files:
- deploy-all.sh - deploy infrastructure
- destroy-all.sh - destroy infrastructure