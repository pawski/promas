#!/usr/bin/env bash
# Remove stale box
if [ -f ./promas-db.box ]; then
    rm ./promas-db.box
fi

# Compacting image

# Building Vagrant box
vagrant package db --output promas-db.box
