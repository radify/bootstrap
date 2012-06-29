#!/bin/bash

echo ""
echo "Loading submodules..."
/usr/bin/env git submodule update --init
echo ""

echo "Initializing Composer..."
/usr/bin/env php scripts/composer.phar self-update

echo "Installing Composer dependencies..."
rm -rf composer.lock
/usr/bin/env php composer.phar install
