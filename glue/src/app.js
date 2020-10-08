import { createRequire } from 'module'
import * as path from 'path'

import Parser from './parser.js'
import Creator from './creator.js'

const require = createRequire(import.meta.url)
const os = require('os')

try {
  let config
  var args = process.argv.slice(2)
  if (args[0] && typeof args[0] === 'string' && args[0] !== '') {
    config = require('./configs/' + args[0])
  } else {
    config = require('./configs/default.json')
  }

  _setPaths(config)

  const parser = new Parser(config.tfstatePath)

  const creator = new Creator(parser.getNodeInfo(config.nodeTypes), config.ssh, config.ansible, config.rke)
  creator.createAnsibleHosts()
  creator.createSSHConfig()
  creator.createRKEClusterYaml()
} catch (err) {
  console.log(err)
}

/**
 * Set paths correctly.
 *
 * @param {object} config the config.
 */
function _setPaths (config) {
  config.tfstatePath = _getPath(config.tfstatePath)
  config.ssh.configPath = _getPath(config.ssh.configPath)
  config.ansible.hostsPath = _getPath(config.ansible.hostsPath)
  config.rke.configPath = _getPath(config.rke.configPath)
}

/**
 * Helper method to get clean path.
 *
 * @author Johan Andersson
 * @param {string} inputPath the path.
 * @returns {string} clean path.
 */
function _getPath (inputPath) {
  const splitPath = inputPath.split(path.sep)
  _untildifyPath(splitPath)
  return path.join.apply(null, splitPath)
}

/**
 * Untildifies a split path.
 *
 * @param {Array} splitPath the path to untildify.
 */
function _untildifyPath (splitPath) {
  if (splitPath[0] === '~') {
    splitPath[0] = os.homedir()
  }
}
