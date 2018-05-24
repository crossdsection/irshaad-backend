<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvCountriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvCountriesTable Test Case
 */
class WvCountriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvCountriesTable
     */
    public $WvCountries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_countries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WvCountries') ? [] : ['className' => WvCountriesTable::class];
        $this->WvCountries = TableRegistry::get('WvCountries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvCountries);

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
}
