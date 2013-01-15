<?php

class MyRules
{
    public static function _validation_unique($val, $options)
    {
        list($table, $field) = explode('.', $options);

        $result = DB::select("LOWER (\"$field\")")
        ->where($field, '=', Str::lower($val))
        ->from($table)->execute();

        return ! ($result->count() > 0);
    }

    public function _validation_is_upper($val)
    {
        return $val === strtoupper($val);
    }

}