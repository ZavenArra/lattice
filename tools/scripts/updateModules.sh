#!/bin/bash
git clone  ssh://source@dev2.winterroot.net/var/www/git/fullobject.git/ update
cd update
git checkout v2.0
rm -Rf ../modules
cp -Rp modules ../modules
