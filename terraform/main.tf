provider "openstack" {
  version = "~> 1.17"
}

resource "openstack_compute_keypair_v2" "k8s" {
  name       = "k8s-keys"
  public_key = chomp(file(var.public_key_path))
}

# -- Master node(s) -- #

// Compute instance
resource "openstack_compute_instance_v2" "k8s_master" {
  name        = "k8s-master-${count.index + 1}"
  count       = var.num_k8s_masters
  image_name  = "Debian 9"
  flavor_name = "c2-r2-d20"
  key_pair    = openstack_compute_keypair_v2.k8s.name

  availability_zone_hints = "Education"

  network {
    name = "k8s-network"
  }

  security_groups = ["default"]
}

// Floating IP
resource "openstack_networking_floatingip_v2" "k8s_master" {
  count = var.num_k8s_masters
  pool  = "public"
}

// Floating IP associate
resource "openstack_compute_floatingip_associate_v2" "k8s_master" {
  count       = var.num_k8s_masters
  instance_id = element(openstack_compute_instance_v2.k8s_master.*.id, count.index)
  floating_ip = element(
    openstack_networking_floatingip_v2.k8s_master.*.address,
    count.index,
  )
}

# -- Worker node(s) -- #

// Compute instance
resource "openstack_compute_instance_v2" "k8s_node" {
  name        = "k8s-node-${count.index + 1}"
  count       = var.num_k8s_nodes
  image_name  = "Debian"
  flavor_name = "c2-r4-d20"
  key_pair    = openstack_compute_keypair_v2.k8s.name

  availability_zone_hints = "Education"

  network {
    name = "k8s-network"
  }

  security_groups = ["default"]
}

// Floating IP
resource "openstack_networking_floatingip_v2" "k8s_node" {
  count = var.num_k8s_nodes
  pool  = "public"
}

// Floating IP associate
resource "openstack_compute_floatingip_associate_v2" "k8s_node" {
  count       = var.num_k8s_nodes
  instance_id = element(openstack_compute_instance_v2.k8s_node.*.id, count.index)
  floating_ip = element(
    openstack_networking_floatingip_v2.k8s_node.*.address,
    count.index,
  )
}