#!/bin/bash

if [[ "$(which vagrant)" != "" && "$(which VBoxManage)" != "" ]]; then
	echo "Passed."

	echo ""
	echo "Checking for base box..."

	if [[ "$(vagrant box list)" =~ lucid64 ]]; then
		echo "Base box installed."
	else
		echo "Not found. Installing base box lucid64..."
		vagrant box add lucid64 http://files.vagrantup.com/lucid64.box
	fi
	if [[ "$(vagrant box list)" =~ lucid64 ]]; then
		echo ""
		echo "You may start the project by running \`vagrant up\` and browsing to http://localhost:8081 (port mapping can be changed in ./Vagrantfile)."

		echo ""
		read -rsn 1 -p "Press enter to launch the project now..." < /dev/tty
		echo ""

		vagrant destroy -f > /dev/null
		vagrant up
		open "http://localhost:8081"
	fi
fi
echo ""

if [ "$(which VBoxManage)" == "" ]; then
	echo "VirtualBox not installed. Grab the latest version from https://www.virtualbox.org/wiki/Downloads"
fi

if [ "$(which vagrant)" == "" ]; then
	echo "Vagrant not installed. Grab the latest version from http://downloads.vagrantup.com/"
fi
echo ""
