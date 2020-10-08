resource "openstack_compute_keypair_v2" "my-cloud-key" {
  # Keypair on Openstack imported into the state file using "terraform import"
  # Doc: https://registry.terraform.io/providers/terraform-provider-openstack/openstack/latest/docs/resources/compute_keypair_v2#import
  name = "jd222qf_Keypair"
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
    name = "public"
  }
}