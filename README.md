# CPSC 304 Group 114 Project
### Description
A simple website involving MariaDB as a backend and PHP and Apache as the frontend

## Self Hosting

## Using Docker
### Prerequsites

| Platform | Program |
| ------ | ------ |
| Windows/Mac| [Docker Desktop][DockerDesktopLink] |
|Linux| [Docker Engine][DockerEngineLink] and [Docker Compose][DockerComposeLink]|

#### Starting the Program 
```sh
make build
```
On your first run, this will build PHP with the appropiate prerequisites
```sh
make run
```
This will setup an apache server on localhost:8080 and the MariaDB backend on localhost:3040

#### Terminating the Program
```sh
make stop
```

#### Accessing the mySQL backend from the command line
```sh
mysql -h localhost -P 3040 --protocol=tcp -u cs304 -p
```
The password (default cs304) will be accepted via stdin. If the port changes in docker-compose.yml, change ```3040``` to the appropiate port. 
#### Loading the database
```mysql
mysql> USE cs304-project;
```

[DockerDesktopLink]: <https://www.docker.com/products/docker-desktop>
[DockerEngineLink]: <https://docs.docker.com/engine/install/#server>
[DockerComposeLink]: <https://docs.docker.com/compose/install>
