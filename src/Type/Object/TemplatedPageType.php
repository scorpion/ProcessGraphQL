<?php

namespace ProcessWire\GraphQL\Type\Object;

use ProcessWire\Template;
use ProcessWire\GraphQL\Type\Object\PageType;

class TemplatedPageType extends PageType {

  protected $template;

  public function __construct(Template $template)
  {
    $this->template = $template;
    parent::__construct([]);
  }

  public Static function normalizeName(string $name)
  {
    return str_replace('-', '_', $name);
  }

  public function getName()
  {
    return ucfirst(self::normalizeName($this->template->name)) . 'PageType';
  }

  public function getDescription()
  {
    $desc = $this->template->description;
    if ($desc) return $desc;
    return "PageType with template `" . $this->template->name . "`.";
  }

  public function build($config)
  {
    foreach ($this->template->fields as $field) {
      $className = "\\ProcessWire\\GraphQL\\Field\\Page\\Fieldtype\\" . $field->type->className();
      if (!class_exists($className)) continue;
      $config->addField(new $className($field));
    }
    parent::build($config);
  }

}