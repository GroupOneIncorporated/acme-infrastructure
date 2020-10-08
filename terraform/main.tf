resource "openstack_compute_keypair_v2" "my-cloud-key" {
  # Keypair on Openstack imported into the state file using "terraform import"
  # Doc: https://registry.terraform.io/providers/terraform-provider-openstack/openstack/latest/docs/resources/compute_keypair_v2#import
  name = "jd222qf_Keypair"
}