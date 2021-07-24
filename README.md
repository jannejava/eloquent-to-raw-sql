# Eloquent toRawSQL

Output the full, unparameterized query in Laravel so you can paste it right into your database GUI.

All credit goes to @therobfonz and https://gist.github.com/BinaryKitten/2873e11daf3c0130b5a19f6b94315033

Example:

```php

$user = User::where('id', 1)->toRawSql();


dump($user);

// "select * from `users` where `id` = 1"



```

