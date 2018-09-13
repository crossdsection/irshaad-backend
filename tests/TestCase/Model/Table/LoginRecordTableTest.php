<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoginRecordTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoginRecordTable Test Case
 */
class LoginRecordTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LoginRecordTable
     */
    public $LoginRecord;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.login_record',
        'app.user'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LoginRecord') ? [] : ['className' => LoginRecordTable::class];
        $this->LoginRecord = TableRegistry::getTableLocator()->get('LoginRecord', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LoginRecord);

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
