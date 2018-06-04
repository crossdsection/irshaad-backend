<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvLocalitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvLocalitiesTable Test Case
 */
class WvLocalitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvLocalitiesTable
     */
    public $WvLocalities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_localities',
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
        $config = TableRegistry::getTableLocator()->exists('WvLocalities') ? [] : ['className' => WvLocalitiesTable::class];
        $this->WvLocalities = TableRegistry::getTableLocator()->get('WvLocalities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvLocalities);

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
