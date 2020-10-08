import * as fs from 'fs'
import { createRequire } from 'module'
const require = createRequire(import.meta.url)
const yaml = require('js-yaml')

/**
 * Creator module, creates configs and writes to files.
 *
 * @author Johan Andersson
 * @class Creator
 */
export default class Creator {
  constructor (hosts, ssh, ansible, rke) {
    this.hosts = hosts
    this.ssh = ssh
    this.ansible = ansible
    this.rke = rke
  }

  /**
   * Create rke cluster.yaml file.
   *
   * @author Johan Andersson
   * @memberof Creator
   */
  createRKEClusterYaml () {
    this.hosts.forEach(host => {
      const rkeNode = _createRKENode(host)
      this.rke.config.nodes.push(rkeNode)
    })
    fs.writeFileSync(this.rke.configPath, yaml.safeDump(this.rke.config))
  }

  /**
   * Create ansible inventory/hosts file.
   *
   * @author Johan Andersson
   * @memberof Creator
   */
  createAnsibleHosts () {
    let hostsFile = ''
    this.hosts.forEach(host => {
      hostsFile += host.name + '\n'
    })

    hostsFile += `
[all:vars]
docker_version="5:19.03.*"
    `

    fs.writeFileSync(this.ansible.hostsPath, hostsFile)
  }

  /**
   * Create SSH config file.
   *
   * @author Johan Andersson
   * @memberof Creator
   */
  createSSHConfig () {
    let sshConfigFile = ''
    this.hosts.forEach(host => {
      sshConfigFile += `Host ${host.name}
HostName ${host.ip}
User ${host.user}

`
    })

    fs.writeFileSync(this.ssh.configPath, sshConfigFile)
  }
}

/**
 * Helper function to create rke node.
 *
 * @author Johan Andersson
 * @param {object} host the host.
 * @returns {object} the rke node.
 */
function _createRKENode (host) {
  const rkeNode = {
    address: host.ip,
    internal_address: host.internalAddress,
    role: host.isMaster ? ['controlplane', 'etcd'] : ['worker'],
    labels: host.isMaster ? {
      'node-role.kubernetes.io/master': true
    } : '',
    taints: host.isMaster ? [{
      key: 'node-role.kubernetes.io/master',
      value: true,
      effect: 'NoSchedule'
    }] : [],
    hostname_override: host.name,
    user: host.user
  }

  return rkeNode
}
