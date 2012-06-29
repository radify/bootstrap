DIR=$1

echo "Creating build files and directories..."
cp $DIR/resources/composer.json ./composer.json
cp $DIR/resources/Vagrantfile ./Vagrantfile

mkdir ./_build 2> /dev/null
mkdir ./_build/bin 2> /dev/null
touch ./_build/bin/empty 2> /dev/null
mkdir ./_build/manifests 2> /dev/null

cp $DIR/resources/manifests/default.conf ./_build/manifests/default.conf 2> /dev/null
cp $DIR/resources/manifests/default.pp ./_build/manifests/default.pp 2> /dev/null
cp $DIR/resources/manifests/php.ini ./_build/manifests/php.ini 2> /dev/null
cp $DIR/resources/test ./_build/test 2> /dev/null

touch `pwd`/.gitignore 2> /dev/null

/usr/bin/env php $DIR/scripts/init_project_files.php `pwd`
/usr/bin/env php $DIR/scripts/init_project_repo.php `pwd`
