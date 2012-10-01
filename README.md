# Crust
## (CRUD + REST lameness!)

Simple PHP app with an ExtJS frontend, which translates a random database (that is supported by PDO, and for now only MySQL) and sets up a simple REST interface for the data contained in that database.

It's quick, it's dirty, and definitively not meant for any production environment!

## Install

* Place this project somewhere outside of your docroot (`/var/www` etc), and place a symlink in your docroot to the `public` directory.

* Find yourself a distribution of ExtJS (4.1.1a-gpl is the one I'm using) and unzip into `public/scripts/extjs`.

## It doesn't work, what now?!

Well, yeah, at the moment the Ext interface is hardwired to look for resources and entities with `/~dev/crust/blabla` as base URL. I'll make this configurable in a bit. Standby for now.

