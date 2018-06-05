<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvDepartmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvDepartmentsTable Test Case
 */
class WvDepartmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvDepartmentsTable
     */
    public $WvDepartments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_departments',
        'app.wv_countries',
        'app.wv_states',
        'app.wv_cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WvDepartments') ? [] : ['className' => WvDepartmentsTable::class];
        $this->WvDepartments = TableRegistry::getTableLocator()->get('WvDepartments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvDepartments);

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
