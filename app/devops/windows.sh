#!/usr/bin/env bash

PROJECT_NAME=$1
PROJECT_HOSTNAME=$2
PROJECT_ALIASES=$3
PROJECT_ROOT=$4
PROJECT_PUBLIC=$5
PROJECT_WEBSERVER=$6
SERVER_SWAP=$7

sudo apt-get update
sudo apt-get install -y software-properties-common python-software-properties
sudo add-apt-repository -y ppa:ansible/ansible
sudo apt-get update
sudo apt-get install -y ansible

sudo cp $PROJECT_ROOT/app/devops/inventories/development /etc/ansible/hosts -f
sudo chown root:root /etc/ansible/hosts
sudo chmod 0666 /etc/ansible/hosts
cat $PROJECT_ROOT/app/devops/files/authorized_keys >> $HOME/.ssh/authorized_keys

ansible-playbook $PROJECT_ROOT/app/devops/vagrant.yml --connection=local --extra-vars "project_name=$PROJECT_NAME project_hostname=$PROJECT_HOSTNAME project_aliases=$PROJECT_ALIASES project_root=$PROJECT_ROOT project_public=$PROJECT_PUBLIC project_webserver=$PROJECT_WEBSERVER server_swap=$SERVER_SWAP"
