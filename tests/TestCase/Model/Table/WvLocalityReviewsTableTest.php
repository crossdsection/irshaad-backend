<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvLocalityReviewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvLocalityReviewsTable Test Case
 */
class WvLocalityReviewsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvLocalityReviewsTable
     */
    public $WvLocalityReviews;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_locality_reviews',
        'app.cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WvLocalityReviews') ? [] : ['className' => WvLocalityReviewsTable::class];
        $this->WvLocalityReviews = TableRegistry::get('WvLocalityReviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvLocalityReviews);

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
