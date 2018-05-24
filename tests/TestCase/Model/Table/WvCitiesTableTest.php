<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvCitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvCitiesTable Test Case
 */
class WvCitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvCitiesTable
     */
    public $WvCities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_cities',
        'app.wv_states'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WvCities') ? [] : ['className' => WvCitiesTable::class];
        $this->WvCities = TableRegistry::get('WvCities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvCities);

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
