<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\OAuthComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\OAuthComponent Test Case
 */
class OAuthComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\OAuthComponent
     */
    public $OAuth;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->OAuth = new OAuthComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OAuth);

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
