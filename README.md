# Laravel Searchable
[![Build Status](https://travis-ci.org/dlimars/laravel-searchable.svg)](https://travis-ci.org/dlimars/laravel-searchable)

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
            'id'            => 'MATCH'
        ];
    }
```

## Usage
just call ```search()``` method in model
```php
    $filters = [
        'name' => 'User test'
    ];
    $users = User::search($filters)->get();
    // produces $query->where('name', 'LIKE', '%User%')
    //                ->where('name', 'LIKE', '%test%')
```

you can also use with request
```php
    $users = User::search($request()->all())->get();
```

## Operators
```php
    'LIKE'  // produces $query->where('field', 'LIKE', '%{$value}%')
    'MATCH' // produces $query->where('field', $value)
```
