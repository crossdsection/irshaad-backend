<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailVerificationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailVerificationTable Test Case
 */
class EmailVerificationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailVerificationTable
     */
    public $EmailVerification;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.email_verification',
        'app.user'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailVerification') ? [] : ['className' => EmailVerificationTable::class];
        $this->EmailVerification = TableRegistry::getTableLocator()->get('EmailVerification', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailVerification);

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
