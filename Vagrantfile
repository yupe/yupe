Vagrant.configure("2") do |config|

  #config.vm.box = "precise64"
  #config.vm.box_url = "http://files.vagrantup.com/precise64.box"
  #config.vm.box_url = "../precise64.box"

  config.vm.box = "precise32"
  #config.vm.box_url = "http://files.vagrantup.com/precise32.box"
  config.vm.box_url = "../guido32.box"
  
  #config.vm.provision :shell, :path => "carcass/vagrant/prepare-centos65.sh"

  config.vm.provision :shell, :path => "carcass/vagrant/prepare-precise.sh"
  config.vm.provision :shell, :path => "carcass/vagrant/setup-app.sh"

  config.vm.network "forwarded_port", guest: 80, host: 9080 # frontend (www)


  config.vm.network "forwarded_port", guest: 89, host: 9089 # PhpMyAdmin

end

