# Eloquent toRawSQL

Output the full, unparameterized query in Laravel so you can paste it right into your database GUI.

Example:

```php

$user = User::where('id', 1)->toRawSql();


dump($user);

// "select * from `users` where `id` = 1"



```

## How to install

`composer require eastwest/eloquent-to-raw-sql`


