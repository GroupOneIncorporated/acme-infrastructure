provider "openstack" {
  version = "~> 1.17"
}

resource "openstack_compute_keypair_v2" "k8s" {
  name       = "k8s-keys"
  public_key = chomp(file(var.public_key_path))
}

// Master node(s)

resource "openstack_compute_instance_v2" "k8s_master" {
  name        = "k8s-master-${count.index + 1}"
  count       = var.num_k8s_masters
  image_name  = "Debian 9.1.1"
  flavor_name = "2C-2GB"
  key_pair    = openstack_compute_keypair_v2.k8s.name

  network {
    name = "Default network"
  }

  security_groups = ["default"]
}
