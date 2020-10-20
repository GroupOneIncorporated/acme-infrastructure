# Install cert-manager

## 1 create a namespace for cert-manager

kubectl create namespace cert-manager

## 2 install CustomResourceDefinitions and cert-manager

kubectl apply --validate=false -f https://github.com/jetstack/cert-manager/releases/download/v1.0.0/cert-manager.yaml

## Delete

kubectl delete -f https://github.com/jetstack/cert-manager/releases/download/v1.0.0/cert-manager.yaml

## 3 Confirm installation

kubectl apply -f test-resources.yaml

check: https://cert-manager.io/docs/installation/kubernetes/#verifying-the-installation

## 4 clean up the test resources

kubectl delete -f test-resources.yaml

TODO: continue

kubectl delete -f https://github.com/jetstack/cert-manager/releases/download/v0.13.1/cert-manager.yaml