# Terraform
Provisioning of cloud resources.

## Prerequisites
- Terraform
- Openstack Credentials (e.g. openstack.rc)

## How to install Terraform
- Download
- Add it to your path
- Run terraform init in this directory
- Have an Openstack api account configured

## How to use Terraform
First source your OpenStack rc file, then run terraform while standing in the terraform folder.

Terraform will show a plan of additions, changes and deletions, that can then be confirmed to run.

### Provisioning
```
source openstack.rc
terraform init
terraform apply
```

### Removal
```
source openstack.rc
terraform destroy
```