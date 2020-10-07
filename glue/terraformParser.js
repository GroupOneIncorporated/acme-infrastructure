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
      internal_address: instance.attributes.access_ipv4
    })
  })
}

/**
 * @param tfState
 */
function _getInstances (tfState) {
  return tfState.resources.filter(element => element.type === 'openstack_compute_instance_v2')
}

/**
 * @param instances
 */
function _getMasterInstances (instances) {
  return instances.filter(instance => instance.name === masterNodeName)[0].instances
}

/**
 * @param instances
 */
function _getWorkerInstances (instances) {
  return instances.filter(instance => instance.name === workerNodeName)[0].instances
}

/**
 * @param tfState
 */
function _getFloatingIPAssociations (tfState) {
  return tfState.resources.filter(element => element.type === 'openstack_compute_floatingip_associate_v2')
}

/**
 * @param floatingIPAssociations
 */
function _getMasterIPs (floatingIPAssociations) {
  return floatingIPAssociations.filter(instance => instance.name === masterNodeName)[0].instances
}

/**
 * @param floatingIPAssociations
 */
function _getWorkerIPs (floatingIPAssociations) {
  return floatingIPAssociations.filter(instance => instance.name === workerNodeName)[0].instances
}

module.exports = terraformParser()
