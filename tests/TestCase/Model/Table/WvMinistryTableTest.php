<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvMinistryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvMinistryTable Test Case
 */
class WvMinistryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvMinistryTable
     */
    public $WvMinistry;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_ministry',
        'app.countries',
        'app.states',
        'app.cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WvMinistry') ? [] : ['className' => WvMinistryTable::class];
        $this->WvMinistry = TableRegistry::get('WvMinistry', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvMinistry);

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
