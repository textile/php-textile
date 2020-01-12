Contributing
=====

Please take a quick look at this document before to make contribution process easier for all parties involved.

License
-----

[BSD 3-Clause](https://github.com/textile/php-textile/blob/master/LICENSE). By contributing code, you agree to license
your additions under the BSD 3-Clause license.

Versioning
-----

[Semantic Versioning](https://semver.org) and major.minor.path format:

* Only major versions can make incompatible API changes.
* Minor versions can add backwards-compatible features and changes.
* Patch versions should only contain fixes.

Keep backwards compatibility in mind when you do changes to the Textile language, its processing or to the application
interface.

Coding standard
-----

The project follows the [PSR-4](https://www.php-fig.org/psr/psr-4/) and [PSR-12](https://www.php-fig.org/psr/psr-12/)
standards.

Configure git
-----

For convenience your committer, git user, should be linked to your GitHub account:

```
$ git config --global user.name "John Doe"
$ git config --global user.email john.doe@example.com
```

Make sure to use an email address that is linked to your GitHub account. It can be a throwaway address or you can use
GitHub's email protection features. We don't want your emails, but this is to make sure we know who did what.
All commits nicely link to their author, instead of them coming from foobar@invalid.tld.

Development
-----

The project follows coding standards and uses various development tools ensure code quality and help with development
process.

### Requirements

Requirements depend on how the tools are ran. Development tools can either be ran within Docker containers, or natively
on the host machine.

#### Running inside containers

When ran with Docker:

* git
* Docker
* Make

#### Running natively on the host machine

On host machine PHP must be configured so that it can work with the development dependencies:

* git
* PHP >= 7.2
* ext-xml
* ext-json
* ext-mbstring
* Composer

### Example workflow

In the most simplest case, your PR process would look like:

```
$ git pull
$ git checkout -b fix/my-bug-fix-branch
# Doing some edits
$ make test
$ git commit
$ git push
# Create PR on GitHub
```

Linting, testing and code coverage
-----

The project uses [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) for checking coding style,
[PHPunit](https://phpunit.de) for running its unit tests and [PHPStan](https://github.com/phpstan/phpstan) for static
analysis.

As much of the codebase should be covered with tests as possible, and majority of that is done through fixtures to
ensure that the Textile parser gives out consistent results. When adding new features, also add tests for them.
If you find a bug, create a test that can replicate the said bug and, if possible, fix it so that the tests pass.

Tests should pass before the changes can be merged to the codebase. If you create a pull requests that does not pass
tests, CI will complain in the pull request thread. To get your changes merged, you should rework the code or tests
until everything works smoothly.

### Running tests and linters

#### Docker

When using Docker, commands can be ran through make and there are no additional requirements that must be fulfilled.

```
$ make
```

The above will setup the whole environment and reset and update dependencies if re-ran. If the container environment
has already been set up, you can re-run specific step, such as just the linter or tests:

```
$ make cs
$ make test
```

To see available steps:

```
$ make help
```

Code style violations can be fixed with:

```
$ make csfix
```

#### Natively

Running tests requires PHP >=7.2.0 and PCRE with PCRE_UTF8 support, and for dependencies to be installed through
Composer. Generating optional code coverage reports requires [Xdebug](https://xdebug.org).

```
$ composer install
$ composer cs
$ composer test
```

Code style violations can be fixed with:

```
$ composer csfix
```
