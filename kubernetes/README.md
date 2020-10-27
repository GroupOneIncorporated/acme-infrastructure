# Kubernetes
Some instructions for getting the cluster running with all necessities. 
"Root-folder" for following instructions is kubernetes.

## Cloud config
Create secret containing cloud credentials.  
To enable communication between the cloud controller manager and Openstack.

Credentials file is encrypted using ansible-vault, and should stay that way.  
To decrypt it in a tmp file and create a k8s secret, simply run the script.

### Run script
`./createsecret.sh`          

## Cluster wide

### Openstack Cloud Controller Manager (!Important!)
Necessary to get dynamic provisioning of volumes & loadbalancers working.

In cluster-wide folder: 

`kubectl apply -f openstack-cloud-controller-manager`

### CSI-Cinder plugin (!Important!)
Necessary for Openstack volumes.

In cluster-wide folder: 

`kubectl apply -f csi-cinder-plugin`

### NFS provisioner (!Important!)
Enables ReadWriteMany type for persistence.

```
helm repo add stable https://charts.helm.sh/stable
helm install nfs-provisioner -f nfs-values.yaml stable/nfs-server-provisioner
```

### Storage Classes (!Important!)
Necessary for persistent data (Wordpress, MariaDB).

In cluster-wide folder: 

`kubectl apply -f storage-classes`

### Nginx Ingress Controller (!Important!)
Necessary to manage ingress resources. Connects to external loadbalancer.

```
helm repo add bitnami https://charts.bitnami.com/bitnami
helm install ingress-controller -f <values-file> bitnami/nginx-ingress-controller 
```

Where `<values-file>` is the proper values file.

Example:
`helm install ingress-controller -f ingress-controller-values.yaml bitnami/nginx-ingress-controller`

### Cluster Issuers (!Important!)

#### Install Cert-Manager
Necessary for automatic issuing of certificates.

##### 1 create a namespace for cert-manager
`kubectl create namespace cert-manager`
##### 2 install CustomResourceDefinitions and cert-manager
`kubectl apply --validate=false -f https://github.com/jetstack/cert-manager/releases/download/v1.0.0/cert-manager.yaml`
##### 3 Confirm installation
`kubectl apply -f test-resources.yaml` 

See: https://cert-manager.io/docs/installation/kubernetes/#verifying-the-installation
##### 4 clean up the test resources
`kubectl delete -f test-resources.yaml` 

#### Install ClusterIssuers
Necessary for automatic issuing of certificates.

##### Staging issuer (for testing)
In cert-manager folder: 

`kubectl apply -f letsencrypt-staging`
##### Production issuer (for production)
In cluster-issuers folder: 

`kubectl apply -f letsencrypt-prod`

#### Delete Cert-Manager
`kubectl delete -f https://github.com/jetstack/cert-manager/releases/download/v0.13.1/cert-manager.yaml`

## Dashboard
Nice tool for a GUI overview of the cluster.

### Installation
`kubectl apply -f https://raw.githubusercontent.com/kubernetes/dashboard/v2.0.0-beta8/aio/deploy/recommended.yaml`

While in root folder: 

`kubectl apply -f dashboard`

### Running
#### Get token
`kubectl -n kubernetes-dashboard describe secret $(kubectl -n kubernetes-dashboard get secret | grep admin-user | awk '{print $1}')`

#### Start proxy
`kubectl proxy`

#### Use
Visit: http://localhost:8001/api/v1/namespaces/kubernetes-dashboard/services/https:kubernetes-dashboard:/proxy/ 

Use token fetched in previous step to login.

## Namespaces
`kubectl apply -f <name>-namespace.yaml` in namespaces-folder.

## Helm
While in the acme-platform-folder.

### Installation of chart
`helm install -f <path-to-env-values> <name> ./<umbrella-chart-name> -n <namespace-name>` 
- Where `<path-to-env-values>` is the path to the values.yaml file for the namespace. Example: env/test/values.yaml.
- Where `<name>` is the desired deployment name.
- Where `<umbrella-chart-name>` is the name of the umbrella chart to deploy.
- Where `<namespace-name>` is the name of the namespace to deploy in.

Example: 
`helm install -f env/values.yaml acmeplatform ./wordpress-platform -n acme`

### Update chart installation
`helm upgrade -f <path-to-env-values> <name> ./<umbrella-chart-name> -n <namespace-name>`

### Uninstall chart
`helm uninstall <name> -n <namespace-name>`

### Lint chart
`helm lint -f <path-to-env-values> ./<umbrella-chart-name> -n <namespace-name>`

### Debug chart 
`helm install -f <path-to-env-values> <name> ./<umbrella-chart-name> -n <namespace-name> --dry-run --debug`

### List active charts
`helm list -n <namespace-name>`

## Testing

### Simulate node failure / drain node
`kubectl drain <node-name> --force --delete-local-data --ignore-daemonsets`

### Reset drained node
`kubectl uncordon <node-name>`

### Enter pod
`kubectl exec --stdin --tty <pod-name> -n <namespace-name> -- /bin/bash`

## Various stuff

### Inspect secret
`kubectl get secret regcred --output=yaml -n test`
`kubectl get secret regcred -n test --output="jsonpath={.data.\.dockerconfigjson}" | base64 --decode`

### Port-forwarding
Can be used for Robo 3t etc.  

`kubectl port-forward svc/<service name> <port>:<port> --namespace <namespace`