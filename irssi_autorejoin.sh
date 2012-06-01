#!/bin/bash

pushd ~
mkdir -p ~/.irssi/plugins/autorun
pushd ~/.irssi/plugins

wget http://scripts.irssi.org/scripts/autorejoin.pl
chmod +x autorejoin.pl
pushd ~/.irssi/plugins/autorun
ln -snf ../autorejoin.pl .
popd

popd
popd

echo "Now run /script load autorejoin in your irssi session, and it will autorun when you next start."
