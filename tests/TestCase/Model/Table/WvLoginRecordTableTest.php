<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvLoginRecordTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvLoginRecordTable Test Case
 */
class WvLoginRecordTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvLoginRecordTable
     */
    public $WvLoginRecord;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_login_record',
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
        $config = TableRegistry::getTableLocator()->exists('WvLoginRecord') ? [] : ['className' => WvLoginRecordTable::class];
        $this->WvLoginRecord = TableRegistry::getTableLocator()->get('WvLoginRecord', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvLoginRecord);

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
