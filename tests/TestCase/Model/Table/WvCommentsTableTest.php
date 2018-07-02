<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvCommentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvCommentsTable Test Case
 */
class WvCommentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvCommentsTable
     */
    public $WvComments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_comments',
        'app.users',
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
        $config = TableRegistry::getTableLocator()->exists('WvComments') ? [] : ['className' => WvCommentsTable::class];
        $this->WvComments = TableRegistry::getTableLocator()->get('WvComments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvComments);

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
