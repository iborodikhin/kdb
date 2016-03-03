# KDB (Koraduba) #
[![Build Status](https://travis-ci.org/iborodikhin/kdb.png?branch=master)](https://travis-ci.org/iborodikhin/kdb)

## About ##

KDB is web-service for storing small files into BLOBs. It lays on [React HTTP server](https://github.com/reactphp/http)
as web-server and [PHP-Glue](https://github.com/iborodikhin/php-glue) as file storage component.

## Usage ##

To start application

1. clone source with `git clone`
2. inside KDB root directory type `./bin/server`
3. configuration can be found in `etc/config.php`

While KDB is running open console and try these commands

```
curl -XPOST 'http://localhost:1337/somepath' -d @somefile
curl -XHEAD 'http://localhost:1337/somepath'
curl -XGET 'http://localhost:1337/somepath'
curl -XDELETE 'http://localhost:1337/somepath'
```
