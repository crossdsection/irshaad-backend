<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\HashIdBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\HashIdBehavior Test Case
 */
class HashIdBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\HashIdBehavior
     */
    public $HashId;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->HashId = new HashIdBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HashId);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
