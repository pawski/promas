#!/usr/bin/env bash
# Remove stale box
if [ -f ./promas-www.box ]; then
    rm ./promas-www.box
fi

# Compacting image

# Building Vagrant box
vagrant package www --output promas-www.box
