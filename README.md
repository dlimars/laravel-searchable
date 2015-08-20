[![Build Status](https://travis-ci.org/dlimars/laravel-searchable.svg)](https://travis-ci.org/dlimars/laravel-searchable)

# Laravel Searchable
a simple trait to use with your Laravel Models

## Instalation
open terminal and run:
```composer require dlimars/laravel-searchable```

## Configuration
just add in your models
```php
    class MyModel extends Model {
        use Dlimars\LaravelSearchable\Searchable;
        private $searchable = [
            'name'          => 'LIKE',
            'created_at'    => 'BETWEEN',
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
