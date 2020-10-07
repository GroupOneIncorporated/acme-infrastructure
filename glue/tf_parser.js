const fs = require('fs')
const path = require('path')

module.exports = () => {

  const masterNodeName = 'k8s_master'
  const workerNodeName = 'k8s_node'
  
  const tfStatePath = path.join('..', 'terraform', 'terraform.tfstate')

  const tfStateFile = fs.readFileSync(tfStatePath).toString()
  const tfState = JSON.parse(tfStateFile)

  let parsedHosts = []

  const computeInstances = tfstate.resources.filter(instance => instance.type === 'openstack_compute_instance_v2')
  const computeMasters = computeInstances.filter(instance => instance.name === masterNodeName)[0].instances

}