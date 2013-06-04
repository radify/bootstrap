version_cmp () {
	if [[ $1 == $2 ]]; then
		return 0
	fi
	local IFS=.
	local i ver1=($1) ver2=($2)
	for ((i=${#ver1[@]}; i<${#ver2[@]}; i++)); do
		ver1[i]=0
	done
	for ((i=0; i<${#ver1[@]}; i++)); do
		if [[ -z ${ver2[i]} ]]; then
			ver2[i]=0
		fi
		if ((10#${ver1[i]} > 10#${ver2[i]})); then
			return 1
		fi
		if ((10#${ver1[i]} < 10#${ver2[i]})); then
			return 2
		fi
	done
	return 0
}

echo -e "\e[0;32mChecking virtual machine system...\e[0;m"
echo ""

if [[ "$(which vagrant)" != "" && "$(which VBoxManage)" != "" ]]; then
	echo "Passed."
else
	echo -e "\e[1;33mOne or more required virtual machine components not installed.\e[0;m"
	read -rsn 1 -p "Press enter to install now..." < /dev/tty
fi

VIRTUALBOX_VERSION=$(VBoxManage --version 2> /dev/null | sed 's/[^0-9.]*\([0-9.]*\).*/\1/')
version_cmp $VIRTUALBOX_VERSION '4.1.8'
if [[ $? == 2 ]]; then
	echo -e "\e[0;31mError: Your VirtualBox version \`$version\` is too old, please update to a newer version or simply remove it.\e[0;m"
	exit 1
fi

if [[ "$(which VBoxManage)" == "" ]]; then
	echo "VirtualBox is not installed, installing now..."
	sudo apt-key list | grep "1024D/98AB5139" > /dev/null || wget -q http://download.virtualbox.org/virtualbox/debian/oracle_vbox.asc -O- | sudo apt-key add -
	SOURCE="deb http://download.virtualbox.org/virtualbox/debian precise contrib"
	cat /etc/apt/sources.list | grep "$SOURCE" > /dev/null || echo "$SOURCE" | sudo tee -a /etc/apt/sources.list > /dev/null
	sudo apt-get update && sudo apt-get install -y virtualbox-4.2
	echo "Done."
fi

if [[ "$(which vagrant)" == "" ]]; then
	echo "Vagrant not installed, downloading now...";
	MACHINE_TYPE=`uname -m`
	if [ ${MACHINE_TYPE} == 'x86_64' ]; then
		URL='http://files.vagrantup.com/packages/7e400d00a3c5a0fdf2809c8b5001a035415a607b/vagrant_1.2.2_x86_64.deb'
	else
		URL='http://files.vagrantup.com/packages/7e400d00a3c5a0fdf2809c8b5001a035415a607b/vagrant_1.2.2_i686.deb'
	fi
	echo "Installing..."
	FILE="/tmp/vagrant.deb"
	curl --progress-bar "$URL" -o $FILE && sudo dpkg -i $FILE
	rm $FILE
	echo "Done."
fi

VAGRANT_VERSION=$(vagrant --version 2> /dev/null | sed 's/[^0-9.]*\([0-9.]*\).*/\1/')
version_cmp $VAGRANT_VERSION '1.1.5'
if [[ $? == 2 ]]; then
	INSTALL_COMMAND='gem'
else
	INSTALL_COMMAND='plugin'
fi

echo -e "Installing the VirtualBox Guest Additions auto installer..."
vagrant $INSTALL_COMMAND install vagrant-vbguest

echo ""
echo -e "\e[0;32mInstallation complete.\e[0;m"
echo ""
