provider "openstack" {
  version = "~> 1.32"
}

// ---------- KEY PAIR ----------
# using newly created key/pair
resource "openstack_compute_keypair_v2" "my-cloud-key" {
  name = "my-2dv517-keypair"
  public_key = chomp(file(var.public_key_path))
}


// ---------- NETWORK ----------
// Creating internal network and respective subnet
// Subnet is not mandatory per se, but OpenStack requires one for attaching instances to a network
// Routing is needed to provide external network access to servers on the internal network
// Routing interface is needed to connect both networks
resource "openstack_networking_network_v2" "internal-network" {
  name           = "internal-network"
  admin_state_up = "true"
}

resource "openstack_networking_subnet_v2" "internal-subnet" {
  name       = "internal-subnet"
  network_id = openstack_networking_network_v2.internal-network.id
  cidr       = "192.168.199.0/24"
}

resource "openstack_networking_router_v2" "router-1" {
  name = "router-1"
  admin_state_up = true
  external_network_id = "fd401e50-9484-4883-9672-a2814089528c" //from OpenStack dashboard
}

resource "openstack_networking_router_interface_v2" "router-1-interface" {
  router_id = openstack_networking_router_v2.router-1.id
  subnet_id = openstack_networking_subnet_v2.internal-subnet.id
}


// ---------- SECURITY GROUPS ----------
resource "openstack_networking_secgroup_v2" "secgroup_1" {
  name        = "secgroup_1"
  description = "instance security group"
}

resource "openstack_networking_secgroup_rule_v2" "secgroup_rule_ssh" {
  direction         = "ingress"
  ethertype         = "IPv4"
  protocol          = "tcp"
  port_range_min    = 22
  port_range_max    = 22
  remote_ip_prefix  = "0.0.0.0/0"
  security_group_id = openstack_networking_secgroup_v2.secgroup_1.id
}

resource "openstack_networking_secgroup_rule_v2" "secgroup_rule_ICMP" {
  direction         = "ingress"
  ethertype         = "IPv4"
  protocol          = "icmp"
  remote_ip_prefix  = "0.0.0.0/0"
  security_group_id = openstack_networking_secgroup_v2.secgroup_1.id
}

// ---------- INSTANCES ----------
resource "openstack_compute_instance_v2" "test" {
  name            = "test-vm"
  image_name      = "Ubuntu Minimal 18.04"
  flavor_name     = "c1-r1-d10"
  //count = ...
  # Using the keypair resource previously created
  key_pair        = openstack_compute_keypair_v2.my-cloud-key.name
  security_groups = ["default", "secgroup_1"]
  availability_zone_hints = "Education"

  network {
    name = "internal-network"
  }
}


// ---------- FLOATING IPs ----------
// Required for external access to instances
// Openstack does not automatically assign floating IPs, they are allocated by administrators.
// Project has 3 available floating IPs (pool = "public") per user
// resources: network_floatingip_v2 to create (compute_floatingip is deprecated), compute_floatingip_associate_v2 to assign to compute instances

resource "openstack_networking_floatingip_v2" "float-ip" {
  //count = ...
  pool = "public" //required. project pool has 3 floating ips available
}

resource "openstack_compute_floatingip_associate_v2" "float-ip-associate" {
  //count = ...
  instance_id = openstack_compute_instance_v2.test.id
  floating_ip = openstack_networking_floatingip_v2.float-ip.address
}





