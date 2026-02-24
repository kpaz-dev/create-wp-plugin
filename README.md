# create-wp-plugin
CLI tool to create the basic structure of a WordPress plugin

## Requirements
- PHP >= 8.3
- Composer >= 8.5


## Global installation
To install the tool globally, run the following command:
```bash
composer global require kpaz-dev/create-wp-plugin
```
Make sure to add `~/.composer/vendor/bin` to your `PATH` environment variable.

## Example Usage
To create a new WordPress plugin, run the following command:
```bash
create-wp-plugin my-plugin
```
This will create a new directory named `my-plugin` with the basic structure of a WordPress plugin.