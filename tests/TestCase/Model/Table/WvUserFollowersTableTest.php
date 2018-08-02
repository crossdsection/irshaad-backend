<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvUserFollowersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvUserFollowersTable Test Case
 */
class WvUserFollowersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvUserFollowersTable
     */
    public $WvUserFollowers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_user_followers',
        'app.users',
        'app.followusers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WvUserFollowers') ? [] : ['className' => WvUserFollowersTable::class];
        $this->WvUserFollowers = TableRegistry::getTableLocator()->get('WvUserFollowers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvUserFollowers);

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
