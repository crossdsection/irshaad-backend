<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvPostTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvPostTable Test Case
 */
class WvPostTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvPostTable
     */
    public $WvPost;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_post',
        'app.wv_departments',
        'app.wv_users',
        'app.wv_countries',
        'app.wv_states',
        'app.wv_cities',
        'app.wv_localities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WvPost') ? [] : ['className' => WvPostTable::class];
        $this->WvPost = TableRegistry::getTableLocator()->get('WvPost', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvPost);

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
