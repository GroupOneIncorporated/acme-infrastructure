# terraglue
Smart little app constructing config files for tools like Ansible, rke, etc from Terraform provisioned resources.

## How to run it

Simply use `npm start <configfile.json>` where `<configfile.json>` is the config you want to use.  

Config files needs to be placed in the `src/configs` folder.

## Configuration

New config files can be created in json-format by simply following the format of the default.json config.  
The same goes for editing existing ones.