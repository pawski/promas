#!/usr/bin/env bash

echo "=> Making guest folder writable"
chmod -R 777 /vagrant/guest-shared-storage

# Running custom provision
if [ -f /vagrant/custom-provision-database-box.sh ]; then
    echo '=> Running custom provisioning'
    /vagrant/custom-provision-db-box.sh
    echo '=> Custom provisioning finished'
fi
