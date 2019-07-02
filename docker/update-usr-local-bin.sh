#!/usr/bin/env bash

set -x
BASEDIR=$(dirname $0)

sudo cp ${BASEDIR}/docker-*.sh /usr/local/bin/
sudo cp ${BASEDIR}/dockupdate /usr/local/bin/
