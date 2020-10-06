variable "public_key_path" {
  default = "~/.ssh/ja222um.pub"
}

variable "num_k8s_masters" {
  default = 1
}

variable "num_k8s_nodes" {
  default = 3
}