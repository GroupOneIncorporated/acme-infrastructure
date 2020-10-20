variable "public_key_path" {
  default = "~/.ssh/GroupOneInc.pub"
}

variable "num_k8s_masters" {
  default = 1
}

variable "num_k8s_nodes" {
  default = 5
}