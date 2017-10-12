# PhpSkeleton

## Usage

This section explains how to use this project.

Run the main entry point program.

```sh
bin/ps
```


## Development

This section explains how to use scripts that are intended to ease the development of this project.

Install development tools.

```sh
composer install
```

Run code style check, metrics and tests.

```sh
./style-check.sh
./metrics.sh
./tests.sh
```

Build the project like Jenkins.

```sh
./build.sh
```


## Important details

* Composer installs executable scripts in `vendor/bin/php` to leave `bin` for the actual project.
* The directories `src/LanguageExample` and `test/LanguageExample` are for sharing language specific knowledge.
