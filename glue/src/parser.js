// import * as path from 'path'
import * as fs from 'fs'

/**
 * Parser module, parses tfstate file.
 *
 * @author Johan Andersson
 * @class Parser
 */
export default class Parser {
  constructor (tfstatePath) {
    _validateArg(tfstatePath)
    this.tfstatePath = tfstatePath
    this.tfstateFile = fs.readFileSync(this.tfstatePath).toString()
    this.tfstate = JSON.parse(this.tfstateFile)
    this.allInstances = _getInstances(this.tfstate)
    this.AllFloatingIPAssociations = _getFloatingIPAssociations(this.tfstate)
  }

  /**
   * Get all compute instances.
   *
   * @author Johan Andersson
   * @returns {Array} the instances.
   * @memberof Parser
   */
  getAllInstances () {
    return this.allInstances
  }

  /**
   * Get all instances of specified name.
   *
   * @author Johan Andersson
   * @param {string} name the name.
   * @returns {Array} the instances.
   * @memberof Parser
   */
  getNamedInstances (name) {
    return _getNamedInstances(this.allInstances, name)
  }

  /**
   * Get all floating ip associations.
   *
   * @author Johan Andersson
   * @returns {Array} the associations.
   * @memberof Parser
   */
  getAllFloatingIpAssociations () {
    return this.AllFloatingIPAssociations
  }

  /**
   * Get floating ip association by instance name.
   *
   * @author Johan Andersson
   * @param {string} name the instance name.
   * @returns {Array} the associations.
   * @memberof Parser
   */
  getIPByInstanceName (name) {
    return _getNamedIPs(this.AllFloatingIPAssociations, name)
  }

  /**
   * Get host info with name, user, ip, master status.
   *
   * @author Johan Andersson
   * @param {Array} nodes the node types.
   * @returns {Array} the resulting node informations.
   * @memberof Parser
   */
  getNodeInfo (nodes) {
    const parsedHosts = []
    nodes.forEach(node => {
      const instances = this.getNamedInstances(node.name)
      const instanceIPs = this.getIPByInstanceName(node.name)
      instances.forEach(instance => {
        const ip = instanceIPs.filter(ip => ip.attributes.instance_id === instance.attributes.id)[0].attributes.floating_ip
        parsedHosts.push({
          name: instance.attributes.name,
          user: node.user,
          ip: ip,
          isMaster: node.isMaster,
          internalAddress: instance.attributes.access_ip_v4
        })
      })
    })
    return parsedHosts
  }
}

/**
 * Just validating input arg.
 *
 * @author Johan Andersson
 * @param {string} arg the arg.
 */
function _validateArg (arg) {
  if (!arg || typeof arg !== 'string' || arg === '') {
    throw new Error('Input argument must be a valid path written as a String!')
  }
}

/**
 * Helper method to get all instances.
 *
 * @author Johan Andersson
 * @param {object} tfstate the tfstate file.
 * @returns {Array} the instances.
 */
function _getInstances (tfstate) {
  return tfstate.resources.filter(element => element.type === 'openstack_compute_instance_v2')
}

/**
 * Helper method to get instances by name.
 *
 * @author Johan Andersson
 * @param {Array} instances the instances to filter from.
 * @param {string} name the name.
 * @returns {Array} the named instances.
 */
function _getNamedInstances (instances, name) {
  return instances.filter(instance => instance.name === name)[0].instances
}

/**
 * Helper method to get floating ip assocations.
 *
 * @author Johan Andersson
 * @param {object} tfstate the tfstate file.
 * @returns {Array} the associations.
 */
function _getFloatingIPAssociations (tfstate) {
  return tfstate.resources.filter(element => element.type === 'openstack_compute_floatingip_associate_v2')
}

/**
 * Helper method to get the floating ip association by instance name.
 *
 * @author Johan Andersson
 * @param {Array} floatingIPAssociations the associations.
 * @param {string} name the instance name.
 * @returns {Array} the named associations.
 */
function _getNamedIPs (floatingIPAssociations, name) {
  return floatingIPAssociations.filter(instance => instance.name === name)[0].instances
}
