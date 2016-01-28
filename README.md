Veridu PHP SDK
==============

[![Latest Stable Version](https://poser.pugx.org/veridu/gateway-php/v/stable.png)](https://packagist.org/packages/veridu/gateway-php)
[![Total Downloads](https://poser.pugx.org/veridu/gateway-php/downloads.png)](https://packagist.org/packages/veridu/gateway-php)

Installation
------------
This library can be found on [Packagist](https://packagist.org/packages/veridu/gateway-php).
The recommended way to install this is through [composer](http://getcomposer.org).

Edit your `composer.json` and add:

```json
{
    "require": {
        "veridu/gateway-php": "~0.1"
    }
}
```

And install dependencies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

Features
--------
 - PSR-0 compliant for easy interoperability

Bugs and feature requests
-------------------------
Have a bug or a feature request? [Please open a new issue](https://github.com/veridu/gateway-php/issues).
Before opening any issue, please search for existing issues and read the [Issue Guidelines](https://github.com/necolas/issue-guidelines), written by [Nicolas Gallagher](https://github.com/necolas/).

Versioning
----------
This SDK will be maintained under the Semantic Versioning guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

For more information on SemVer, please visit [http://semver.org/](http://semver.org/).

Copyright and license
---------------------

Copyright (c) 2013/2016 - Veridu Ltd - [http://veridu.com](veridu.com)
