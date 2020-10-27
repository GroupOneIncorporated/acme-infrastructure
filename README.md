# acme-infrastructure
Folders:
- ansible - The ansible playbooks that configure/manage the servers
- configs - Configuration files of use
- docker - Files for creating the wordpress and mariadb docker images
- glue - Terraglue, script for glueing Terraform - Ansible - rke together
- kubernetes - Everything for the k8s cluster
- node_exporter - Scripts to run node_exporter for prometheus
- packer - Files for creating the server images
- prometheus - Files for monitoring with prometheus and grafana
- rke - config files for the installation of k8s
- terraform - Terraform files for the provisioning of resources  

Files:
- deploy-all.sh - Provision servers, network and install RKE infrastructure
- destroy-all.sh - destroy infrastructure (not working)