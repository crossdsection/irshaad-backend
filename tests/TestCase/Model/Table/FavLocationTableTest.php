<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FavLocationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FavLocationTable Test Case
 */
class FavLocationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FavLocationTable
     */
    public $FavLocation;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fav_location',
        'app.users',
        'app.departments',
        'app.countries',
        'app.states',
        'app.cities',
        'app.localities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FavLocation') ? [] : ['className' => FavLocationTable::class];
        $this->FavLocation = TableRegistry::getTableLocator()->get('FavLocation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FavLocation);

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

    /**
     * Test addLocation method
     *
     * @return void
     */
    public function testAddLocation()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
