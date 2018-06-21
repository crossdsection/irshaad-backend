<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvFileuploadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvFileuploadsTable Test Case
 */
class WvFileuploadsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvFileuploadsTable
     */
    public $WvFileuploads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_fileuploads'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WvFileuploads') ? [] : ['className' => WvFileuploadsTable::class];
        $this->WvFileuploads = TableRegistry::getTableLocator()->get('WvFileuploads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvFileuploads);

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
