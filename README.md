# PhpSkeleton

## Preparation

Configure Git on Windows before cloning:

```sh
git config --global core.autocrlf input
```


## Development environments

Choose one.

Host is discouraged because maintaining the environment across multiple operating systems is more work than virtualized environments.
Docker is the suggested way, because it is available on M1 and promises the most environment stability.
Docker Compose is optional and like Docker.
Virtual Machine is in need of migration to QEMU because VirtualBox will not be supported on M1.


### Host

Run the main program:

```sh
bin/phsk
```

Run tests, style check and metrics:

```sh
script/test.sh
script/check.sh
script/measure.sh
```

Build project:

```sh
script/build.sh
```


### Container: Docker

Run the main program:

```sh
docker run -it --rm funtimecoding/php-skeleton
```


### Container: Docker Compose

Run the main program:

```sh
docker-compose run
```


### Virtual machine: VirtualBox

Install project dependencies:

```sh
script/setup.sh
```

Install NFS plug-in for Vagrant on Windows:

```bat
vagrant plugin install vagrant-winnfsd
```

Create the development virtual machine on Linux and Darwin:

```sh
script/vagrant/create.sh
```

Create the development virtual machine on Windows:

```bat
script\vagrant\create.bat
```

Install Debian package:

```sh
sudo dpkg --install build/php-skeleton_0.1.0-1_all.deb
```

Show files the package installed:

```sh
dpkg-query --listfiles php-skeleton
```
