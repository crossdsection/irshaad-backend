<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvUserPollsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvUserPollsTable Test Case
 */
class WvUserPollsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvUserPollsTable
     */
    public $WvUserPolls;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_user_polls',
        'app.users',
        'app.polls',
        'app.posts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WvUserPolls') ? [] : ['className' => WvUserPollsTable::class];
        $this->WvUserPolls = TableRegistry::getTableLocator()->get('WvUserPolls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvUserPolls);

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
