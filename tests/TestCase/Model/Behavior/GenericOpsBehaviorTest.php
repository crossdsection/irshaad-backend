<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\GenericOpsBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\GenericOpsBehavior Test Case
 */
class GenericOpsBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\GenericOpsBehavior
     */
    public $GenericOps;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->GenericOps = new GenericOpsBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GenericOps);

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
