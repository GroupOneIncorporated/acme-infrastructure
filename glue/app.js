const terraformParser = require('./terraformParser')
const configCreator = require('./configCreator')

const parsedHosts = terraformParser()
configCreator(parsedHosts)
