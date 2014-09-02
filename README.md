# UoR Bootstrap

This project provides the basis for running applications inside a virtual machine (Unbuntu 12.04 64-bit).

## Requirements

Assumes PHP and Python are installed, the setup script needs [VirtualBox](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](http://vagrantup.com/) to run the development virtual machine.

The script will manage all the installation only for the following OS:
- OSX
- Unbuntu 12.04+
- Debian 6.0+
- And should work on all recent debian based distributions.

If you don't have one of the above OS, please follow the manual installation section bellow.

### Manual installation of `VirtualBox` and `vagrant`

To avoid a lot of issues, you'll need to install at least:
- VirtualBox 4.1.8+
- vagrant 1.2.2+

### 32-bit CPU

Since the virtual machine used a 64-bit OS, You need to enable the `Virtualization Technology` (CPU bios menu of your motherboard) to avoid the `Error : vt-x features locked or unavailable in msr` error.

## Installation

```
curl -s https://raw.github.com/uor/bootstrap/master/init | bash
```

If the installation is successful, the development environment will boot automatically and a new browser window should open. Otherwise you can browse to `localhost:8081` (the port is configurable in [Vagrantfile](https://github.com/uor/oota/blob/master/Vagrantfile)).

The `init` script will at least:
- create a git repository if the directory is not a git repository
- add the `lithium` dependency either with composer or with a git submodule (a yes/no prompt is used for making this choice).

In gross, the `init` script should be able to deal with any kind of repository.

**The `init` script assume the web root directory is there => `./webroot`**

### A minimal working example

```
mkdir myproject
cd myproject
mkdir webroot && echo "<?php phpinfo();?>" > webroot/index.php
curl -s https://raw.githubusercontent.com/uor/bootstrap/master/init | bash
```

Once the `init` script is done, you should be able to browse `localhost:8081`.

## Upgrading the VM

If you wan't to upgrate the VM with recent changes in `uor/bootstrap`, run the following commands:
```
rm _build Vagrantfile
./init
```

## Usefull `vagrant` commands

From the root directory of your project you can use the following usefull `vagrant` command.

**Starting the virtual machine:**
```
vagrant up
```

**Shutdown the virtual machine:**
```
vagrant halt
```

**Destroying the virtual machine:**
```
vagrant destroy
```

**Getting a SSH console to the virtual machine:**
```
vagrant ssh
```

**Running the tests:**
```
./_build/test
```

**Running an arbitrary command, for example the tests:**
```
vagrant ssh -c 'cd /vagrant && libraries/lithium/console/li3 test tests/cases $0'
```

## Notes

If you see 'r??' in the installation output, try adding this to your `php.ini`:

`detect_unicode = Off`
