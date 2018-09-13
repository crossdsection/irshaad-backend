<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OauthTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OauthTable Test Case
 */
class OauthTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OauthTable
     */
    public $Oauth;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.oauth',
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
        $config = TableRegistry::getTableLocator()->exists('Oauth') ? [] : ['className' => OauthTable::class];
        $this->Oauth = TableRegistry::getTableLocator()->get('Oauth', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Oauth);

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
