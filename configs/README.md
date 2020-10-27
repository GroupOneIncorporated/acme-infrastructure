# SSH Config file

## Automatic use
Add to your SSH config file (for example ~/.ssh/config) by adding  
`Include ~/{YOUR_WORK_FOLDER}/acme-infrastructure/configs/ssh_config`  
in it.

## Manual use
`ssh <destination> -F ./ssh_config`