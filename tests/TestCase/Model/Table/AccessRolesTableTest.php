<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessRolesTable Test Case
 */
class AccessRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessRolesTable
     */
    public $AccessRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.access_roles',
        'app.area_levels'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AccessRoles') ? [] : ['className' => AccessRolesTable::class];
        $this->AccessRoles = TableRegistry::getTableLocator()->get('AccessRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccessRoles);

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
