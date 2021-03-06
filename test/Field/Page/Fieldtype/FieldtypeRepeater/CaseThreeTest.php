<?php

namespace ProcessWire\GraphQL\Test\Field\Page\Fieldtype;

use ProcessWire\GraphQL\Utils;
use \ProcessWire\GraphQL\Test\GraphQLTestCase;

class FieldtypeRepeaterCaseThreeTest extends GraphQLTestCase {

  const settings = [
    'login' => 'admin',
    'legalTemplates' => ['home', 'list-all'],
    'legalFields' => ['slides', 'title', 'body', 'selected'],
  ];

	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
		Utils::templates()->get("name=list-all")->noParents = '';
	}

	public static function tearDownAfterClass()
	{
		Utils::templates()->get("name=list-all")->noParents = '1';
		parent::tearDownAfterClass();
	}

  public function testValue()
  {
		$page = Utils::pages()->get("template=list-all, slides.count=3");
		assertEquals(3, count($page->slides));

  	$query = 'mutation updatePage ($page: ListAllUpdateInput!){
			updateListAll(page:$page) {
				slides {
					getTotal,
					list{
						id
					}
				}
			}
		}';
		$variables = [
			"page" => [
				"id" => $page->id,
				"slides" => [
					"remove" => [5754]
				]
			]
		];

		$res = self::execute($query, $variables);
  	assertEquals(
			2,
  		$res->data->updateListAll->slides->getTotal,
  		'Removes the correct amount of repeaters.'
		);
		assertEquals(
			"5755",
			$res->data->updateListAll->slides->list[0]->id,
			"Removes the correct repeater items."
		);
		assertObjectNotHasAttribute('errors', $res, 'There are errors.');
	}
}