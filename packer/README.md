# 3 building blocks of a Packer .json file:

## 1) Builders (with a 'type' specific to each cloud platform, creates the instance in our infrastructure)
Creates the instance and connects to it using SSH (uses a temporary discardable keypair, no need to configure keys)
Once the instance is created and all the steps of provisioning and post-processing are complete, it is automatically uploaded to openstack as an image and the instance itself is destroyed.

## 2) Provisioners


## 3) Post-processors