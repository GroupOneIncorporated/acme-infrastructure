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
  image_name  = "Debian 9"
  flavor_name = "c2-r2-d20"
  key_pair    = openstack_compute_keypair_v2.k8s.name

  availability_zone_hints = "Education"

  network {
    name = "k8s-network"
  }

  security_groups = ["default"]
}

resource "openstack_networking_floatingip_v2" "k8s_master" {
  count = var.num_k8s_masters
  pool  = "public"
}

resource "openstack_compute_floatingip_associate_v2" "k8s_master" {
  count       = var.num_k8s_masters
  instance_id = element(openstack_compute_instance_v2.k8s_master.*.id, count.index)
  floating_ip = element(
    openstack_networking_floatingip_v2.k8s_master.*.address,
    count.index,
  )
}