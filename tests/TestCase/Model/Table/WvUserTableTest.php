<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvUserTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvUserTable Test Case
 */
class WvUserTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvUserTable
     */
    public $WvUser;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('WvUser') ? [] : ['className' => WvUserTable::class];
        $this->WvUser = TableRegistry::get('WvUser', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvUser);

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
