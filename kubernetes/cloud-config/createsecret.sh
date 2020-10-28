#!/usr/bin/env bash

export TMPDIR=$(mktemp -d $tmp)

echo $TMPDIR

ansible-vault decrypt $1 --output $TMPDIR/cloud.conf

kubectl create secret -n kube-system generic cloud-config --from-file=$TMPDIR/cloud.conf

rm -r $TMPDIR