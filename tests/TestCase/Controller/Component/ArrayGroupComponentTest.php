<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ArrayGroupComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ArrayGroupComponent Test Case
 */
class ArrayGroupComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\ArrayGroupComponent
     */
    public $ArrayGroup;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ArrayGroup = new ArrayGroupComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArrayGroup);

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
