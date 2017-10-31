#!/usr/bin/env bash

echo "=> Making guest folder writable"
chmod -R 777 /vagrant/guest-shared-storage

service nginx restart

# Running custom provision
if [ -f /vagrant/custom-provision-www-box.sh ]; then
    echo '=> Running custom provisioning'
    /vagrant/custom-provision-www-box.sh
    echo '=> Custom provisioning finished'
fi
