# CollectionType
================

[![License](https://poser.pugx.org/mparulski/collection-type/license.svg)](https://packagist.org/packages/mparulski/collection-type)
[![Latest Stable Version](https://poser.pugx.org/mparulski/collection-type/v/stable.svg)](https://packagist.org/packages/mparulski/collection-type)
[![Total Downloads](https://poser.pugx.org/mparulski/collection-type/downloads)](https://packagist.org/packages/mparulski/collection-type)

CollectionType is a library that provides Collection and Map with their subtypes which are checking types of data set for PHP.

## Requirements
---------------

* PHP 5.5.0 or higher

## Installation
---------------

CollectionType officially supports only installation through Composer. For Composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

Install the module:

```sh
$ php composer.phar require mparulski/collection-type:0.4.0
```

## Example:
-----------
    
```php
use CollectionType\Collection\CollectionSet\HashSet;
use CollectionType\TypeValidator\ObjectTypeValidator;
    
$set = new HashSet(new IntegerTypeValidator());
    
$set->add(1);
$set->add(5);

// throw exception
$set->add(7.2);
```

## Documentation
----------------

Documentation is available in the [/docs](/docs) folder.

# LICENSE

Copyright (c) 2015 Michał Parulski http://opensource.org/licenses/MIT

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

This software consists of voluntary contributions made by many individuals
and is licensed under the MIT license.