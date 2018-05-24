<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvStatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvStatesTable Test Case
 */
class WvStatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvStatesTable
     */
    public $WvStates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_states',
        'app.wv_countries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WvStates') ? [] : ['className' => WvStatesTable::class];
        $this->WvStates = TableRegistry::get('WvStates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvStates);

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
