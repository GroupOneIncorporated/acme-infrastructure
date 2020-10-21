# Cloud conf
Create secret containing cloud credentials.  
To enable communication between the cloud controller manager and Openstack.

## Use
- Follow the template to create a cloud.conf 
- Encrypt cloud.conf file with ansible-vault: `ansible-vault encrypt cloud.conf` >> use a secure password, preferably stored in a password manager. You need this password in the next step!
- Run `./createsecret.sh` >> in this step you enter the password used to encrypt the file when prompted.

## ToDO
Make dynamic to use multiple cloud.conf-files. One for each user/cluster.