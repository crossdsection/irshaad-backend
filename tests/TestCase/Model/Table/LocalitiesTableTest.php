<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocalitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocalitiesTable Test Case
 */
class LocalitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LocalitiesTable
     */
    public $Localities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.localities',
        'app.cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Localities') ? [] : ['className' => LocalitiesTable::class];
        $this->Localities = TableRegistry::getTableLocator()->get('Localities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Localities);

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
