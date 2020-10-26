helm repo add bitnami https://charts.bitnami.com/bitnami
helm install ingress-controller -f ingress-controller-values.yaml bitnami/nginx-ingress-controller 