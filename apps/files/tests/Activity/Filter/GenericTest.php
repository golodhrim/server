<?php
/**
 * @copyright Copyright (c) 2016 Joas Schilling <coding@schilljs.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Files\Tests\Activity\Filter;


use OCA\Files\Activity\Filter\Favorites;
use OCA\Files\Activity\Filter\FileChanges;
use OCP\Activity\IFilter;
use Test\TestCase;

/**
 * Class GenericTest
 *
 * @package OCA\Files\Tests\Activity\Filter
 * @group DB
 */
class GenericTest extends TestCase {

	public function dataFilters() {
		return [
			[Favorites::class],
			[FileChanges::class],
		];
	}

	/**
	 * @dataProvider dataFilters
	 * @param string $filterClass
	 */
	public function testImplementsInterface($filterClass) {
		$filter = \OC::$server->query($filterClass);
		$this->assertInstanceOf(IFilter::class, $filter);
	}

	/**
	 * @dataProvider dataFilters
	 * @param string $filterClass
	 */
	public function testGetIdentifier($filterClass) {
		/** @var IFilter $filter */
		$filter = \OC::$server->query($filterClass);
		$this->assertInternalType('string', $filter->getIdentifier());
	}

	/**
	 * @dataProvider dataFilters
	 * @param string $filterClass
	 */
	public function testGetName($filterClass) {
		/** @var IFilter $filter */
		$filter = \OC::$server->query($filterClass);
		$this->assertInternalType('string', $filter->getName());
	}

	/**
	 * @dataProvider dataFilters
	 * @param string $filterClass
	 */
	public function testGetPriority($filterClass) {
		/** @var IFilter $filter */
		$filter = \OC::$server->query($filterClass);
		$priority = $filter->getPriority();
		$this->assertInternalType('int', $filter->getPriority());
		$this->assertGreaterThanOrEqual(0, $priority);
		$this->assertLessThanOrEqual(100, $priority);
	}

	/**
	 * @dataProvider dataFilters
	 * @param string $filterClass
	 */
	public function testGetIcon($filterClass) {
		/** @var IFilter $filter */
		$filter = \OC::$server->query($filterClass);
		$this->assertInternalType('string', $filter->getIcon());
		$this->assertStringStartsWith('http', $filter->getIcon());
	}

	/**
	 * @dataProvider dataFilters
	 * @param string $filterClass
	 */
	public function testFilterTypes($filterClass) {
		/** @var IFilter $filter */
		$filter = \OC::$server->query($filterClass);
		$this->assertInternalType('array', $filter->filterTypes([]));
	}

	/**
	 * @dataProvider dataFilters
	 * @param string $filterClass
	 */
	public function testAllowedApps($filterClass) {
		/** @var IFilter $filter */
		$filter = \OC::$server->query($filterClass);
		$this->assertInternalType('array', $filter->allowedApps());
	}
}
