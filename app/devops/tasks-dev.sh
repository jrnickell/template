#!/usr/bin/env bash

# save the project root
PROJECT_ROOT=$1

# source nvm
export PATH="$PATH:$HOME/.nvm/bin"
source ~/.nvm/nvm.sh

# source chruby
source /usr/local/share/chruby/chruby.sh
source /usr/local/share/chruby/auto.sh

# change to project root
cd $PROJECT_ROOT

# run tasks
php app/task install
php app/task assets
php app/task build
