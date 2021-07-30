<?php

namespace Eastwest\EloquentToRawSql;


use DateTime;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\ServiceProvider;

class EloquentToRawSqlServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->addMacro();
    }

    protected function addMacro()
    {
        // Original idea by @therobfonz
        // https://twitter.com/kirschbaum_dev/status/1418590965368074241
        // Refined by BinaryKitten
        // https://gist.github.com/BinaryKitten/2873e11daf3c0130b5a19f6b94315033
        QueryBuilder::macro(
            'toRawSql',
            function () {
                return array_reduce(
                    $this->getBindings(),
                    static function ($sql, $binding) {
                        if ($binding instanceof DateTime) {
                            $binding = $binding->format('Y-m-d H:i:s');
                        }
                        return preg_replace(
                            '/\?/',
                            is_string($binding) ? "'" . $binding . "'" : $binding,
                            str_replace('"', '',$sql),
                            1
                        );
                    },
                    $this->toSql()
                );
            }
        );

        EloquentBuilder::macro(
            'toRawSql',
            function () {
                return $this->getQuery()->toRawSql();
            }
        );
    }
}
