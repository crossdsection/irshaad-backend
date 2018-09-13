<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreaRatingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreaRatingsTable Test Case
 */
class AreaRatingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AreaRatingsTable
     */
    public $AreaRatings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.area_ratings',
        'app.area_levels',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AreaRatings') ? [] : ['className' => AreaRatingsTable::class];
        $this->AreaRatings = TableRegistry::getTableLocator()->get('AreaRatings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AreaRatings);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
