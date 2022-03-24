# Tournament simulation

An example of how you can apply scalable, maintaining and clean architecture to solve a simple task for simulate tournament matches.

## Layered

To make the code organised each module uses Layered Architecture and each functional area is divided on four layers:

* `Application`
* `Doman`
* `Infrastructure`
* `UI`

## Stack

* PHP 8.1
* Symfony 6.0
* RabbitMQ
* Redis
* Postgre

## Docker Install

### Native Docker for MAC

1. Install the stable version [docker for MAC](https://docs.docker.com/docker-for-mac/install/#download-docker-for-mac)

### Docker for Ubuntu (20.04 LTS)

1. [Install docker-engine](https://docs.docker.com/engine/installation/linux/ubuntu/)
2. [Manage Docker as a non-root user](https://docs.docker.com/engine/installation/linux/linux-postinstall/)
3. [Install docker-compose (Version 1.6.2)](https://docs.docker.com/compose/install/)

## Project Install

* Run `make install`
* Add docker machine IP to /etc/hosts

## Available Commands

* Create tournament: `ts:generate-tournament`
* Simulate matches: `ts:simulate-tournament`
* Build forecast: `ts:forecast-tournament`

### Hosts configuration

**GNU/Linux platform**
```
0.0.0.0    app.docker
```
**Mac OS X platform**
```
127.0.0.1  app.docker
```

# Links
1 [Round-robin tournament](https://en.wikipedia.org/wiki/Round-robin_tournament)
2 [Goal difference](https://en.wikipedia.org/wiki/Goal_difference)