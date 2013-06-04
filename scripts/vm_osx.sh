#!/bin/bash

echo -e "\e[0;32mChecking virtual machine system...\e[0;m"
echo ""

if [[ "$(which vagrant)" != "" && "$(which VBoxManage)" != "" ]]; then
	echo "Passed."
else
	echo "One or more required virtual machine components not installed."
	read -rsn 1 -p "Press enter to install now..." < /dev/tty
fi

if [ "$(which VBoxManage)" == "" ]; then
	echo "VirtualBox not installed, downloading now...";
	curl --progress-bar http://dlc.sun.com.edgesuite.net/virtualbox/4.1.20/VirtualBox-4.1.20-80170-OSX.dmg -o /tmp/VirtualBox.dmg
	echo "Installing..."
	hdiutil attach /tmp/VirtualBox.dmg > /dev/null
	sudo installer -pkg /Volumes/VirtualBox/VirtualBox.mpkg -target / > /dev/null
	hdiutil eject /Volumes/VirtualBox > /dev/null
	echo "Done."
fi

if [ "$(which vagrant)" == "" ]; then
	echo "Vagrant not installed, downloading now...";
	curl --progress-bar http://files.vagrantup.com/packages/eb590aa3d936ac71cbf9c64cf207f148ddfc000a/Vagrant-1.0.3.dmg -o /tmp/Vagrant.dmg
	echo "Installing..."
	hdiutil attach /tmp/Vagrant.dmg > /dev/null
	sudo installer -pkg /Volumes/Vagrant/Vagrant.pkg -target / > /dev/null
	hdiutil eject /Volumes/Vagrant > /dev/null
	echo "Done."
fi

echo ""
echo -e "\e[0;32mInstallation complete.\e[0;m"
echo ""
