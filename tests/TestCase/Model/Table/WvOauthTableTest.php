<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvOauthTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvOauthTable Test Case
 */
class WvOauthTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvOauthTable
     */
    public $WvOauth;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_oauth',
        'app.users',
        'app.providers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WvOauth') ? [] : ['className' => WvOauthTable::class];
        $this->WvOauth = TableRegistry::getTableLocator()->get('WvOauth', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvOauth);

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
