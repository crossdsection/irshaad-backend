<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserPollsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserPollsTable Test Case
 */
class UserPollsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserPollsTable
     */
    public $UserPolls;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_polls',
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
        $config = TableRegistry::getTableLocator()->exists('UserPolls') ? [] : ['className' => UserPollsTable::class];
        $this->UserPolls = TableRegistry::getTableLocator()->get('UserPolls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserPolls);

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
