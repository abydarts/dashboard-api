<?php
/**
 * Format
 * @package admin-ui
 * @version 0.12.2
 */

namespace AdminUi\Library;

use LibFormatter\Library\Formatter;

class Format
{
    static function fileList($value, string $field, object $object, object $format, $options): ?array{
        $value = json_decode($value);
        if(!$value)
            return null;
        return Formatter::formatMany('aui-std-file-list', $value);
    }
}