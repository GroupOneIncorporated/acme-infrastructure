const fs = require('fs')
const path = require('path')

module.exports = () => {

  const masterNodeName = 'k8s_master'
  const workerNodeName = 'k8s_node'
  
  const tfStatePath = path.join('..', 'terraform', 'terraform.tfstate')

  const tfStateFile = fs.readFileSync(tfStatePath).toString()
  const tfState = JSON.parse(tfStateFile)
}