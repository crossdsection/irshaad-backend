<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FileuploadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FileuploadsTable Test Case
 */
class FileuploadsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FileuploadsTable
     */
    public $Fileuploads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fileuploads'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Fileuploads') ? [] : ['className' => FileuploadsTable::class];
        $this->Fileuploads = TableRegistry::getTableLocator()->get('Fileuploads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fileuploads);

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
}
