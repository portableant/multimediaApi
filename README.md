Audio Guide API
=======================
[![DOI](https://zenodo.org/badge/19055/BritishMuseum/audioGuideApi.svg)](https://zenodo.org/badge/latestdoi/19055/BritishMuseum/audioGuideApi)

Introduction
------------
This is a combination of an AudioGuide API, and small web application; it is built using Zend Framework 2 and Apigility.
It uses the Contentful API to server data to the project, and a variety of libraries to achieve the aims of the project.

Outline of system
-----------------
The basic premise behind this project is this:
* Customer rents audio guide
* Follows trail around museum listening to audio at different stops
* Returns device, which is cleared and data sent via NFC integration
* This POSTs a JSON data file to the API endpoint
* A personalised webpage is generated and an email is sent to the user for them to view.

Installation
------------

Using Composer (recommended)
----------------------------

Alternately, clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/project/dir
    git clone urlforproject
    cd mmguide
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Another alternative for downloading the project is to grab it via `curl`, and
then pass it to `tar`:

    cd my/project/dir
    curl -#L urlforproject/tarball/master | tar xz --strip-components=1

You would then invoke `composer` to install dependencies per the previous
example.

Using Git submodules
--------------------
Alternatively, you can install using native git submodules:

    git clone --recursive giturlforproject

Updating with new code
----------------------

If you make changes to the code and want these to be deployed to the server, do the following:

    cd my/project/dir
    sudo git pull origin

If new libraries have been added:

    composer update

Clearing cache
--------------

The application caches full pages and also the calls to contentful. To clear these:

    cd my/project/dir/data/cache
    sudo rm -R zf*

Web server setup
----------------

### PHP CLI server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root
directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note:** The built-in CLI server is *for development only*.

### Vagrant server

This project supports a basic [Vagrant](http://docs.vagrantup.com/v2/getting-started/index.html) configuration with
an inline shell provisioner to run the Skeleton Application in a [VirtualBox](https://www.virtualbox.org/wiki/Downloads).

1. Run vagrant up command

    vagrant up

2. Visit [http://localhost:8085](http://localhost:8085) in your browser

Look in [Vagrantfile](Vagrantfile) for configuration details.

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-app.localhost
        DocumentRoot /path/to/zf2-app/public
        <Directory /path/to/zf2-app/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
            <IfModule mod_authz_core.c>
            Require all granted
            </IfModule>
        </Directory>
    </VirtualHost>

### Nginx setup

To setup nginx, open your `/path/to/nginx/nginx.conf` and add an
[include directive](http://nginx.org/en/docs/ngx_core_module.html#include) below
into `http` block if it does not already exist:

    http {
        # ...
        include sites-enabled/*.conf;
    }


Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/zf2-app.localhost.conf`
it should look something like below:

    server {
        listen       80;
        server_name  zf2-app.localhost;
        root         /path/to/zf2-app/public;

        location / {
            index index.php;
            try_files $uri $uri/ @php;
        }

        location @php {
            # Pass the PHP requests to FastCGI server (php-fpm) on 127.0.0.1:9000
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_param  SCRIPT_FILENAME /path/to/zf2-app/public/index.php;
            include fastcgi_params;
        }
    }

Restart nginx, now you should be ready to go!

### Using the API

The API endpoint can be found at http://hostname/visits and provides only GET and POST access to the resources
and is restricted by simple .htaccess username and password. Of course replace hostname with the url you have deployed.

This can easily be removed or changed to oauth/digest authentication.

#### Example

POST data to the endpoint using CURL as an example:

    curl -H "Content-Type: application/json" -X POST --data "@example.json" http://hostname/visits -u "username:password"

If successful with your POST request, the  endpoint will return:

    HTTP/1.1 100 Continue
    We are completely uploaded and fine
    HTTP/1.1 201 Created

GET collections data from the endpoint using CURL:

    curl -v -H "Content-Type: application/json" -X GET http://hostname/visits?page=7 -u "username:password"

GET entity data from the endpoint using CURL:

    curl -v -H "Content-Type: application/json" -X GET http://hostname/visits/1 -u "username:password"

#### Error messages

Empty payload:

    HTTP/1.1 422 Unprocessable Entity
    {"validation_messages":{"payload":["The multi-part file upload must not be empty."]},"type":"http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html","title":"Unprocessable Entity","status":422,"detail":"Failed Validation"}

Bad request:

    HTTP/1.1 400 Bad Request
    {"type":"http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html","title":"Bad Request","status":400,"detail":"JSON decoding error: Syntax error, malformed JSON"}

Unauthorised request (missing username/password):

    HTTP/1.1 403 Forbidden
    {"type":"http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html","title":"Forbidden","status":403,"detail":"Forbidden"}

Unacceptable content:

    HTTP/1.1 415 Unsupported Media Type
    {"type":"http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html","title":"Unsupported Media Type","status":415,"detail":"Invalid content-type specified"}

Cannot determine file upload type:

    HTTP/1.1 406
    {"type":"http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html","title":"Not Acceptable","status":406,"detail":"Your request could not be resolved to an acceptable representation."}
