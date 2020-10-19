# Terraform
Provisioning of cloud resources.

# How to install Terraform
- Download
- Add it to your path
- Run terraform init in this directory
- Have an Openstack api account configured

# How to use Terraform
First source your OpenStack rc file, then run terraform.

```
source openstack.rc
terraform apply
```

Terraform will show a plan of additions, changes and deletions, that can then be confirmed to run.