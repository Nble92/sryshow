# Lucid Support

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/lucid-support?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/lucid-support.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/lucid-support.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/decodelabs/lucid-support/integrate.yml?branch=develop)](https://github.com/decodelabs/lucid-support/actions/workflows/integrate.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-44CC11.svg?longCache=true&style=flat)](https://github.com/phpstan/phpstan)
[![License](https://img.shields.io/packagist/l/decodelabs/lucid-support?style=flat)](https://packagist.org/packages/decodelabs/lucid-support)

### Support Lucid sanitisation in your libraries without the dependencies

Lucid-support is a middleware package that allows third party libraries to implement the necessary interfaces and provide custom sanitiser and validator functionality to Lucid without dragging in the full dependency tree of the main library.

_Get news and updates on the [DecodeLabs blog](https://blog.decodelabs.com)._

---


## Installation

Install the library via composer:

```bash
composer require decodelabs/lucid-support
```

## Usage
[Lucid](https://github.com/decodelabs/lucid) provides interfaces and traits to implement providing input sanitisation from your own value container objects.

The main library however has a substantial dependency list which may not be desirable when deploying the Lucid Provider interfaces in your own libraries.

Instead, those interfaces have been sectioned off in this package with a <code>class_exists()</code> check to ensure that Lucid is available at runtime.

If you want to provide Lucid's sanitisation interface in a library, you only need to require _this_ package, and implement either <code>[DirectContextProvider](./src/Sanitizer/DirectContextProvider.php)</code> (for passing the value directly to the methods), <code>[MultiContextProvider](./src/Sanitizer/MultiContextProvider.php)</code> (for dictionaries and maps) or <code>[SingleContextProvider](./src/Sanitizer/SingleContextProvider.php)</code> (for single-value objects).

For example:

```php
namespace My\Library;

use DecodeLabs\Lucid\Provider\SingleContext;
use DecodeLabs\Lucid\Provider\SingleContextTrait;

class MyClass implements SingleContext {

    use SingleContextTrait;

    protected mixed $value;

    public function __construct(mixed $value) {
        $this->value = $value;
    }

    /**
     * This method provides the value to all other
     * sanitisation methods in the interface
     */
    public function getValue(): mixed {
        return $this->value;
    }
}
```

## Licensing
Lucid Support is licensed under the MIT License. See [LICENSE](./LICENSE) for the full license text.
