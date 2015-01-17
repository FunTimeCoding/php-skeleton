# PHP Skeleton


## Operation

Run scripts.

```sh
bin/example-script
```


## Testing

Install test tools.

```sh
curl -sS https://getcomposer.org/installer | php
./composer.phar install
```

Run tests.

```sh
./phpunit.sh
```

Run ant like Jenkins. Requires `ant` and `graphviz` to be installed.

```sh
ant
```


## Important details

* Composer installs executable scripts in `vendor/bin/php` to leave `bin` for the actual project.
* The script `phpunit.sh` is merely a wrapper intended for ease of use.
* The directories `src/LanguageExample` and `test/LanguageExample` are for sharing language specific knowledge.
