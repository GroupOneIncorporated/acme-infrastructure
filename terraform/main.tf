provider "openstack" {
  version = "~> 1.17"
}

resource "openstack_networking_router_v2" "k8s-router" {
  name                = "k8s-router"
  external_network_id = "f67f0d72-0ddf-11e4-9d95-e1f29f417e2f"
}

resource "openstack_compute_keypair_v2" "k8s" {
  name       = "k8s-keys"
  public_key = chomp(file(var.public_key_path))
}

# -- Networking -- #

// Internal network
resource "openstack_networking_network_v2" "k8s-network" {
  name           = "k8s-network"
  admin_state_up = "true"
}

// Internal network subnet
resource "openstack_networking_subnet_v2" "k8s-subnet" {
  name       = "k8s-subnet"
  network_id = "${openstack_networking_network_v2.k8s-network.id}"
  cidr       = "192.168.199.0/24"
  ip_version = 4
}

// Router for connecting internal network with the public
resource "openstack_networking_router_v2" "k8s-router" {
  name                = "k8s-router"
  external_network_id = "fd401e50-9484-4883-9672-a2814089528c"
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
  image_name  = "Debian 9"
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