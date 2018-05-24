<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvDetailsReviewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvDetailsReviewsTable Test Case
 */
class WvDetailsReviewsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvDetailsReviewsTable
     */
    public $WvDetailsReviews;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_details_reviews',
        'app.countries',
        'app.cities',
        'app.localities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WvDetailsReviews') ? [] : ['className' => WvDetailsReviewsTable::class];
        $this->WvDetailsReviews = TableRegistry::get('WvDetailsReviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvDetailsReviews);

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
