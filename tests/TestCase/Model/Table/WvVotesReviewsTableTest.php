<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WvVotesReviewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WvVotesReviewsTable Test Case
 */
class WvVotesReviewsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WvVotesReviewsTable
     */
    public $WvVotesReviews;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wv_votes_reviews',
        'app.users',
        'app.ministries',
        'app.countries',
        'app.states',
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
        $config = TableRegistry::exists('WvVotesReviews') ? [] : ['className' => WvVotesReviewsTable::class];
        $this->WvVotesReviews = TableRegistry::get('WvVotesReviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WvVotesReviews);

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
