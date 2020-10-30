# acme-infrastructure
Folders:
- ansible - The ansible playbooks that configure/manage the servers
- configs - Configuration files of use
- docker - Files for creating the wordpress and mariadb docker images
- glue - Terraglue, script for glueing Terraform - Ansible - rke together
- kubernetes - Everything for the k8s cluster
- packer - Files for creating the server images
- rke - config files for the installation of k8s
- terraform - Terraform files for the provisioning of resources  

Files:
- deploy-all.sh - Provision with terraform, install kubernetes with rke, setup cluster and application with helm.
- destroy-all.sh - Destroy from helm -> rke -> terraform
