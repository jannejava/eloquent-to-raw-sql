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
                            $sql,
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