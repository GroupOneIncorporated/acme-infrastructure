- Creates an image on openstack of a Debian 9 and provisions it with Ansible
- upated terraform/main.tf to launch an instance of this image

# Structure of a Packer .json file:
## 1) Builders 
(https://www.packer.io/docs/templates/builderswith) 
- different 'type's, specific to each cloud platform
- creates the instance that is the base of the template
- connects to it using SSH (uses a temporary discardable keypair, no need to configure keys for this)

## 2) Provisioners 
docs: https://www.packer.io/docs/templates/provisioners
provisioners: https://www.packer.io/docs/provisioners
- different 'type's for different ways of provisioning
  - type: file - transfers a file from "source: path" to "destination: path" (ATTENTION: if the destination file requires root permissions, the file must first be transfered to a /tmp folder in the instance and only then to the final destination)
  - type: shell - executes a local sh script on the instance
    - "inline: [command1, command2...]" to write bash commands
    - "script: path" to execute a script (or "scripts: path" for an array of paths)
  - type: ansible-local - executes a playbook on the path   
    - "playbook_file: path"
- properties like 'pause_before' to specify amount of seconds to wait, 'timeout' to specify time to consider provisioning has failed (no timeout by default)

## 3) Post-processors


- After everything is finished, an image is automatically created based on the running instance. When it finishes creating the image, it is automatically uploaded to openstack and instance itself is destroyed. Now the new image is available on Openstack, ready to be used by terraform.

- ATTENTION! Openstack does not seem to re-release the floating IP associated with an image-based instance --> add some Openstack operation to release unassigned floating IPs when destroying the instance? (adding "reuse_ips: true" do template.json file did not work)
