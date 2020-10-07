const fs = require('fs')
const path = require('path')

const masterNodeName = 'k8s_master'
const workerNodeName = 'k8s_node'
const tfStatePath = path.join('..', 'terraform', 'terraform.tfstate')

/**
 * Terraform parser module.
 * Parses a tfstate file and returns the created compute instances.
 *
 * @author Johan Andersson
 * @returns {Array} the parsed hosts
 */
function terraformParser () {
  const tfStateFile = fs.readFileSync(tfStatePath).toString()
  const tfState = JSON.parse(tfStateFile)

  const parsedHosts = []

  const computeInstances = _getInstances(tfState)
  const computeMasters = _getMasterInstances(computeInstances)
  const computeWorkers = _getWorkerInstances(computeInstances)

  const floatingIPAssociations = _getFloatingIPAssociations(tfState)
  const masterNodeIPs = _getMasterIPs(floatingIPAssociations)
  const workerNodeIPs = _getWorkerIPs(floatingIPAssociations)

  computeMasters.forEach(instance => {
    const ip = masterNodeIPs.filter(ip => ip.attributes.instance_id === instance.attributes.id)[0].attributes.floating_ip
    parsedHosts.push({
      name: instance.attributes.name,
      ip: ip,
      isMaster: true,
      internal_address: instance.attributes.access_ip_v4
    })
  })

  computeWorkers.forEach(instance => {
    const ip = workerNodeIPs.filter(ip => ip.attributes.instance_id === instance.attributes.id)[0].attributes.floating_ip
    parsedHosts.push({
      name: instance.attributes.name,
      ip: ip,
      isMaster: false,
      internal_address: instance.attributes.access_ip_v4
    })
  })

  console.log(parsedHosts)
  return parsedHosts
}

/**
 * Get all compute instances from the tfstate json object.
 *
 * @author Johan Andersson
 * @param {object} tfState the json object.
 * @returns {Array} the compute instancs.
 */
function _getInstances (tfState) {
  return tfState.resources.filter(element => element.type === 'openstack_compute_instance_v2')
}

/**
 * Get the master node instances from the instance list.
 *
 * @author Johan Andersson
 * @param {Array} instances the instance list.
 * @returns {Array} the master instances.
 */
function _getMasterInstances (instances) {
  return instances.filter(instance => instance.name === masterNodeName)[0].instances
}

/**
 * Get the worker node instances from the instance list.
 *
 * @author Johan Andersson
 * @param {Array} instances the instance list.
 * @returns {Array} the worker instances.
 */
function _getWorkerInstances (instances) {
  return instances.filter(instance => instance.name === workerNodeName)[0].instances
}

/**
 * Get the floating IP associations from the tfstate json object.
 *
 * @author Johan Andersson
 * @param {object} tfState the json object.
 * @returns {Array} the floating IP associations.
 */
function _getFloatingIPAssociations (tfState) {
  return tfState.resources.filter(element => element.type === 'openstack_compute_floatingip_associate_v2')
}

/**
 * Get the floating IPs for the master nodes from the floating IP associations list.
 *
 * @author Johan Andersson
 * @param {Array} floatingIPAssociations the associations list.
 * @returns {Array} the master node IPs.
 */
function _getMasterIPs (floatingIPAssociations) {
  return floatingIPAssociations.filter(instance => instance.name === masterNodeName)[0].instances
}

/**
 * Get the floating IPs for the worker nodes from the floating IP associations list.
 *
 * @author Johan Andersson
 * @param {Array} floatingIPAssociations the assocations list.
 * @returns {Array} the worker node IPs.
 */
function _getWorkerIPs (floatingIPAssociations) {
  return floatingIPAssociations.filter(instance => instance.name === workerNodeName)[0].instances
}

module.exports = terraformParser()
