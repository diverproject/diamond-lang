# Diamond Lang

Basic library for any project and dependence library for anothers diamond projects.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.
See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You need have [Composer](https://getcomposer.org/) to install Diamond.

```
$ composer require diverproject/diamond-lang "^3.0"
```

### Installing

To execute all test cases (or suite) you need `PHP Unit`

```
$ phpunit
```

1. Set system environment, this can apply different reactions, see wiki classes affected by this setting or classes documentation. For example, when running PHP Unit, enable `ENVIRONMENT_TEST_CASE` and using `diamond\test\lang\AbstractDiamondTest`

```
Diamond::setEnvironment(Diamond::ENVIRONMENT_HOMOLOG); // Options: ENVIRONMENT_HOMOLOG, ENVIRONMENT_TEST_CASE or ENVIRONMENT_PRODUCTION
```

2. Set throws exceptions from parsing methods into different classes, see wiki methods affected by this setting or methods documentation. When enabled, parsing failures will throws a Exception otherwise will return `NULL` or a default value if it's possible. Some cases a default value don't help treat the problem them will return `NULL`.

```
Diamond::setEnabledParseThrows(TRUE); // Options: TRUE or FALSE
```

That's it, don't forget `include` library when use composer like `include 'vendor/autoload.php` (will depend of your system file structure)

## Running the tests

The test scripts are located on `test` root folder.

### Composer update

First all update dependences libraries and generate `vendor autoload` of composer:

```
$ composer update

or if you are in Windows execute 'composer-update.bat' (it's more easy) - it's same think as above
```

Now you can execute `PHP Unit` and check tests results, there are 2 ways:

The first way and more easy is execute `phpunit.bat`; check the content file to understand and if you didn't know `PHP Unit` check this link [here](https://phpunit.de/).

The second way is work only if you open the project into `Eclipse PHP`, setting `PHP Unit Preferences` and running individual scripts or selecting one or more and running.

### Observation

Some classes will not have a tests scripts because need something else to work, like `Cookie`, `Get`, `Post` and `Session` classes into `diamond\lang\http`.

And if you see some problemns or classes without tests scripts tell us.

## Deployment

**DON'T FORGET** change setting your environment system running type to

```
Diamond::setEnvironment(Diamond::ENVIRONMENT_PRODUCTION);
```

## Built With

* [Composer](https://getcomposer.org/) - Dependency Manager Framework

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/diverproject/diamond-lang/tags).

*The revision log have somethings different because it's used developers found more easy changes made and make github commit messages more **clean***.

## Authors

* **Andrew Mello da Silva** - *Developer* - [Driw](https://github.com/Driw)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* **Billie Thompson** - *[Readme template](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2)* - [PurpleBooth](https://github.com/PurpleBooth)
