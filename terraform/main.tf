resource "openstack_compute_keypair_v2" "my-cloud-key" {
  # Keypair on Openstack imported into the state file using "terraform import"
  # Doc: https://registry.terraform.io/providers/terraform-provider-openstack/openstack/latest/docs/resources/compute_keypair_v2#import
  name = "jd222qf_Keypair"
}

// creating internal network and subnet
resource "openstack_networking_network_v2" "internal-network" {
  name           = "internal-network"
  admin_state_up = "true"
}

// (subnet is required for attaching instances to network)
resource "openstack_networking_subnet_v2" "internal-subnet" {
  name       = "internal-subnet"
  network_id = openstack_networking_network_v2.internal-network.id
  cidr       = "192.168.199.0/24"
}

// adding router (to provide external network access for servers on internal network) and its interface (to connect the networks)
resource "openstack_networking_router_v2" "router-1" {
  name = "router-1"
  admin_state_up = true
  external_network_id = "fd401e50-9484-4883-9672-a2814089528c" //from OpenStack dashboard
}

resource "openstack_networking_router_interface_v2" "router-1-interface" {
  router_id = openstack_networking_router_v2.router-1.id
  subnet_id = openstack_networking_subnet_v2.internal-subnet.id
}


resource "openstack_compute_instance_v2" "test" {
  name            = "test-vm"
  image_name      = "Ubuntu Minimal 18.04"
  flavor_name     = "c1-r1-d10"
  # Using the keypair resource previously created
  key_pair        = openstack_compute_keypair_v2.my-cloud-key.name
  security_groups = ["default"]
  availability_zone_hints = "Education"

  network {
    name = "internal-network"
  }
}