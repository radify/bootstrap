#!/bin/bash

echo ""
echo Loading submodules...
git submodule update --init
echo ""

echo Initializing Composer...
/usr/bin/env php composer.phar self-update

echo Installing Composer dependencies...
rm -rf composer.lock
/usr/bin/env php composer.phar install


echo ""
echo Installation complete. Checking virtual machine system...
echo ""


if [[ "$(which vagrant)" != "" && "$(which VBoxManage)" != "" ]]; then
	echo Passed. You may start the project by running \`vagrant up\` and
	echo browsing to http://localhost:8081 \(port mapping can be changed in ./Vagrantfile\).
fi
echo ""

if [ "$(which VBoxManage)" == "" ]; then
	echo VirtualBox not installed. Grab the latest version from https://www.virtualbox.org/wiki/Downloads
fi

if [ "$(which vagrant)" == "" ]; then
		echo Vagrant not installed. Grab the latest version from http://downloads.vagrantup.com/
fi
echo ""

echo Complete.
echo ""