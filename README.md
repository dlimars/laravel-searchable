# Laravel Searchable
[![Build Status](https://travis-ci.org/dlimars/laravel-searchable.svg)](https://travis-ci.org/dlimars/laravel-searchable)
[![Latest Stable Version](https://poser.pugx.org/dlimars/laravel-searchable/v/stable)](https://packagist.org/packages/dlimars/laravel-searchable)
[![Total Downloads](https://poser.pugx.org/dlimars/laravel-searchable/downloads)](https://packagist.org/packages/dlimars/laravel-searchable)
[![Latest Unstable Version](https://poser.pugx.org/dlimars/laravel-searchable/v/unstable)](https://packagist.org/packages/dlimars/laravel-searchable)
[![License](https://poser.pugx.org/dlimars/laravel-searchable/license)](https://packagist.org/packages/dlimars/laravel-searchable)

a simple trait to use with your Laravel Models

## Installation
open terminal and run:
```composer require dlimars/laravel-searchable```

## Configuration
just add in your models
```php
    class MyModel extends Model {
        use Dlimars\LaravelSearchable\Searchable;
        private $searchable = [
            'name'          => 'LIKE',
            'id'            => 'MATCH',
            'created_at'    => 'BETWEEN'
        ];
    }
```

## Usage
just call ```search()``` method in model
```php
    $filters = [
        'name'          => 'foo bar',
        'id'            => '10',
        'created_at'    => ['2010-01-01 00:00:00', '2015-01-01 23:59:59']
    ];

    $users = User::search($filters)->get();
    // produces $query->where('name', 'LIKE', '%foo%')
    //                ->where('name', 'LIKE', '%bar%')
    //                ->where('id', '10')
    //                ->where('created_at', '>=', '2010-01-01 00:00:00')
    //                ->where('created_at', '<=', '2015-01-01 23:59:59')

    $filters = [
        'created_at'    => ['2010-01-01 00:00:00', null]
    ];
    //  produces $query->where('created_at', '>=', '2010-01-01 00:00:00')

    $filters = [
        'created_at'    => [null, '2015-01-01 23:59:59']
    ];
    //  produces $query->where('created_at', '<=', '2015-01-01 23:59:59')
```

you can also use with request
```php
    $users = User::search($request()->all())->get();
```

## Operators
```php
    'LIKE'      // produces $query->where('field', 'LIKE', '%{$value}%')
    'MATCH'     // produces $query->where('field', $value)
    'BETWEEN'   // produces $query->where('field', '>=', $value[0])
                //                ->where('field', '<=', $value[1])
```