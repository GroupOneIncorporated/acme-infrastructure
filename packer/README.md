Packer will build an instance and provision it according to the built .json file. When provisioning is complete, the instance is automatically saved as an image in openstack and the instance is destroyed.

## to create image:
1) install Packer (https://learn.hashicorp.com/tutorials/packer/getting-started-install)
2) Edit openrc.sh (Packer's opentsack provider still uses some v2 authentication variables even if we use a v3 RC file):
  - Comment-our or remove 'unset OS_TENANT_NAME' and 'unset OS_TENANT_ID'
  - Add 'export OS_TENANT_NAME=$OS_PROJECT_NAME' and 'export OS_TENANT_ID=$OS_PROJECT_ID'
3) source openrc.sh
4) Check that the UUID value in 'network' on /packer/debian9-docker.json matches the UUID of our internal 'k8s-network'
5) in /packer folder, run 'packer build debian9-docker.json'

## tasks currently in the .json file to create the template
- create Debian 9 instance, attached to the infrastructure previously created by terraform
- use the 'ansible' provisioner to install docker


# Structure of a Packer .json file:
### 1) Builders 
(https://www.packer.io/docs/templates/builderswith) 
- different 'type's, specific to each cloud platform
- creates the instance that is the base of the template
- connects to it using SSH (uses a temporary discardable keypair, no need to configure keys for this)

### 2) Provisioners 
docs: https://www.packer.io/docs/templates/provisioners
provisioners: https://www.packer.io/docs/provisioners
- different 'type's for different ways of provisioning
  - type: file - transfers a file from "source: path" to "destination: path" (ATTENTION: if the destination file requires root permissions, the file must first be transfered to a /tmp folder in the instance and only then to the final destination)
  - type: shell - executes a local sh script on the instance
    - "inline: [command1, command2...]" to write bash commands
    - "script: path" to execute a script (or "scripts: path" for an array of paths)
  - type: "ansible" executes a playbook on the path
    - "playbook_file: path"
- properties like 'pause_before' to specify amount of seconds to wait, 'timeout' to specify time to consider provisioning has failed (no timeout by default)...

### 3) (eventually) Post-processors

- ATTENTION! Sometimes openstack failed to re-release the floating IP associated with an image-based instance! --> Might be necessary adding an "error-cleanup-provisioner" to perform some Openstack command to release unassigned floating IPs when destroying the instance. (tried adding "reuse_ips: true" do template.json file, did not work).