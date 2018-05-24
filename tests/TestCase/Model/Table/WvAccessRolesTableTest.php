<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvAccessRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvAccessRolesTable Test Case
 */
class WvAccessRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvAccessRolesTable
     */
    public $WvAccessRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_access_roles',
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
        $config = TableRegistry::exists('WvAccessRoles') ? [] : ['className' => WvAccessRolesTable::class];
        $this->WvAccessRoles = TableRegistry::get('WvAccessRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvAccessRoles);

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
