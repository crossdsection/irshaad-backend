<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ArrayOpsBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ArrayOpsBehavior Test Case
 */
class ArrayOpsBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ArrayOpsBehavior
     */
    public $ArrayOps;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ArrayOps = new ArrayOpsBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArrayOps);

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
