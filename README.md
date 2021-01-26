# Tools for Building a Professional Laravel API

## Installation

To install this package, run the following command:
```bash
composer require towerdigital/tools
```

To generate a Repository:

```bash
php artisan make:repository --model=User
```

This will create a new UserRepository class file located in the `Repositories` directory.  The directory will be created if it doesn't yet exist.

To generate a Transformer:

```bash
php artisan make:transformer --model=User
```

Transformers are a creation from another package `league/fractal` that were adopted and applied to Laravel.