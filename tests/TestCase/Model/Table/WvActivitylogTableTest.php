<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvActivitylogTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvActivitylogTable Test Case
 */
class WvActivitylogTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvActivitylogTable
     */
    public $WvActivitylog;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_activitylog',
        'app.wv_post',
        'app.wv_user'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WvActivitylog') ? [] : ['className' => WvActivitylogTable::class];
        $this->WvActivitylog = TableRegistry::get('WvActivitylog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvActivitylog);

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
