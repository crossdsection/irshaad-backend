<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvAreaRatingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvAreaRatingsTable Test Case
 */
class WvAreaRatingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvAreaRatingsTable
     */
    public $WvAreaRatings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_area_ratings',
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
        $config = TableRegistry::getTableLocator()->exists('WvAreaRatings') ? [] : ['className' => WvAreaRatingsTable::class];
        $this->WvAreaRatings = TableRegistry::getTableLocator()->get('WvAreaRatings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvAreaRatings);

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
