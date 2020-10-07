const fs = require('fs')
const path = require('path')

/**
 * Terraform parser module.
 * Parses a tfstate file and returns the created compute instances.
 *
 * @author Johan Andersson
 */
function terraformParser () {
  const masterNodeName = 'k8s_master'
  const workerNodeName = 'k8s_node'

  const tfStatePath = path.join('..', 'terraform', 'terraform.tfstate')

  const tfStateFile = fs.readFileSync(tfStatePath).toString()
  const tfState = JSON.parse(tfStateFile)

  const parsedHosts = []

  const computeInstances = tfState.resources.filter(instance => instance.type === 'openstack_compute_instance_v2')
  const computeMasters = computeInstances.filter(instance => instance.name === masterNodeName)[0].instances
  const computeWorkers = computeInstances.filter(instance => instance.name === workerNodeName)[0].instances

  const floatingIPAssociation = tf
}

/**
 * @param tfState
 */
function _getInstances (tfState) {

}

/**
 *
 */
function _getMasterInstances () {

}

/**
 *
 */
function _getWorkerInstances () {

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
