# Jinx: The Unlucky Framework
The Jinx MVC Framework is a mini PHP framework created to provide a simple library for building websites.

This framework was created to build custom CTF websites for vulnerability testing, local development and testing, 

You can get started by running the following command using `composer`:

```bash
composer require azazelm3dj3d/jinx
```

If you're interested in trying the framework out for yourself, I am working on creating some simple documentation and an example website to showcase the current abilities of the framework. If you would like to go ahead and try the framework out before these are available, there are some helpful commands below.

NOTE: Requires `php` CLI to be installed and available in the PATH.

This will start up a local development environment using the PHP CLI:

```bash
php -S localhost:8080
```

A good project structure to work with the framework is the following:

```bash
├── composer.json
├── public
│   └── index.php
└── views
    ├── home.php
    ├── layouts
        └── main.php
```

This is obviously a terrible example without the associated code, but this is how the example website will be initially structured with more files.

Development is still in very early stages, but should be stable enough to use in most cases. It's not recommended to push the code in this framework to production as Jinx is specifically built to provide a configurable vulnerable website.