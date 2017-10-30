#!/usr/bin/env bash
# Remove stale box
if [ -f ./promas-build.box ]; then
    rm ./promas-build.box
fi

# Compacting image

# Building Vagrant box
vagrant package build --output promas-build.box
