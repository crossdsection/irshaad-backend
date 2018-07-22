<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvEmailVerificationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvEmailVerificationTable Test Case
 */
class WvEmailVerificationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvEmailVerificationTable
     */
    public $WvEmailVerification;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_email_verification',
        'app.wv_user'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WvEmailVerification') ? [] : ['className' => WvEmailVerificationTable::class];
        $this->WvEmailVerification = TableRegistry::getTableLocator()->get('WvEmailVerification', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvEmailVerification);

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
