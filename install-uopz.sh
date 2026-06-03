#!/bin/bash

if [[ $PHP_VERSION == 7.* ]]; then
  pecl install uopz-6.1.2
  exit 0
fi

apt update

apt install -y curl
curl -L https://github.com/krakjoe/uopz/archive/14c8fc2d6eff14ec9acd926b9cab85d6961c64ac.zip -o /tmp/uopz.zip

apt install -y zip
unzip /tmp/uopz.zip -d /tmp

cd /tmp/uopz-14c8fc2d6eff14ec9acd926b9cab85d6961c64ac
phpize
./configure --enable-uopz
make
make install
