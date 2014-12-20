# PHP Skeleton


## Development

Install Composer.

Source: http://getcomposer.org/download

```sh
curl -sS https://getcomposer.org/installer | php
```

Install PHPUnit.

```sh
./composer.phar install
```

Run tests.

```sh
vendor/bin/phpunit
```


## Continuous integration

Install dependencies on OS X.

```sh
brew install graphviz
```

Build project like a CI job.

```sh
ant
```

Enable colors in ant output.

```sh
export ANT_ARGS='-logger org.apache.tools.ant.listener.AnsiColorLogger'
```


## Documentation

Read phpdoc documentation.

```sh
ant
cd build/phpdoc
python -m SimpleHTTPServer 8080
```
