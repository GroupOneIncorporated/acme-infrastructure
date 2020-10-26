# Ansible

## Structure

### Folders & Files
Folders:
- roles - Contains specifications for server roles and what they should do
- roles/x/files - Contains files used by the role
- roles/x/tasks - Contains tasklists that the role should execute  

Files:
- site.yaml - Main ansible-playbook
- hosts - Ansible inventory file, containing servers

### Groups & Roles
- common - role run for every host, configs used by all servers

## Run playbook
```
ansible-playbook -i hosts site.yaml
```
when standing in the ansible folder.