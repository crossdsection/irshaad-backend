<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvPollsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvPollsTable Test Case
 */
class WvPollsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvPollsTable
     */
    public $WvPolls;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_polls',
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
        $config = TableRegistry::getTableLocator()->exists('WvPolls') ? [] : ['className' => WvPollsTable::class];
        $this->WvPolls = TableRegistry::getTableLocator()->get('WvPolls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvPolls);

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
