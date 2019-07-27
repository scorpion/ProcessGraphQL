<?php namespace ProcessWire\GraphQL\Type\Fieldtype;

use ProcessWire\GraphQL\Type\FileType;
use ProcessWire\GraphQL\Type\CacheTrait;
use GraphQL\Type\Definition\Type;

class File
{
  use CacheTrait;
  public static function type()
  {
    return self::cache('dafault', function () {
      return Type::listOf(FileType::type());
    });
    
  }

  public static function field($options)
  {
    return self::cache('field-' . $options['name'], function () use ($options) {
      return array_merge($options, [
        'type' => self::type(),
      ]);
    });
  }
}
