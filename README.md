# GateKeeper
A user management and authentication API for multi-user systems, with numerous features. GateKeeper is written in __PHP 7.1__.

## Tools and Frameworks used:
__CodeIgniter__: GateKeeper is built with CodeIgniter framework. CodeIgniter is chosen to keep GateKeeper light weight, to boost speed and to pack GateKeeper with top notch security toolkits.

__Composer__: For dependency management

__Doctrine__: For ORM and database query

## Design of GateKeeper
To see the software architecture files please go to the Architecture folder and download `design.archimate`

### Setup Guide:
1. Open command line and move to the location were you want to have GateKeeper present and clone it.

2. Open MySQL on command line with ``-u root`` option (to be root!) and run the following:
``CREATE DATABASE gatekeeper;``
``USE mysql;``
``GRANT ALL PRIVILEGES ON gatekeeper TO 'gatekeeper'@'localhost' IDENTIFIED BY 'gatekeeper';``
