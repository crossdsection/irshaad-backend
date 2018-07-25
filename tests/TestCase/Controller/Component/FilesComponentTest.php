<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\FilesComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\FilesComponent Test Case
 */
class FilesComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\FilesComponent
     */
    public $Files;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Files = new FilesComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Files);

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
