<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitylogTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivitylogTable Test Case
 */
class ActivitylogTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivitylogTable
     */
    public $Activitylog;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.activitylog',
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
        $config = TableRegistry::getTableLocator()->exists('Activitylog') ? [] : ['className' => ActivitylogTable::class];
        $this->Activitylog = TableRegistry::getTableLocator()->get('Activitylog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Activitylog);

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
