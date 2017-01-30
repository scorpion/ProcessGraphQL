<?php

namespace ProcessWire\GraphQL\Field\Page;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\NonNullType;

abstract class AbstractPageField extends AbstractField {

  public function resolve($value, array $args, ResolveInfo $info)
  {
    $fieldName = $this->getName();
    return $value->$fieldName;
  }

}