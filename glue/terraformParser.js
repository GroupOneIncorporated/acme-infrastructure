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

  const floatingIPAssociation = tf
}

/**
 * @param tfState
 */
function _getInstances (tfState) {
  return tfState.resources.filter(instance => instance.type === 'openstack_compute_instance_v2')
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
 *
 */
function _getFloatingIPAssociations () {

}

/**
 *
 */
function _getMasterIPs () {

}

/**
 *
 */
function _getWorkerIPs () {

}

module.exports = terraformParser()
